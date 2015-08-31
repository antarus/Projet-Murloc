<?php

/**
 * Model pour les informations Opérateur
 *
 * @autor: Thomas Simon
 * @version: 1.0
 * @date: 22/10/2013
 */

namespace Guildes\Model;

use Zend\Db\Sql\Predicate\Expression;
use Zend\Db\Sql\Select;
use Zend\Db\TableGateway\TableGateway;

class Guildes {

    protected $tableGateway;
    private $_config;

    public function __construct(TableGateway $tableGateway, $config) {
        $this->tableGateway = $tableGateway;
        $this->_config = $config;
    }

    /**
     * Retourne la globalité des infos guildes et le nom du jeux lié.
     * @return array
     */
    public function fetchAll() {
        try {
            $rowset = $this->tableGateway->select(function(Select $select) {
                $select->join('jeux', 'guildes.idJeux = jeux.idJeux', array('nom'), $select::JOIN_LEFT);
                $select->columns(array(
                    'guildeId' => new Expression('guildes.idGuildes'),
                    'guildeNom' => new Expression('guildes.nom'),
                    'guildeServeur' => new Expression('guildes.serveur'),
                    'nomJeux' => new Expression('jeux.nom')));
            });
        } catch (Exception $e) {
            \Zend\Debug\Debug::dump($e->__toString());
            exit;
        }
        return $rowset->toArray();
    }

    /**
     * Retourne la liste des guildes par nom.
     * @return array
     */
    public function getByNom($sNom) {
        $oRes = $this->tableGateway->select(array('nom' => $sNom));
        return $oRes->toArray();
    }

    /**
     * Retourne la liste des guildes par serveur.
     * @return array
     */
    public function getByServeur($sServeur) {
        $oRes = $this->tableGateway->select(array('serveur' => $sServeur));
        return $oRes->toArray();
    }

    /**
     * Retourne la liste des guildes par jeux.
     * @param type $iIdJeux
     * @return array
     */
    public function getByJeux($iIdJeux) {

        try {
            $oRowset = $this->tableGateway->select(array('idJeux' => $iIdJeux));
        } catch (Exception $e) {
            \Zend\Debug\Debug::dump($e->__toString());
            exit;
        }
        return $oRowset->toArray();
    }

    /**
     * Sauvegarde une guilde.
     * @param type Array $aGuilde
     * @return boolean
     */
    public function save($aGuilde) {
        try {
            $this->tableGateway->insert($aGuilde);
            return true;
        } catch (\Exception $e) {
            \Zend\Debug\Debug::dump($e->__toString());
            exit;
        }
    }

    /**
     * Retrouve la guilde par son identifiant.
     * @param type $id
     * @return type
     */
    public function getById($id) {
        try {
            $rowset = $this->tableGateway->select(array('idGuildes' => $id));
        } catch (Exception $e) {
            \Zend\Debug\Debug::dump($e->__toString());
            exit;
        }
        $row = $rowset->current();
        return (!$row) ? false : $row;
    }

    /**
     * Supprime une guilde par son identifiant.
     * @param type $id
     */
    public function delete($id) {
        try {
            return $this->tableGateway->delete(array('idGuildes' => $id));
        } catch (Exception $e) {
            \Zend\Debug\Debug::dump($e->__toString());
            exit;
        }
    }

}
