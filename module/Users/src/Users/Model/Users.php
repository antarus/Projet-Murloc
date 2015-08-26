<?php

/**
 * Model pour les informations Opérateur
 *
 * @autor: Thomas Simon
 * @version: 1.0
 * @date: 22/10/2013
 */

namespace Users\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Expression;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Where;

class Users {

    protected $tableGateway;
    private $_config;

    public function __construct(TableGateway $tableGateway, $config) {
        $this->tableGateway = $tableGateway;
        $this->_config = $config;
    }

    /**
     * Retourne la globalité des infos sur les opérateurs
     * @return array
     */
    public function fetchAll() {
        $oRes = $this->tableGateway->select();
        return $oRes->toArray();
    }

    /**
     * Retourne la globalité des infos sur les opérateurs
     * @return array
     */
    public function connect($login, $pwd) {
        $oRes = $this->tableGateway->select(array('login' => $login, 'pwd' => md5($pwd)));
        return $oRes->toArray();
    }

    /**
     * Retourne la globalité des infos sur les opérateurs
     * @return array
     */
    public function getByMail($mail) {
        $oRes = $this->tableGateway->select(array('email' => $mail));
        return $oRes->toArray();
    }

    public function getByForgetKey($key) {
        $oRes = $this->tableGateway->select(array('forgetPass' => $key));
        return $oRes->toArray();
    }

    public function setforgetKey($id, $forgetKey) {
        try {
            $this->tableGateway->update(array('forgetPass' => $forgetKey), array('idUsers' => $id));
            return true;
        } catch (\Exception $e) {
            \Zend\Debug\Debug::dump($e->__toString());
            exit;
        }
    }

    public function resetforgetkey($forgetKey) {
        $user = $this->getByForgetKey($forgetKey);
        try {
            $this->tableGateway->update(array('forgetPass' => NULL), array('idUsers' => $user[0]['idUsers']));
            return true;
        } catch (\Exception $e) {
            \Zend\Debug\Debug::dump($e->__toString());
            exit;
        }
    }

    public function setpwd($pwd, $forgetKey) {
        try {
            $this->tableGateway->update(array('pwd' => $pwd), array('forgetPass' => $forgetKey));
            return true;
        } catch (\Exception $e) {
            \Zend\Debug\Debug::dump($e->__toString());
            exit;
        }
    }

}
