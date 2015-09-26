<?php

namespace Core;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Session\Container;
use \Zend\ModuleManager\ModuleEvent;

class Module {

    public function init(\Zend\ModuleManager\ModuleManager $oModuleManager) {
        $oEvent = $oModuleManager->getEventManager();
        // initialise le service de Gestion des jeux une fois que tous les modules de l'application sont chargé
        $oEvent->attach(ModuleEvent::EVENT_LOAD_MODULES_POST, array($this, 'initServiceJeux'));
        // ajoute les configuration des jeux au moment du merge des configuration des modules
//        $oEvent->attach(ModuleEvent::EVENT_MERGE_CONFIG, array($this, 'onMergeConfig'));
    }

    public function onBootstrap(MvcEvent $e) {
        $eventManager = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
        $em = $e->getApplication()->getEventManager();
        //définit la methode static pour pouvoir l'utiliser partout.
        $sm = $e->getApplication()->getServiceManager();

//
//        $e->getApplication()->getEventManager()->getSharedManager()->attach('Zend\Mvc\Controller\AbstractController', 'dispatch', function($e) {
//            $controller = $e->getTarget();
//            $controllerClass = get_class($controller);
//            $moduleNamespace = substr($controllerClass, 0, strpos($controllerClass, '\\'));
//            $config = $e->getApplication()->getServiceManager()->get('config');
//            if (isset($config['module_layouts'][$moduleNamespace])) {
//                $controller->layout($config['module_layouts'][$moduleNamespace]);
//            }
//        }, 100);
//
        // initialise le service de Gestion des themes.
        $sm->get('ThemeManager')->init();
    }

    /**
     * Initialise le service de jeux.
     * @param \Zend\EventManager\EventInterface $oEvent
     */
    public function initServiceJeux(\Zend\EventManager\EventInterface $oEvent) {
        $sm = $oEvent->getParam('ServiceManager');
        $sm->get('Core\Service\JeuxService')->bootstrapEnabledPlugins($oEvent);
    }

    /**
     * Merge les configuration des jeux.
     * @param ModuleEvent $e
     */
//    public function onMergeConfig(ModuleEvent $e) {
//        $configListener = $e->getConfigListener();
//        $config = $configListener->getMergedConfig(false);
//
////        $sm = $e->getApplication()->getServiceManager();
////        \Zend\Stdlib\ArrayUtils::merge($config, $sm->get('Core\Service\JeuxService')->getConfigJeux());
//
//        // Pass the changed configuration back to the listener:
//        $configListener->setMergedConfig($config);
//    }

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

}
