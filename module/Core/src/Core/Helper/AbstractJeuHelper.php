<?php

namespace Core\Helper;

use Zend\View\Helper\AbstractHelper;

abstract class AbstractJeuHelper extends AbstractHelper {

    public function personnaliseGuildeCreation() {
        return '';
    }

    public function personnaliseGuildeMaj() {
        return '';
    }

}
