<?php

return array(
    'router' => array(
        'routes' => array(),
    ),
    'service_manager' => array(
        'abstract_factories' => array(
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
            'Zend\Log\LoggerAbstractServiceFactory',
        ),
        'aliases' => array(
            'translator' => 'MvcTranslator',
        ),
    ),
    'translator' => array(
        'locale' => 'en_US',
        'translation_file_patterns' => array(
            array(
                'type' => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern' => '%s.mo',
            ),
        ),
    ),
    'battlenet' => array(
        'apikey' => '5nssdkuvwub25ydqzhwwznvzh8hh2ag9'
    ),
//            'caches' => array(
//                'bnet' => array(
//                    'adapter' => array(
//                        'name' => 'filesystem',
//                        'lifetime' => 1800,
//                    ),
//                    'plugins' => array(
//                        'exception_handler' => array(
//                            'throw_exceptions' => false
//                        ),
//                    ),
//                ),
//            ),
);
