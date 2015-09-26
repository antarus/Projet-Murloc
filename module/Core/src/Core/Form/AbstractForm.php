<?php

namespace Core\Form;

use Zend\Form\Form;
use Core\JQueryValidator\GestionnaireValidateur;
use Core\JQueryValidator\InterfaceGestionnaireValidateur;

/**
 * Etend le form par défaut de Zend pour gérer JQuery Validator.
 *
 * @author Antarus
 * @project Murloc avenue
 */
abstract class AbstractForm extends Form implements InterfaceGestionnaireValidateur {

    /**
     *
     * @var GestionnaireValidateur
     */
    protected $oGestionnaireValidateur;

    /**
     * Retourne le validator  manager.
     *
     */
    public function getGestionnaireValidateur() {

        if (!$this->oGestionnaireValidateur) {
            $this->oGestionnaireValidateur = new \Core\JQueryValidator\GestionnaireValidateur();
            $this->oGestionnaireValidateur->setInputFilter($this->getInputFilter());
        }
        return $this->oGestionnaireValidateur;
    }

    /**
     * Définit le validator  manager
     *
     * @param GestionnaireValidateur $oValidatorManager
     */
    public function setGestionnaireValidateur(\Core\JQueryValidator\GestionnaireValidateur $oValidatorManager) {
        $this->oGestionnaireValidateur = $oValidatorManager;
    }

    /**
     * Retourne le code jquery pour valider le formulaire.
     *
     * @return string
     */
    public function getJqueryValidateScript() {
        return $this->getGestionnaireValidateur()->getScript($this->getName());
    }

}
