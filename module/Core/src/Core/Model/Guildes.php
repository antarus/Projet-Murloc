<?php

namespace Core\Model;

use Zend\EventManager\EventManagerInterface;

/**
 * @author Antarus
 * @project Murloc avenue
 */
class Guildes extends \Core\Model\AbstractModel {

    /**
     * Column: idGuildes
     *
     * @var int
     */
    public $idGuildes = null;

    /**
     * Column: nom
     *
     * @var string
     */
    public $nom = null;

    /**
     * Column: idJeux
     *
     * Reference to jeux.idJeux
     *
     * @var int
     */
    public $idJeux = null;

    /**
     * Column: data
     *
     * @var string
     */
    public $data = null;

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
