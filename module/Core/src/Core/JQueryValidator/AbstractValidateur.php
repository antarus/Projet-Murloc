<?php

namespace Core\JQueryValidator;

/**
 * Base des vallidateurs.
 *
 * @author Antarus
 * @project Murloc avenue
 *
 */
abstract class AbstractValidateur implements InterfaceValidateur {

    /**
     * validateur ZF2
     *
     * @var \Zend\Validator\ValidatorInterface
     */
    protected $validateurZend = null;

    /**
     * Valeur necessaire a certaines validation.
     *
     * @var mixed
     */
    protected $valeur = null;

    /**
     * Constructeur.
     *
     * @param mixed $oValidateur
     */
    public function __construct($oValidateur = null) {
        if ($oValidateur instanceof \Zend\Validator\ValidatorInterface) {
            $this->setValidateurZend($oValidateur);
        } else {
            $this->setValeur($oValidateur);
        }
    }

    /**
     * Retourne le validateur Zend.
     *
     * @return \Zend\Validator\ValidatorInterface
     */
    public function getValidateurZend() {
        return $this->validateurZend;
    }

    /**
     * Retourne la valeur pour le validateur définit.
     *
     * @return type
     */
    public function getValeur() {
        return $this->valeur;
    }

    /**
     * Définit le validateur Zend.
     *
     * @param \Zend\Validator\ValidatorInterface $oValidateurZend
     */
    public function setValidateurZend(\Zend\Validator\ValidatorInterface $oValidateurZend) {
        $this->validateurZend = $oValidateurZend;
    }

    /**
     * Définit la valeur pour le validateur.(ex ; true / false pour le required)
     *
     * @param mixed
     */
    public function setValeur($valeur) {
        $this->valeur = $valeur;
    }

}
