<?php

namespace Core\Manager\Theme;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Core\Manager\Theme\ThemeManager;

/**
 * Fabrique du Gestionnaire des theme.
 *
 * @author Antarus
 * @project Murloc avenue
 *
 */
class ThemeManagerFactory implements FactoryInterface {

    /**
     * Fabrique pour le service de Gestionnaire de thème.
     * @param ServiceLocatorInterface $serviceLocator
     * @return \Core\Manager\Jeux\JeuxManager
     */
    public function createService(ServiceLocatorInterface $serviceLocator) {
        $aConfig = $serviceLocator->get('Configuration');
        return new ThemeManager($serviceLocator, $aConfig['manager_theme']);
    }

}
