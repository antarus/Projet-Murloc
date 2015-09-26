<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Jeux\Wow\View\Helper;

use Core\Helper\AbstractJeuHelper;

class WowHelper extends AbstractJeuHelper {

    public function personnaliseGuildeMaj() {
        return $this->getView()->partial('wow/guilde/update');
    }

    public function personnaliseGuildeCreation() {
        return $this->getView()->partial('wow/guilde/create');
    }

}
