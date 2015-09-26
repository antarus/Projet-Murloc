<?php

namespace Core\Manager\Theme\Source;

use Zend\Session\SessionManager;

/**
 * Classe permettant la récupération du theme en session.
 *
 * @author Antarus
 * @project Murloc avenue
 *
 */
class Session extends AbstractSource {

    /**
     * Retourne le nom du theme courrant en session si il existe.
     * @return null|string
     */
    public function getTheme() {
        $session = $this->getSession();
        if (!isset($session->Theme)) {
            return null;
        }
        return $session->Theme;
    }

    /**
     * Sauvegarde le theme en session.
     * @param string $sTheme
     * @return bool
     */
    public function setTheme($sTheme) {
        $session = $this->getSession();
        $session->Theme = $sTheme;
        return true;
    }

    /**
     * Retourne une instance du Gestionnaire de session.
     * @return \Zend\Session\Storage\StorageInterface
     */
    protected function getSession() {
        $sessionManager = new SessionManager();
        $sessionManager->start();
        return $sessionManager->getStorage();
    }

}
