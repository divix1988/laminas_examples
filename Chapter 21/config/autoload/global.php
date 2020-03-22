<?php
return array(
    'db' => array(
        'driver' => 'Pdo',
        'dsn' => 'mysql:dbname=laminasDB;host=localhost',
        'driver_options' => [
            1002 => 'SET NAMES \'UTF8\'',
        ],
    ),
    'service_manager' => [
        'factories' => [
            'Laminas\\Db\\Adapter\\Adapter' => 'Laminas\\Db\\Adapter\\AdapterServiceFactory',
            
            \Utils\Security\Adapter::class => function($sm) {
                return new \Utils\Security\Adapter(
                    $sm->get(\Laminas\Db\Adapter\Adapter::class),
                        'users',
                        'email',
                        'password',
                        'SHA2(CONCAT(password_salt, "'.\Utils\Security\Helper::SALT_KEY.'", ?), 512)'
                    );
            },
            'Laminas\Db\TableGateway\TableGateway' => 'Laminas\Db\TableGateway\TableGatewayServiceFactory',
        ],
        'abstract_factories' => [
            Laminas\Navigation\Service\NavigationAbstractServiceFactory::class,
	]
    ],
    'api-tools-mvc-auth' => [
        'authentication' => [
            'map' => [
                'ApplicationApi\\V1' => 'comics',
            ],
        ],
    ],
    'session' => [
	'config' => [
            'class' => \Laminas\Session\Config\SessionConfig::class,
            'options' => [
                'name' => 'session_name',
            ],
	],
	'storage' => \Laminas\Session\Storage\SessionArrayStorage::class,
	'validators' => [
            \Laminas\Session\Validator\RemoteAddr::class,
            \Laminas\Session\Validator\HttpUserAgent::class,
	],
    ],
    'navigation' => [
	'default' => [
            [
                'label' => 'Home Page',
                'route' => 'home',
                'priority' => '1.0'
            ],
            [
                'label' => 'Users',
                'route' => 'users',
                'pages' => [
                    [
                        'label' => 'Add User',
                        'controller' => 'users',
                        'action' => 'add'
                    ]
                ],
                'priority' => '0.5'
            ],
            [
                'label' => 'Comics',
                'route' => 'comics',
                'priority' => '0.5'
            ],
            [
                'label' => 'Poll',
                'route' => 'polling',
                'pages' => [
                    [
                        'label' => 'Manage polls',
                        'route' => 'polling',
                        'action' => 'manage',
                        'pages' => [
                            [
                                'label' => 'Active poll',
                                'route' => 'polling',
                                'action' => 'view',
                            ]
                        ]
                    ]
                ]
            ],
            [
                'label' => 'Registration',
                'route' => 'register'
            ],
            [
                'label' => 'Login',
                'route' => 'login'
            ],
            [
                'label' => 'My Account',
                'route' => 'user'
            ],
            [
                'label' => 'Logout',
                'route' => 'login',
                'action' => 'logout'
            ],
            [
                'label' => 'Forms',
                'route' => 'forms'
            ],
            [
                'label' => 'News',
                'route' => 'news',
                'pages' => [
                    [
                        'label' => 'Article',
                        'route' => 'news',
                        'action' => 'show'
                    ]
                ]
            ],
	]
    ]
);
