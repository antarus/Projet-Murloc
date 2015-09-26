<?php

namespace Core\JQueryValidator\Validateur;

use Core\JQueryValidator\AbstractValidateur;

/**
 * Implementation du validateur Email.
 *
 * @author Antarus
 * @project Murloc avenue
 */
class Email extends AbstractValidateur {

    /**
     * @see \Core\JQueryValidator\AbstractValidateur::getRegle()
     */
    public function getRegle() {
        return 'email:  true, ' . PHP_EOL;
    }

}
