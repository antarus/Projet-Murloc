<?php

namespace Core\Manager\Theme\Source;

/**
 * Classe permettant la récupération duy theme par défaut.
 *
 * @author Antarus
 * @project Murloc avenue
 *
 */
class Configuration extends AbstractSource {

    public function getTheme() {
        $config = $this->serviceLocator->get('Configuration');
        if (!isset($config['manager_theme']['theme_defaut'])) {
            return null;
        }
        return $config['manager_theme']['theme_defaut'];
    }

}
