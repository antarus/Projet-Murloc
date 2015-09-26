<?php

namespace Core\JQueryValidator\Validateur;

use Core\JQueryValidator\AbstractValidateur;

/**
 * Implementation du validateur Numerique.
 *
 * @author Antarus
 * @project Murloc avenue
 *
 */
class Numerique extends AbstractValidateur {

    /**
     * @see \Core\JQueryValidator\AbstractValidateur::getRegle()
     */
    public function getRegle() {
        return 'digits:  true, ' . PHP_EOL;
    }

}
