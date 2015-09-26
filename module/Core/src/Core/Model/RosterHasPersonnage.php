<?php

namespace Core\Model;

use Zend\EventManager\EventManagerInterface;

/**
 * @author Antarus
 * @project Murloc avenue
 */
class RosterHasPersonnage extends \Core\Model\AbstractModel {

    /**
     * Column: idRoster
     *
     * Reference to roster.idRoster
     *
     * @var int
     */
    public $idRoster = null;

    /**
     * Column: idPersonnage
     *
     * Reference to personnages.idPersonnage
     *
     * @var int
     */
    public $idPersonnage = null;

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
     * Retourne la valeur idPersonnage.
     *
     * @return int
     */
    public function getIdPersonnage() {
        return intval($this->idPersonnage);
    }

    /**
     * Définit la valeur pour idPersonnage
     *
     * @param int
     */
    public function setIdPersonnage($value) {
        $this->idPersonnage = $value;
    }

}
