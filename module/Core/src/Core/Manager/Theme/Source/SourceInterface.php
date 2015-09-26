<?php

namespace Core\Manager\Theme\Source;

use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Interface pour les sources possible de recurpération du thème courant.
 *
 * @author Antarus
 * @project Murloc avenue
 *
 */
interface SourceInterface {

    /**
     * Constructeur.
     *  @param ServiceLocatorInterface $serviceLocator
     */
    public function __construct(ServiceLocatorInterface $serviceLocator);

    /**
     * Retourne le nom du theme de la Source.
     * @abstract
     * @return string | null
     */
    public function getTheme();

    /**
     * Enregistre le nom du theme si la source le permet.
     * @param string $sTheme
     * @return bool
     */
    public function setTheme($theme);
}
