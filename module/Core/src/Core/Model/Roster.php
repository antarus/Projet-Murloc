<?php

namespace Core\Model;

use Zend\EventManager\EventManagerInterface;

/**
 * @author Antarus
 * @project Murloc avenue
 */
class Roster extends \Core\Model\AbstractModel {

    /**
     * Column: idRoster
     *
     * @var int
     */
    public $idRoster = null;

    /**
     * Column: nom
     *
     * @var string
     */
    public $nom = null;

    /**
     * Retourne la valeur idRoster.
     *
     * @return int
     */
    public function getIdRoster() {
        return intval($this->idRoster);
    }

    /**
     * Définit la valeur pour idRoster
     *
     * @param int
     */
    public function setIdRoster($value) {
        $this->idRoster = $value;
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

}
