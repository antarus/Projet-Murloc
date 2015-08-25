<?php

/**
 * @author Cedric durand
 */

namespace Jeux\Model;

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
     * Retourne la globalité des jeux.
     * @return array
     */
    public function fetchAll() {
        $oRes = $this->tableGateway->select();
        return $oRes->toArray();
    }

}
