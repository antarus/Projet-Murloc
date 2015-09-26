<?php

namespace Core\Model;

use Zend\EventManager\EventManagerInterface;

/**
 * @author Antarus
 * @project Murloc avenue
 */
class Personnages extends \Core\Model\AbstractModel {

    /**
     * Column: idPersonnage
     *
     * @var int
     */
    public $idPersonnage = null;

    /**
     * Column: nom
     *
     * @var string
     */
    public $nom = null;

    /**
     * Column: niveau
     *
     * @var string
     */
    public $niveau = null;

    /**
     * Column: idUsers
     *
     * Reference to users.idUsers
     *
     * @var int
     */
    public $idUsers = null;

    /**
     * Column: idJeux
     *
     * Reference to jeux.idJeux
     *
     * @var int
     */
    public $idJeux = null;

    /**
     * Column: idGuildes
     *
     * Reference to guildes.idGuildes
     *
     * @var int
     */
    public $idGuildes = null;

    /**
     * Column: data
     *
     * @var string
     */
    public $data = null;

    /**
     * Retourne la valeur idPersonnage.
     *
     * @return int
     */
    public function getIdPersonnage() {
        return $this->idPersonnage;
    }

    /**
     * Définit la valeur pour idPersonnage
     *
     * @param int
     */
    public function setIdPersonnage($value) {
        $this->idPersonnage = $value;
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
     * Retourne la valeur niveau.
     *
     * @return string
     */
    public function getNiveau() {
        return strval($this->niveau);
    }

    /**
     * Définit la valeur pour niveau
     *
     * @param string
     */
    public function setNiveau($value) {
        $this->niveau = $value;
    }

    /**
     * Retourne la valeur idUsers.
     *
     * @return int
     */
    public function getIdUsers() {
        return $this->idUsers;
    }

    /**
     * Définit la valeur pour idUsers
     *
     * @param int
     */
    public function setIdUsers($value) {
        $this->idUsers = $value;
    }

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
     * Retourne la valeur idGuildes.
     *
     * @return int
     */
    public function getIdGuildes() {
        return intval($this->idGuildes);
    }

    /**
     * Définit la valeur pour idGuildes
     *
     * @param int
     */
    public function setIdGuildes($value) {
        $this->idGuildes = $value;
    }

    /**
     * Retourne la valeur data.
     *
     * @return string
     */
    public function getData() {
        return strval($this->data);
    }

    /**
     * Définit la valeur pour data
     *
     * @param string
     */
    public function setData($value) {
        $this->data = $value;
    }

}
