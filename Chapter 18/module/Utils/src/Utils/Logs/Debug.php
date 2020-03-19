<?php

namespace Utils\Logs;

use Laminas\Log\Logger;
use Laminas\Log\Writer\Stream;
use Laminas\Log\Filter\Priority;

class Debug
{
    protected static $logger;
    
    /**
    * @var array $debugMessages contains all debug messages 
    */
    public static $debugMessages = '';

    /**
    * Stores a message to the global contains with messages
    *
    * @param mixed $var a message to display/store
    * @param array $params available keys: log:Boolean = false, desc:String = 'short', exit:Boolean = false, display:Boolean = true
    *
    * @return void
    */
    public static function dump($var, $params = [])
    {
        if (empty($params['display'])) {
            $params['display'] = true;
        }
        if (empty($params['log'])){
            $params['log'] = false;
        }
        if (empty($params['exit'])) {
            $params['exit'] = false;
        }
        if (empty($params['desc'])) {
            $params['desc'] = 'short';
        }
        $debugBacktrace = debug_backtrace();
        $message = '<div><hr style="margin: 5px 0 0 0; border-top-color: #bfbfbf" /><hr style="margin: 0 0 3px 0;" />';

        switch ($params['desc']) {
            case 'short':
                $message .= '<strong>'.$debugBacktrace[0]['file'].'</strong> in line <strong>'.$debugBacktrace[0]['line'].'</strong>';
            break;
            case 'medium':
                $message .= self::getMediumMessage($debugBacktrace);
            break;
            case 'long':
                $message .= self::getLongMessage($debugBacktrace);
            break;
            default:
                throw new \Exception('invalid description provided: '.$params['desc']);
        }

        ob_start();
        dump($var);
        $message .= ob_get_contents();
        ob_end_clean();
        
        $message .= '</div>'.PHP_EOL;

        if ($params['display']) {
            self::$debugMessages .= $message;
        }
        
        if (!isset(self::$logger)) {
            $writer = new Stream(APPLICATION_PATH.'/data/logs/dump.log');
            $writer->addFilter(new Priority(Logger::INFO, '>='));

            self::$logger = new Logger();
            self::$logger->addWriter($writer);
            $errorsWriter = new Stream(APPLICATION_PATH.'/data/logs/errors.log');
            $errorsWriter->addFilter(new Priority(Logger::NOTICE));
            self::$logger->addWriter($errorsWriter);

            \Laminas\Log\Logger::registerErrorHandler(self::$logger, true);
            \Laminas\Log\Logger::registerFatalErrorShutdownFunction(self::$logger);
            \Laminas\Log\Logger::registerExceptionHandler(self::$logger);
        }

        if ($params['log']) {
            self::$logger->log(Logger::INFO, strip_tags(html_entity_decode($message, \ENT_QUOTES)));
        }
        
        if ($params['exit']) {
            exit();
        }
    }

    /**
    * Displays all of the messages inside of the HTML container
    *
    * @return string
    */
    public static function displayMessages()
    {
        if (empty(self::$debugMessages)) {
            return;
        }
        $msgContainer = '<div class="devLoggs" style="text-align: left; background-color: #dfdfdf; font-family: Courier,monospace; font-size: 11px; font-style: normal; font-weight: normal; font-variant: normal; padding: 5px; word-wrap:break-word">';
        $msgContainer .= self::$debugMessages;
        $msgContainer .= '</div>';
        return $msgContainer;
    }

    protected static function getMediumMessage($debugBacktrace)
    {
        $message = '<ol style="margin-bottom: 2px;">';

        foreach ($debugBacktrace as $debug) {
            if (!isset($debug['class'])) {
                $debug['class'] = '';
            }
            if (!isset($debug['type'])) {
                $debug['type'] = '';
            }
            $message .= '<li>';
            $message .= '<strong>'.$debug['class'].$debug['type'].$debug['function'].'</strong>';
            $message .= ' – in file '.$debug['file'].' at line '.$debug['line'];
            $message .= ' with '.count($debug['args']).' arguments.';
            $message .= '</li>';
        }
        $message .= '</ol>';
        return $message;
    }

    protected static function getLongMessage($debugBacktrace)
    {
        $message = '<ol style="margin-bottom: 2px;">';

        foreach ($debugBacktrace as $debug) {
            if (!isset($debug['class'])) {
                $debug['class'] = '';
            }
            if (!isset($debug['type'])) {
                $debug['type'] = '';
            }
            $message .= '<li>';
            $message .= 'In file '.$debug['file'].' at line '.$debug['line'];
            $message .= ' executed <strong>'.$debug['class'].$debug['type'].$debug['function'].'</strong>';

            if (count($debug['args']) != 0) {
                $message .= '<ol>';
                $args = [];

                foreach ($debug['args'] as $index => $argument) {
                    if (is_object($argument)) {
                        $argument = get_class($argument);
                    }
                    $args[] = $argument;
                }
                $message .= '<li>';
                
                ob_start();
                dump($args);
                $message .= ob_get_contents();
                ob_end_clean();

                $message .= '</li></ol>';
            }
            $message .= '</li>';
        }
        $message .= '</ol>';
        
        return $message;
    }
}

