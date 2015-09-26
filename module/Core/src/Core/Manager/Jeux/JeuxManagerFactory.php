<?php

namespace Core\Manager\Jeux;

use Zend\ServiceManager\Config as ServiceConfig;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Fabrique du Gestionnaire des jeux.
 *
 * @author Antarus
 * @project Murloc avenue
 *
 */
class JeuxManagerFactory extends \Zend\Mvc\Service\AbstractPluginManagerFactory {

    /**
     * Fabrique pour le service de Gestionnaire de jeux.
     * @param ServiceLocatorInterface $oServiceLocator
     * @return \Core\Manager\Jeux\JeuxManager
     */
    public function createService(ServiceLocatorInterface $oServiceLocator) {

        $config = $oServiceLocator->get('Config');
        $pluginConfig = empty($config['manager_jeux']) ? array() : $config['manager_jeux'];

        $oManagerJeux = new \Core\Manager\Jeux\JeuxManager();

        $oServiceConfig = new ServiceConfig($pluginConfig);
        $oServiceConfig->configureServiceManager($oManagerJeux);
        $oManagerJeux->setServiceLocator($oServiceLocator);
        return $oManagerJeux;
    }

}
