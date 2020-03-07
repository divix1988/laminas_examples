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
use Application\Model\UsersTable;
use Application\Model\UserHobbiesTable;

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

            )
        );
    }
}