<?php

namespace Core\Plugin;

/**
 * Base commune pour les plugins lié au jeu.
 *
 * @author Antarus
 * @project Murloc avenue
 *
 */
interface PluginJeuxInterface extends PluginInterface {

    /**
     * Retourne l'id. doit etre identique a celui de la base correspondant aux jeux
     */
    public function getId();

    /**
     * Méthode exécutée a l'installation du plugin.
     */
    public function onInstallation();

    /**
     * Méthode exécutée a la désinstallation du plugin.
     */
    public function onDesinstallation();

    /**
     * Méthode exécutée a l'activation du plugin.
     */
    public function onActivation();

    /**
     * Méthode exécutée a la désactivation du plugin.
     */
    public function onDesActivation();

    /**
     * Retourne le view helper du jeux.
     */
    public function getViewHelper();

    /**
     * Est ce que ce jeux me concerne.
     * @param string $sNomJeu
     */
    public function isForMe($sNomJeu);
}
