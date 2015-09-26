<?php

namespace Core\JQueryValidator;

/**
 * Interface du GestionnaireValidateur.
 *
 * @author Antarus
 * @project Murloc avenue
 *
 */
interface InterfaceGestionnaireValidateur {

    /**
     * Retourne le gestionnaire de vallidateur.
     *
     */
    public function getGestionnaireValidateur();

    /**
     * Définit le gestionnaire de validateur.
     *
     * @param \Core\JQueryValidator\GestionnaireValidateur $oGestionnaireValidateur
     */
    public function setGestionnaireValidateur(\Core\JQueryValidator\GestionnaireValidateur $oGestionnaireValidateur);
}
