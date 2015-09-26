<?php

namespace Core\JQueryValidator;

/**
 * Interface pour les validateurs.
 *
 * @author Antarus
 * @project Murloc avenue
 *
 */
interface InterfaceValidateur {

    /**
     *
     * Retourne la regle pour la validation Jquery.
     *
     * @return string
     */
    public function getRegle();
}
