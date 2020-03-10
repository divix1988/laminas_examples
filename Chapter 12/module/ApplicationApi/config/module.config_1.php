<?php
return array(
    'controllers' => array(
        'factories' => array(
            'ApplicationApi\\V1\\Rpc\\Encryption\\Controller' => 'ApplicationApi\\V1\\Rpc\\Encryption\\EncryptionControllerFactory',
        ),
    ),
    'router' => array(
        'routes' => array(
            'application-api.rpc.encryption' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/encrypt',
                    'defaults' => array(
                        'controller' => 'ApplicationApi\\V1\\Rpc\\Encryption\\Controller',
                        'action' => 'encryption',
                    ),
                ),
            ),
            'application-api.rest.comics' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/comics[/:comics_id]',
                    'defaults' => array(
                        'controller' => 'ApplicationApi\\V1\\Rest\\Comics\\Controller',
                    ),
                ),
            ),
        ),
    ),
    'laminas-versioning' => array(
        'uri' => array(
            0 => 'application-api.rpc.encryption',
            1 => 'application-api.rest.comics',
        ),
    ),
    'laminas-rpc' => array(
        'ApplicationApi\\V1\\Rpc\\Encryption\\Controller' => array(
            'service_name' => 'Encryption',
            'http_methods' => array(
                0 => 'POST',
            ),
            'route_name' => 'application-api.rpc.encryption',
        ),
    ),
    'laminas-content-negotiation' => array(
        'controllers' => array(
            'ApplicationApi\\V1\\Rpc\\Encryption\\Controller' => 'Json',
            'ApplicationApi\\V1\\Rest\\Comics\\Controller' => 'HalJson',
        ),
        'accept_whitelist' => array(
            'ApplicationApi\\V1\\Rpc\\Encryption\\Controller' => array(
                0 => 'application/json',
                1 => 'application/*+json',
            ),
            'ApplicationApi\\V1\\Rest\\Comics\\Controller' => array(
                0 => 'application/vnd.application-api.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ),
        ),
        'content_type_whitelist' => array(
            'ApplicationApi\\V1\\Rpc\\Encryption\\Controller' => array(
                0 => 'application/json',
            ),
            'ApplicationApi\\V1\\Rest\\Comics\\Controller' => array(
                0 => 'application/vnd.application-api.v1+json',
                1 => 'application/json',
            ),
        ),
    ),
    'laminas-content-validation' => array(
        'ApplicationApi\\V1\\Rpc\\Encryption\\Controller' => array(
            'input_filter' => 'ApplicationApi\\V1\\Rpc\\Encryption\\Validator',
        ),
        'ApplicationApi\\V1\\Rest\\Comics\\Controller' => array(
            'input_filter' => 'ApplicationApi\\V1\\Rest\\Comics\\Validator',
        ),
    ),
    'input_filter_specs' => array(
        'ApplicationApi\\V1\\Rpc\\Encryption\\Validator' => array(
            0 => array(
                'required' => true,
                'validators' => array(
                    0 => array(
                        'name' => 'Laminas\\I18n\\Validator\\Alnum',
                        'options' => array(),
                    ),
                ),
                'filters' => array(
                    0 => array(
                        'name' => 'Laminas\\Filter\\StringTrim',
                        'options' => array(),
                    ),
                    1 => array(
                        'name' => 'Laminas\\Filter\\StringToLower',
                        'options' => array(),
                    ),
                ),
                'name' => 'input',
                'description' => 'Text to encrypt.',
                'field_type' => 'string',
                'error_message' => 'Incorrect input string.',
            ),
        ),
        'ApplicationApi\\V1\\Rest\\Comics\\Validator' => array(
            0 => array(
                'required' => false,
                'validators' => array(
                    0 => array(
                        'name' => 'Laminas\\I18n\\Validator\\Alnum',
                        'options' => array(
                            'allowwhitespace' => true,
                        ),
                    ),
                ),
                'filters' => array(),
                'name' => 'title',
                'description' => 'Comics title.',
                'field_type' => 'string',
            ),
            1 => array(
                'required' => false,
                'validators' => array(
                    0 => array(
                        'name' => 'Laminas\\Validator\\Uri',
                        'options' => array(),
                    ),
                ),
                'filters' => array(),
                'name' => 'thumb',
                'description' => 'Comics thumbnail',
            ),
            2 => array(
                'required' => false,
                'validators' => array(
                    0 => array(
                        'name' => 'Laminas\\I18n\\Validator\\IsInt',
                        'options' => array(),
                    ),
                ),
                'filters' => array(),
                'name' => 'id',
                'description' => 'Comics id.',
            ),
        ),
    ),
    'service_manager' => array(
        'factories' => array(
            'ApplicationApi\\V1\\Rest\\Comics\\ComicsResource' => 'ApplicationApi\\V1\\Rest\\Comics\\ComicsResourceFactory',
        ),
    ),
    'laminas-rest' => array(
        'ApplicationApi\\V1\\Rest\\Comics\\Controller' => array(
            'listener' => 'ApplicationApi\\V1\\Rest\\Comics\\ComicsResource',
            'route_name' => 'application-api.rest.comics',
            'route_identifier_name' => 'comics_id',
            'collection_name' => 'comics',
            'entity_http_methods' => array(
                0 => 'GET',
                1 => 'PATCH',
                2 => 'PUT',
                3 => 'DELETE',
            ),
            'collection_http_methods' => array(
                0 => 'GET',
                1 => 'POST',
                2 => 'PATCH',
                3 => 'PUT',
            ),
            'collection_query_whitelist' => array(),
            'page_size' => '2',
            'page_size_param' => null,
            'entity_class' => 'Application\\Model\\Rowset\\Comics',
            'collection_class' => 'ApplicationApi\\V1\\Rest\\Comics\\ComicsCollection',
            'service_name' => 'Comics',
        ),
    ),
    'laminas-hal' => array(
        'metadata_map' => array(
            'ApplicationApi\\V1\\Rest\\Comics\\ComicsEntity' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'application-api.rest.comics',
                'route_identifier_name' => 'comics_id',
                'hydrator' => 'Laminas\\Hydrator\\ArraySerializable',
            ),
            'ApplicationApi\\V1\\Rest\\Comics\\ComicsCollection' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'application-api.rest.comics',
                'route_identifier_name' => 'comics_id',
                'is_collection' => true,
            ),
            'ApplicationApi\\V1\\Rest\\Comics\\ComicEntity' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'application-api.rest.comics',
                'route_identifier_name' => 'comics_id',
                'hydrator' => 'Laminas\\Hydrator\\ArraySerializable',
            ),
            'Application\\Model\\Rowset\\Comics' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'application-api.rest.comics',
                'route_identifier_name' => 'comics_id',
                'hydrator' => 'Laminas\\Hydrator\\ArraySerializable',
            ),
            'Application\\Model\\Rowset\\Comics2' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'application-api.rest.comics',
                'route_identifier_name' => 'comics_id',
                'hydrator' => 'Laminas\\Hydrator\\ArraySerializable',
            ),
        ),
    ),
    'laminas-mvc-auth' => array(
        'authorization' => array(
            'ApplicationApi\\V1\\Rest\\Comics\\Controller' => array(
                'collection' => array(
                    'GET' => false,
                    'POST' => false,
                    'PUT' => true,
                    'PATCH' => true,
                    'DELETE' => false,
                ),
                'entity' => array(
                    'GET' => false,
                    'POST' => false,
                    'PUT' => true,
                    'PATCH' => true,
                    'DELETE' => true,
                ),
            ),
        ),
    ),
);
