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
