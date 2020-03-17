<?php
return array(
    'db' => array(
        'driver' => 'Pdo',
        'dsn' => 'mysql:dbname=laminasDB;host=localhost',
        'driver_options' => array(
            1002 => 'SET NAMES \'UTF8\'',
        ),
    ),
    'service_manager' => array(
        'factories' => array(
            'Laminas\\Db\\Adapter\\Adapter' => 'Laminas\\Db\\Adapter\\AdapterServiceFactory',
            
            \Utils\Security\Adapter::class => function($sm) {
                return new \Utils\Security\Adapter(
                    $sm->get(\Laminas\Db\Adapter\Adapter::class),
                        'users',
                        'email',
                        'password',
                        'SHA2(CONCAT(password_salt, "'.\Utils\Security\Helper::SALT_KEY.'", ?), 512)'
                    );
            }
        ),
    ),
    'api-tools-mvc-auth' => array(
        'authentication' => array(
            'map' => array(
                'ApplicationApi\\V1' => 'comics',
            ),
        ),
    ),
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
    ]
);
