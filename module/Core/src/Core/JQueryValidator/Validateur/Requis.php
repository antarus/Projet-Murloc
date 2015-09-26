<?php

namespace Core\JQueryValidator\Validateur;

use Core\JQueryValidator\AbstractValidateur;

/**
 * Implementation du validateur requis.
 *
 * @author Antarus
 * @project Murloc avenue
 */
class Requis extends AbstractValidateur {

    /**
     * @see \Core\JQueryValidator\AbstractValidateur::getRegle()
     */
    public function getRegle() {
        return 'required: ' . (isset($this->valeur) ? $this->valeur : 'false' ) . ', ' . PHP_EOL;
    }

}
