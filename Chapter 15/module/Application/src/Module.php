<?php

/**
 * @see       https://github.com/laminas/laminas-mvc-skeleton for the canonical source repository
 * @copyright https://github.com/laminas/laminas-mvc-skeleton/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-mvc-skeleton/blob/master/LICENSE.md New BSD License
 */

declare(strict_types=1);

namespace Application;

use Laminas\Db\ResultSet\ResultSet;
use Laminas\Db\TableGateway\TableGateway;
use Application\Model\Rowset\User;
use Application\Model\Rowset\UserHobby;
use Application\Model\Rowset\Comics;
use Application\Model\UsersTable;
use Application\Model\UserHobbiesTable;
use Application\Model\ComicsTable;
use Laminas\ServiceManager\Factory\InvokableFactory;
use Laminas\Session;

class Module
{
    public function getConfig() : array
    {
        return include __DIR__ . '/../config/module.config.php';
    }
    
    public function getServiceConfig()
    {   
	return array(
            'factories' => array(
                'UsersTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Laminas\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    //get base url from config
                    $config = $sm->get('Config');
                    $baseUrl = $config['view_manager']['base_url'];

                    //pass base url via cnstructor to the User class
                    $resultSetPrototype->setArrayObjectPrototype(new User($baseUrl));
                    return new TableGateway('users', $dbAdapter, null, $resultSetPrototype);
                },
                'Application\Model\UsersTable' => function($sm) {
                    $tableGateway = $sm->get('UsersTableGateway');
                    $table = new UsersTable($tableGateway);

                    return $table;
                },
                        
                'UserHobbiesTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Laminas\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new UserHobby());
                    return new TableGateway('user_hobbies', $dbAdapter, null, $resultSetPrototype);
                },

                'Application\Model\UserHobbiesTable' => function($sm) {
                    $tableGateway = $sm->get('UserHobbiesTableGateway');
                    $table = new UserHobbiesTable($tableGateway);
                    return $table;
                },
                
                'ComicsTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');

                    $config = $sm->get('Config');
                    $baseUrl = $config['view_manager']['base_url'];
                    $resultSetPrototype = new ResultSet();
                    $identity = new Comics($baseUrl);
                    $resultSetPrototype->setArrayObjectPrototype($identity);

                    return new TableGateway('comics', $dbAdapter, null, $resultSetPrototype);
                },
                'Application\Model\ComicsTable' =>  function($sm) {
                    $tableGateway = $sm->get('ComicsTableGateway');
                    $table = new ComicsTable($tableGateway);

                    return $table;
                },
                \Utils\Polls\Polls::class => InvokableFactory::class,
                
                \Utils\Security\Authentication::class => function($sm) {
                    $auth = new \Utils\Security\Authentication($sm->get(\Laminas\Db\Adapter\Adapter::class));
                    return $auth;
                },
                \Utils\Security\Helper::class => InvokableFactory::class,
                
                SessionManager::class => function ($container) {
                    $config = $container->get('config');
                    $session = $config['session'];
                    $sessionConfig = new $session['config']['class']();
                    $sessionConfig->setOptions($session['config']['options']);
                    $sessionManager = new Session\SessionManager(
                        $sessionConfig,
                        new $session['storage'](),
                        null
                    );
                    \Laminas\Session\Container::setDefaultManager($sessionManager);
                    
                    return $sessionManager;
                },
                Model\Admin\ContentManager::class => function($sm) {
                    return new Model\Admin\ContentManager($sm->get(\Laminas\Db\Adapter\Adapter::class));
                },
        

            )
        );
    }
    
    public function onBootstrap($e)
    {
        $this->bootstrapSession($e);
    }

    public function bootstrapSession($e)
    {
        $serviceManager = $e->getApplication()->getServiceManager();
        $session = $serviceManager->get(SessionManager::class);
        $session->start();
	$container = new Session\Container('initialized');

	//let’s check if our session is not already created (for the guest or user)
	if (isset($container->init)) {
            return;
	}

	//new session creation
	$request = $serviceManager->get('Request');
	$session->regenerateId(true);
	$container->init = 1;
	$container->remoteAddr = $request->getServer()->get('REMOTE_ADDR');
	$container->httpUserAgent = $request->getServer()->get('HTTP_USER_AGENT');
	$config = $serviceManager->get('Config');
	$sessionConfig = $config['session'];
	$chain = $session->getValidatorChain();
	
	foreach ($sessionConfig['validators'] as $validator) {
            switch ($validator) {
                case Validator\HttpUserAgent::class:
                    $validator = new $validator($container->httpUserAgent);
                break;
                case Validator\RemoteAddr::class:
                    $validator = new $validator($container->remoteAddr);
                break;
                default:
                    $validator = new $validator();
            }
            $chain->attach('session.validate', array($validator, 'isValid'));
	}
    }
}