<?php

namespace Core\Manager\Theme\Source;

use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Classe abstraite pour les sources possible de recurpération du thème courant.
 *
 * @author Antarus
 * @project Murloc avenue
 *
 */
abstract class AbstractSource implements SourceInterface {

    protected $serviceLocator;

    /**
     * Constrcuteur.
     * @param ServiceLocatorInterface $serviceLocator
     */
    public function __construct(ServiceLocatorInterface $serviceLocator) {
        $this->serviceLocator = $serviceLocator;
    }

    /**
     * Enregistre le nom du theme si la source le permet.
     * @param string $sTheme
     * @return bool
     */
    public function setTheme($sTheme) {
        return false;
    }

}
