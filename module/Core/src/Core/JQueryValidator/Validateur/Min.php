<?php

namespace Core\JQueryValidator\Validateur;

use Core\JQueryValidator\AbstractValidateur;

/**
 * Implementation du validateur Min.
 *
 * @author Antarus
 * @project Murloc avenue
 */
class Min extends AbstractValidateur {

    /**
     * @see \Core\JQueryValidator\AbstractValidateur::getRegle()
     */
    public function getRegle() {
        $sRetour = '';
        $oValidateur = $this->getValidateurZend();
        if ($oValidateur->getMin()) {
            $sRetour .= 'min: ' . $oValidateur->getMin() . ', ' . PHP_EOL;
        }
        return $sRetour;
    }

}
