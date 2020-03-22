<?php

namespace Application\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\Mvc\MvcEvent;
use Laminas\EventManager\EventManagerInterface;

use Laminas\Session;

class AbstractController extends AbstractActionController
{
    protected $baseUrl;
    
    public function onDispatch(MvcEvent $e) {
        $this->baseUrl = $this->getRequest()->getBasePath();
        
        return parent::onDispatch($e);
    }
    
    public function setEventManager(EventManagerInterface $events)
    {
        parent::setEventManager($events);
        
	$events->attach('dispatch', function ($e) {
            $controllerClass = $e->getRouteMatch()->getParam('controller', 'index');
            $e->getViewModel()->setVariable('controller', $controllerClass);
            
            $userSession = new Session\Container('user');
            
            if ($userSession->details) {
                $e->getViewModel()->setVariable('user', $userSession->details);
            }
	}, 100);

    }
}