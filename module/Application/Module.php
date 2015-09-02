<?php

/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Session\Container;

class Module {

    public function onBootstrap(MvcEvent $e) {
        $eventManager = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);

        $oSessionUser = new Container('users');
        if (!empty($oSessionUser['users'])) {
            $e->getViewModel()->setVariable('userConnect', true);
            $e->getViewModel()->setVariable('nom', $oSessionUser['users'][0]['pseudo']);
            $e->getViewModel()->setVariable('avatar', $oSessionUser['users'][0]['avatar']);
        }
    }

    public function getConfig() {
        return include __DIR__ . '/config/module.config.php';
    }

    /**
     *
     * chemin du fichier du liaison pour l'autoload.
     *
     * @return file
     */
    public function getAutoloaderConfig() {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
        );
    }

    public function getServiceConfig() {
        return array(
            'invokables' => array(
                'ModuleManagerService' => 'Application\Service\ModuleManagerService',
                'LogService' => 'Application\Service\LogService',
            ),
        );
    }

    public function getViewHelperConfig() {
        return array(
            'factories' => array(
                //surcharge du flashmessenger par le notre pour utiliser une methode plus propre pour rendre les messages de la requete courant et la suivante.
                'flashmessenger' => function($sm) {
                    $helper = new \Application\Helper\Messages();
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
        );
    }

}
