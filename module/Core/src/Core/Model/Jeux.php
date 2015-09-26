<?php

namespace Core\Model;

use Zend\EventManager\EventManagerInterface;

/**
 * @author Antarus
 * @project Murloc avenue
 */
class Jeux extends \Core\Model\AbstractModel {

    /**
     * Column: idJeux
     *
     * @var int
     */
    public $idJeux = null;

    /**
     * Column: nom
     *
     * @var string
     */
    public $nom = null;

    /**
     * Column: logo
     *
     * @var string
     */
    public $logo = null;

    /**
     * Column: active
     *
     * @var int
     */
    public $active = null;

    /**
     * Retourne la valeur idJeux.
     *
     * @return int
     */
    public function getIdJeux() {
        return intval($this->idJeux);
    }

    /**
     * Définit la valeur pour idJeux
     *
     * @param int
     */
    public function setIdJeux($value) {
        $this->idJeux = $value;
    }

    /**
     * Retourne la valeur nom.
     *
     * @return string
     */
    public function getNom() {
        return strval($this->nom);
    }

    /**
     * Définit la valeur pour nom
     *
     * @param string
     */
    public function setNom($value) {
        $this->nom = $value;
    }

    /**
     * Retourne la valeur logo.
     *
     * @return string
     */
    public function getLogo() {
        return strval($this->logo);
    }

    /**
     * Définit la valeur pour logo
     *
     * @param string
     */
    public function setLogo($value) {
        $this->logo = $value;
    }

    /**
     * Retourne la valeur active.
     *
     * @return int
     */
    public function getActive() {
        return intval($this->active);
    }

    /**
     * Définit la valeur pour active
     *
     * @param int
     */
    public function setActive($value) {
        $this->active = $value;
    }

}
