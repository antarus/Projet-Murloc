<?php

namespace Core\JQueryValidator\Validateur;

use Core\JQueryValidator\AbstractValidateur;

/**
 * Implementation du validateur requis.
 *
 * @author Antarus
 * @project Murloc avenue
 */
class Longueur extends AbstractValidateur {

    /**
     * @see \Core\JQueryValidator\AbstractValidateur::getRegle()
     */
    public function getRegle() {
        $sRetour = '';
        $oValidateur = $this->getValidateurZend();
        if ($oValidateur->getMin()) {
            $sRetour .= 'minlength: ' . $oValidateur->getMin() . ', ' . PHP_EOL;
        }
        if ($oValidateur->getMax()) {
            $sRetour .= 'maxlength: ' . $oValidateur->getMax() . ', ' . PHP_EOL;
        }
        return $sRetour;
    }

}
