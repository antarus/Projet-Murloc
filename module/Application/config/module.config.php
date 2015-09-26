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
            'home' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/[:action]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]+'
                    ),
                    'defaults' => array(
                        'controller' => 'Application\Controller\Index',
                        'action' => 'index',
                    ),
                ),
            ),
            'contact' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/contact[/:action][/:recipient][/:pseudo][/:forgetkey]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]+'
                    ),
                    'defaults' => array(
                        'controller' => 'Application\Controller\Contact',
                        'action' => 'index',
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
        'locale' => 'fr_FR',
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
            'Application\Controller\Index' => 'Application\Controller\IndexController',
            'Application\Controller\Contact' => 'Application\Controller\ContactController'
        ),
    ),
    // Placeholder for console routes
    'console' => array(
        'router' => array(
            'routes' => array(
            ),
        ),
    ),
//    'assetic_configuration' => array(
//        // Use on production environment
//        // 'debug'              => false,
//        // 'buildOnRequest'     => false,
//        // Use on development environment
//        'debug' => true,
//        'buildOnRequest' => true,
//        // This is optional flag, by default set to `true`.
//        // In debug mode allow you to combine all assets to one file.
//        // 'combine' => false,
//        // this is specific to this project
//        'webPath' => realpath('public/assets'),
//        'basePath' => 'assets',
//        'controllers' => array(
//            'Application\Controller\Index' => array(
//                '@css',
//            // '@my_js',
//            ),
//        ),
//        'modules' => array(
//            'application' => array(
//                'root_path' => __DIR__ . '/../public/assets',
//                'collections' => array(
//                    'css' => array(
//                        'assets' => array(
//                            'css/test.css',
//                        // 'css/main2.css',
//                        ),
////                        'filters' => array(
////                            '?CssRewriteFilter' => array(
////                                'name' => 'Assetic\Filter\CssRewriteFilter'
////                            ),
////                            '?CssMinFilter' => array(
////                                'name' => 'Assetic\Filter\CssMinFilter'
////                            ),
////                        ),
//                    ),
////                    'my_js' => array(
////                        'assets' => array(
////                        // 'js/main1.js',
////                        // 'js/main2.js',
////                        ),
////                        'filters' => array(
////                            '?JSMinFilter' => array(
////                                'name' => 'Assetic\Filter\JSMinFilter'
////                            ),
////                        ),
////                    ),
//                ),
//            ),
//        ),
//    ),
);
