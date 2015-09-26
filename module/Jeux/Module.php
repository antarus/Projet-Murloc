<?php

/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Jeux;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Session\Container;

class Module {

    private $config;

    public function onBootstrap(MvcEvent $e) {
        $eventManager = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
    }

    /**
     * Retourne l'emplacement du fichier de configuration des jeux.
     * @return fichier array
     */
    public function getConfigJeux() {
        if (!$this->config) {
            $this->config = include __DIR__ . '/../../jeux/jeux.config.php';
        }
        return $this->config;
    }

    /**
     * Fusionne les configurations des differents jeux.
     * @return array
     */
    public function getConfig() {
        $config = array();
        $aFichiersConf = array();
        $aFichiersConf[] = __DIR__ . '/config/module.config.php';
        foreach ($this->getConfigJeux()['jeux_disponible'] as $jeux => $conf) {
            if ($conf['Actif']) {
                $aFichiersConf[] = __DIR__ . '\..\..\jeux\\' . $jeux . '\\config\\' . 'config.php';
            }
        }
        foreach ($aFichiersConf as $aFichConf) {
            $config = \Zend\Stdlib\ArrayUtils::merge($config, include $aFichConf);
        }
        return $config;
    }

    public function getViewHelperConfig() {
        return array(
            'factories' => array(
                'jeux' => function($sm) {
                    $serviceLocator = $sm->getServiceLocator();
                    $helper = new \Jeux\View\Helper\JeuxHelper($serviceLocator);

                    return $helper;
                }
            )
        );
    }

    /**
     * Charge tous les autoload des jeux configurés.
     * chemin du fichier du liaison pour l'autoload.
     *
     * @return file
     */
    public function getAutoloaderConfig() {
        $autoload = array();
        foreach ($this->getConfigJeux()['jeux_disponible'] as $name => $active) {
            if ($active['Actif']) {
                $autoload[] = __DIR__ . '\..\..\jeux\\' . $name . '\\' . 'autoload_classmap.php';
            }
        }
        $autoload[] = __DIR__ . '\autoload_classmap.php';
        return array('Zend\Loader\ClassMapAutoloader' => $autoload);
    }

}
