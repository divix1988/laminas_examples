<?php

/**
 * @see       https://github.com/laminas/laminas-mvc-skeleton for the canonical source repository
 * @copyright https://github.com/laminas/laminas-mvc-skeleton/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-mvc-skeleton/blob/master/LICENSE.md New BSD License
 */

declare(strict_types=1);

namespace Application;

use Laminas\Router\Http\Literal;
use Laminas\Router\Http\Segment;
use Laminas\ServiceManager\Factory\InvokableFactory;

return [
    'router' => [
        'routes' => [
            'home' => [
                'type'    => Literal::class,
                'options' => [
                    'route'    => '/',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'application' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/application[/:action]',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'users' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/users[/:action[/:id]]',
                    'defaults' => [
                        'controller' => Controller\UsersController::class,
                        'action' => 'index',
                    ],
                ],
            ],
            'comics' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/comics_list',
                    'defaults' => [
                        'controller' => Controller\ComicsController::class,
                        'action' => 'index',
                    ],
                ],
                'may_terminate' => true,
                'child_routes' => [
                    'add' => [
                        'type' => 'literal',
                        'options' => [
                            'route' => '/add',
                            'defaults' => [
                                'controller' => Controller\ComicsController::class,
                                'action' => 'add',
                            ],
                        ]
                    ],
                    'paginator' => [
                        'type' => 'segment',
                        'options' => [
                            'route' => '/[page/:page]',
                            'defaults' => [
                                'page' => 1
                            ]
                        ]
                    ]
                ]
            ]

        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\IndexController::class => function($sm) {
                $usersService = $sm->get('Application\Model\UsersTable');
                return new Controller\IndexController($usersService);
            },
            Controller\UsersController::class => function($sm) {
                $usersTable = $sm->get('Application\Model\UsersTable');
                $userHobbiesTable = $sm->get('Application\Model\UserHobbiesTable');
                return new Controller\UsersController($usersTable, $userHobbiesTable);
            },
            Controller\ComicsController::class => function($sm) {
                $postService = $sm->get('Application\Model\ComicsTable');
                
                return new Controller\ComicsController($postService);
            },
            'ComicsTableGateway' => function ($sm) {
                $dbAdapter = $sm->get('Laminas\Db\Adapter\Adapter');
                $config = $sm->get('Config');
                $baseUrl = $config['view_manager']['base_url'];
                $resultSetPrototype = new ResultSet();
                $identity = new Rowset\Comics($baseUrl);
                $resultSetPrototype->setArrayObjectPrototype($identity);
                return new TableGateway('comics', $dbAdapter, null, $resultSetPrototype);
            },
            'Application\Model\ComicsTable' => function($sm) {
                $tableGateway = $sm->get('ComicsTableGateway');
                $table = new ComicsTable($tableGateway);
                return $table;
            },
        ],
    ],
    'view_manager' => [
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => [
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
            __DIR__ . '/../view/application/_shared'
        ],
        'base_path' => '/laminas_app/public/',
        'base_url' => '/laminas_app/'
    ],
];
