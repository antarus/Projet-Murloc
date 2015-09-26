<?php

namespace Core\Plugin;

use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Base commune a tous les plugins.
 *
 * @author Antarus
 * @project Murloc avenue
 *
 */
abstract class AbstractPlugin implements PluginInterface {

    /**
     *
     * @var ServiceLocatorInterface
     */
    protected $serviceLocator;

    /**
     * Pour la traduction.
     *
     * @param string $sMsg
     * @return string
     */
    public function translate($sMsg) {
        return $this->serviceLocator->get('translator')->translate($sMsg);
    }

    /**
     * Définit le service locator.
     *
     * @param ServiceLocatorInterface $oServiceLocator
     */
    public function setServiceLocator(ServiceLocatorInterface $oServiceLocator) {
        $this->serviceLocator = $oServiceLocator;
    }

    /**
     * Retourne le service locator.
     *
     * @return ServiceLocatorInterface
     */
    public function getServiceLocator() {
        return $this->serviceLocator;
    }

}
