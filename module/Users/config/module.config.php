<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

return array(
    'router' => array(
        'routes' => array(
            'usager-swap-pwd' => array(
                'type' => 'segment',
                'options' => array(
                    'route'    => '/users/querypwdswap/[:forgetKey]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]+'
                    ),
                    'defaults' => array(
                        'controller' => 'Users\Controller\Index',
                        'action'     => 'querypwdswap',
                    ),
                ),
            ),
            'users-forgekey' => array(
                'type' => 'segment',
                'options' => array(
                    'route'    => '/users/forgetkey',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]+'
                    ),
                    'defaults' => array(
                        'controller' => 'Users\Controller\Index',
                        'action'     => 'forgetpwd',
                    ),
                ),
            ),
            'users-pwdswap' => array(
                'type' => 'segment',
                'options' => array(
                    'route'    => '/users/pwdswap',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]+'
                    ),
                    'defaults' => array(
                        'controller' => 'Users\Controller\Index',
                        'action'     => 'pwdswap',
                    ),
                ),
            ),
            'users-changepassword' => array(
                'type' => 'segment',
                'options' => array(
                    'route'    => '/users/changepassword',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]+'
                    ),
                    'defaults' => array(
                        'controller' => 'Users\Controller\Index',
                        'action'     => 'changepassword',
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
                'type'     => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern'  => '%s.mo',
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'Users\Controller\Index' => 'Users\Controller\IndexController',
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
