<?php

namespace Utils\Polls;

class Polls
{
    private $xmlPolls;
    private $xmlPath = 'data/polls.xml';
    private $cache;
    private $message;
    private $form;
    
    const CACHE_KEY = 'poll_voters';
    
    public function __construct()
    {
        $this->xmlPolls = new \SimpleXMLElement(file_get_contents($this->xmlPath));
        $this->cache = \Laminas\Cache\StorageFactory::factory(array(
            'adapter' => array(
                'name' => 'filesystem',
                'options' => array(
                    'cacheDir' => 'data/cache'
                )
            ),
            'plugins' => array(
                //do not throw execeptions, when cache key is not found
                'exception_handler' => array(
                    'throw_exceptions' => false
                )
            )
        ));
        
        //let's initiate an empty object as our starting cache, if cache does not exists yet
        if (!$this->cache->getItem(self::CACHE_KEY)) {
            $this->cache->setItem(self::CACHE_KEY, '{}');
        }
    }
    
    public function getAll()
    {
        return $this->xmlPolls;
    }
    
    public function getActive($getIndex = false)
    {
        $index = 0;
        
        foreach ($this->xmlPolls as $poll) {
            if ($poll['active'] == 'true') {
                return $getIndex ? $index : $poll;
            }
            $index++;
        }
        
        throw new \Exception('active poll not found');
    }
    
    public function getActiveInJson()
    {
        return \Laminas\Xml2Json\Xml2Json::fromXml($this->getActive()->asXML(), false);
    }
    
    public function activate($id)
    {
        $found = false;
        
        foreach ($this->xmlPolls as $poll) {
            if ($poll['id'] == $id) {
                $poll['active'] = 'true';
                $found = true;
            } else {
                $poll['active'] = 'false';
            }
        }
        
        if (!$found) {
            throw \Exception('poll not found with id: '.$id);
        }
        //store data into file
        $this->save();
    }
    
    public function canVote($givenAnswer)
    {
        $poll = $this->getActive();
        $result = $this->findAnswer($poll, $givenAnswer);
        $votersCache = json_decode($this->cache->getItem(self::CACHE_KEY), true);
        $ip = $this->getUserIp();

        if (!$result) {
            $this->message = 'Invalid answer';
            return false;
        }
        if (isset($votersCache[$ip])) {
            if ($votersCache[$ip] < time()) {
                //limit has expired, so let's delete a record from cache
                unset($votersCache[$ip]);
                $this->cache->setItem(self::CACHE_KEY, json_encode($votersCache));
            } else {
                $this->message = 'You have already voted';
                return false;
            }
        }
        
        return true;
    }
    
    public function addVote($givenAnswer)
    {
        $pollIndex = $this->getActive(true);
        $index = 0;

        foreach ($this->xmlPolls->poll[$pollIndex]->answers->answer as $answer) {
            if ($answer->__toString() === $givenAnswer) {
                //adding vote
                (int) $this->xmlPolls->poll[$pollIndex]->answers->answer[$index]['votes'] += 1;
                
                //store user date into cache too
                $votersCache = json_decode($this->cache->getItem(self::CACHE_KEY), true);
                $votersCache[$this->getUserIp()] = strtotime('+1 day');
                $this->cache->setItem(self::CACHE_KEY, json_encode($votersCache));
                
                //store data into file
                $this->save();
                return;
            }
            $index++;
        }
        
        throw new \Exception('vote has not been added');
    }
    
    public function getMessage()
    {
        return $this->message;
    }
    
    public function getForm()
    {
        if (!$this->form) {
            $answers = [];
            foreach ($this->getActive()->answers->answer as $answer) {
                if (empty($answer)) {
                    continue;
                }
                $answer = (string) $answer;
                $answers[$answer] = $answer;
            }
            $this->form = new \Utils\Polls\Form($answers);
        }
        return $this->form;
    }
    
    private function findAnswer($poll, $givenAnswer)
    {
        $found = false;
        
        if (empty($givenAnswer)) {
            return false;
        }
        foreach ($poll->answers->answer as $answer) {
            if ($answer->__toString() === $givenAnswer) {
                $found = true;
                break;
            }
        }
        
        return $found;
    }
    
    private function save()
    {
        file_put_contents($this->xmlPath, $this->xmlPolls->asXML());
    }
    
    private function getUserIp()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }
}