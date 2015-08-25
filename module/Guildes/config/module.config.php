<?php

return array(
    'router' => array(
        'routes' => array(
            'guildes-liste' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/guildes/liste',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]+'
                    ),
                    'defaults' => array(
                        'controller' => 'Guildes\Controller\Guilde',
                        'action' => 'index',
                    ),
                ),
            ),
            'guildes-add' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/guildes/creation',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]+'
                    ),
                    'defaults' => array(
                        'controller' => 'Guildes\Controller\Guilde',
                        'action' => 'add',
                    ),
                ),
            ),
        ),
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
    'controllers' => array(
        'invokables' => array(
            'Guildes\Controller\Guilde' => 'Guildes\Controller\GuildeController',
        ),
    ),
    // View manager : template map, pour optimiser les temps de chargements.
    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
        'strategies' => array(
            'ViewJsonStrategy',
        ),
    )
);
