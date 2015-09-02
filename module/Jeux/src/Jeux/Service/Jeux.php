<?php

/**
 * @author Cedric durand
 */

namespace Jeux\Service;

use Zend\Db\Sql\Predicate\Expression;
use Zend\Db\Sql\Select;
use Zend\Db\TableGateway\TableGateway;

class Jeux {

    protected $tableGateway;
    private $_config;

    public function __construct(TableGateway $tableGateway, $config) {
        $this->tableGateway = $tableGateway;
        $this->_config = $config;
    }

    /**
     * Verifie la validité du tableau.
     * @param array $aJeux
     * @return type boolean
     */
    public function isValid(array $aJeux) {
        $sMessenger = $this->flashMessenger();
        $bRetour = true;
        if (!isset($aJeux['nom']) || empty($aJeux['nom'])) {
            $sMessenger->addMessage($this->_getServTranslator()->translate("Jeux - Nom manquant."), 'error');
            $bRetour = $bRetour && false;
        }
        if (!isset($aJeux['logo']) || empty($aJeux['logo'])) {
            $sMessenger->addMessage($this->_getServTranslator()->translate("Jeux - Logo manquant."), 'error');
            $bRetour = $bRetour && false;
        }
        return $bRetour;
    }

    /**
     * Retourne la globalité des jeux.
     * @return array
     */
    public function fetchAll() {
        $oRes = $this->tableGateway->select();
        return $oRes->toArray();
    }

    /**
     * Sauvegarde un jeux
     * @param type Array $aGuilde
     * @return boolean
     */
    public function save($aJeux) {
        try {
            $this->tableGateway->insert($aJeux);
            return true;
        } catch (\Exception $e) {
            \Zend\Debug\Debug::dump($e->__toString());
            exit;
        }
    }

}
