<?php

/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */
return array(
    'service_manager' => array(
        'abstract_factories' => array(
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
            'Zend\Log\LoggerAbstractServiceFactory',
        ),
        'factories' => array(
            // manager de plugin
            'Core\Manager\Jeux\JeuxManager' => 'Core\Manager\Jeux\JeuxManagerFactory',
            'ThemeManager' => 'Core\Manager\Theme\ThemeManagerFactory',
            //Plugin
            'Core\Service\JeuxService' => function ($sm) {
                $ins = new \Core\Service\JeuxService( );
                $ins->setManagerJeux($sm->get('Core\Manager\Jeux\JeuxManager'));
                return $ins;
            },
            'Core\Table\AppPluginTable' => function($sm) {
                return new \Core\Table\AppPluginTable($sm->get("Zend\Db\Adapter\Adapter"));
            },
            'Core\Table\JeuxTable' => function($sm) {
                return new \Core\Table\JeuxTable($sm->get("Zend\Db\Adapter\Adapter"));
            },
            'Core\Table\GuildesTable' => function($sm) {
                return new \Core\Table\GuildesTable($sm->get("\Zend\Db\Adapter\Adapter"));
            },
            'Core\Table\PersonnagesTable' => function($sm) {
                return new \Core\Table\PersonnagesTable($sm->get("\Zend\Db\Adapter\Adapter"));
            },
            'Core\Table\RosterTable' => function($sm) {
                return new \Core\Table\RosterTable($sm->get("\Zend\Db\Adapter\Adapter"));
            },
            'Core\Table\RosterHasPersonnageTable' => function($sm) {
                return new \Core\Table\RosterHasPersonnageTable($sm->get("\Zend\Db\Adapter\Adapter"));
            }
        ),
        'invokables' => array(
            'ModuleManagerService' => 'Application\Service\ModuleManagerService',
            'LogService' => 'Application\Service\LogService',
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
    // Placeholder for console routes
    'console' => array(
        'router' => array(
            'routes' => array(
            ),
        ),
    ),
    'form_elements' => array(
        'invokables' => array(
            'objectSelect' => 'Core\Form\Element\ObjectSelect'
        )
    ),
    'view_helpers' => array(
        'factories' => array(
            //surcharge du flashmessenger par le notre pour utiliser une methode plus propre pour rendre les messages de la requete courant et la suivante.
            'flashmessenger' => function($sm) {
                $helper = new \Core\Helper\Messages();
                $serviceLocator = $sm->getServiceLocator();
                $controllerPluginManager = $serviceLocator->get('ControllerPluginManager');
                $flashMessenger = $controllerPluginManager->get('flashmessenger');
                $helper->setPluginFlashMessenger($flashMessenger);
                $config = $serviceLocator->get('Config');
                if (isset($config['view_helper_config']['flashmessenger'])) {
                    $configHelper = $config['view_helper_config']['flashmessenger'];
                    if (isset($configHelper['message_open_format'])) {
                        $helper->setMessageOpenFormat($configHelper['message_open_format']);
                    }
                    if (isset($configHelper['message_separator_string'])) {
                        $helper->setMessageSeparatorString($configHelper['message_separator_string']);
                    }
                    if (isset($configHelper['message_close_string'])) {
                        $helper->setMessageCloseString($configHelper['message_close_string']);
                    }
                }

                return $helper;
            }
        )
    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions' => true,
        'doctype' => 'HTML5',
        'not_found_template' => 'error/404',
        'exception_template' => 'error/index',
    ),
    'manager_theme' => array(
        'theme_defaut' => 'defaut', // 'theme1', //defaut',
        'remplaceChemin' => true,
        'chemin_themes' => array(
            __DIR__ . '/../../../themes/{theme}',
        ),
        'sources' => array(
            'Core\Manager\Theme\Source\Configuration',
            'Core\Manager\Theme\Source\Session',
        ),
    ),
);

