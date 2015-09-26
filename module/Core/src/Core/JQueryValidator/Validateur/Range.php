<?php

namespace Core\JQueryValidator\Validateur;

use Core\JQueryValidator\AbstractValidateur;

/**
 * Implementation du validateur Range.
 *
 * @author Antarus
 * @project Murloc avenue
 */
class Range extends AbstractValidateur {

    /**
     * @see \Core\JQueryValidator\AbstractValidateur::getRegle()
     */
    public function getRegle() {
        $sRetour = '';
        $oValidateur = $this->getValidateurZend();
        if ($oValidateur->getMin() && $oValidateur->getMax()) {
            $sRetour .= 'range: [' . $oValidateur->getMin() . ' , ' . $oValidateur->getMax() . ' ]' . PHP_EOL;
        }

        return $sRetour;
    }

}
