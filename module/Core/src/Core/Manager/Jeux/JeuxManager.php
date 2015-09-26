<?php

namespace Core\Manager\Jeux;

use Core\Manager\PluginManagerBase;

/**
 * Gestionnaire de jeux.
 *
 * @author Antarus
 * @project Murloc avenue
 *
 */
class JeuxManager extends PluginManagerBase {

    /**
     * Valide que le plugin est bien un jeu .
     */
    public function validatePlugin($plugin) {
        if (!$plugin instanceof \Core\Plugin\PluginJeuxInterface) {
            throw new \Exception("Le plugin ajouté n'est pas un jeux.");
        }
    }

}
