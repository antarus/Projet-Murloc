<?php

namespace Core\Table;

use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Sql;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\EventManager;
use Zend\EventManager\EventManagerAwareInterface;
use Zend\Db\Sql\Where;

/**
 * Etend la classe AbstractTableGateway nous permettant de travailler avec un objet de type \Core\Model\AbstractModel.
 * Cela permet d'ajouter, mettre a jour, et supprimer des objets en base de donnée.
 *
 * @author Antarus
 * @project Murloc avenue
 *
 */
class AbstractTable extends AbstractTableGateway implements EventManagerAwareInterface {

    /**
     * Object EventManagerInterface (injecté depuis MVC)
     *
     * @var EventManagerInterface
     */
    protected $events;

    /**
     * Type du model définit en tant que prototype (defaut ArrayObject)
     *
     * @var string
     */
    protected $arrayObjectPrototypeClass = 'ArrayObject';

    /**
     * Identifiant pour la recherche par clé dans une table.
     * C'est généralement la clé primaire.
     * Defaut id
     *
     * @var string
     */
    protected $nomCle = 'id';

    /**
     * liste des actions d'evenemenyt possible.
     *
     * @var array
     */
    protected $eventActions = array(
        self::PRE_INSERT => 'preInsert',
        self::POST_INSERT => 'postInsert',
        self::PRE_UPDATE => 'preUpdate',
        self::POST_UPDATE => 'postUpdate',
        self::PRE_DELETE => 'preDelete',
        self::POST_DELETE => 'postDelete'
    );

    /**
     * Clé de l'évènement preInsert.
     */
    CONST PRE_INSERT = 'preInsert';

    /**
     * Clé de l'évènement postInsert.
     */
    CONST POST_INSERT = 'postInsert';

    /**
     * Clé de l'évènement preUpdate.
     */
    CONST PRE_UPDATE = 'preUpdate';

    /**
     * Clé de l'évènement postUpdate.
     */
    CONST POST_UPDATE = 'postUpdate';

    /**
     * Clé de l'évènement preDelete.
     */
    CONST PRE_DELETE = 'preDelete';

    /**
     * Clé de l'évènement postDelete.
     */
    CONST POST_DELETE = 'postDelete';

    /**
     * Constructeur par défaut.
     *
     * @param \Zend\Db\Adapter\Adapter $oAdapter
     * @param string $table
     */
    public function __construct(Adapter $oAdapter, $table = null) {
        if ($table) {
            $this->table = $table;
        }
        $this->adapter = $oAdapter;
        $this->initialize();
    }

    /**
     * Retourne le proptotype utilisé pour faire le lien table / objet.
     * @return type
     */
    function getArrayObjectPrototypeClass() {
        return $this->arrayObjectPrototypeClass;
    }

    /**
     * Retourne le code sql de la $query.
     *
     * @param Sql $query
     * @return string
     */
    protected function getSqlString($query) {
        return $query->getSqlString($this->adapter->getPlatform());
    }

    /**
     * Debug la $query.
     * Echo string of query and die;
     *
     * @param type $query
     */
    protected function debug($query) {
        echo $query->getSqlString($this->adapter->getPlatform());
        die();
    }

    /**
     * Retourne un nouvel objet sql.
     *
     * @return \Zend\Db\Sql\Sql
     */
    public function getSql() {
        return new Sql($this->getAdapter());
    }

    /**
     * Commence une transaction.
     */
    public function beginTransaction() {
        $this->getAdapter()
                ->getDriver()
                ->getConnection()
                ->beginTransaction();
    }

    /**
     * Commit la transaction courante.
     */
    public function commit() {
        $this->getAdapter()
                ->getDriver()
                ->getConnection()
                ->commit();
    }

    /**
     * Rollback la transaction courante.
     */
    public function rollback() {
        $this->getAdapter()
                ->getDriver()
                ->getConnection()
                ->rollback();
    }

    /**
     * Retourne une ligne pour la clé étrangère dépendant du prototypeClass.
     *
     * @param mixed | string | int $id
     * @param null | string $protypeClass
     * @return mixed Retourne le model dépendant du prototypeClass
     */
    public function findRow($id, $prototypeClass = null) {
        $id = (int) $id;

        $oRowset = $this->select(array(
            $this->nomCle => $id
        ));

        $arrayObjectPrototypeClass = ($prototypeClass) ? $prototypeClass : $this->arrayObjectPrototypeClass;
        $oRowset->setArrayObjectPrototype(new $arrayObjectPrototypeClass());
        return $oRowset->current();
    }

    public function selectBy(array $array) {
        $oRowset = $this->select($array);
        return $oRowset->current();
    }

    /**
     * Retourne une ligne pour la clé étrangère.
     *
     * @param  mixed | string | int $id
     * @return mixed Retourne le model dépendant du prototypeClass par défaut.
     */
    public function getRow($id) {
        return $this->findRow($id);
    }

    /**
     * Retourne une ligne en fonction de la query passé.
     *
     * @param \Zend\Db\Sql\Select $oQuery
     * @param string | $prototypeClass
     * @return mixed
     */
    public function fetchRow(\Zend\Db\Sql\Select $oQuery = null, $prototypeClass = null) {
        if (!$oQuery) {
            $oQuery = $this->getBaseQuery()->limit(1);
        }

        $oStmt = $this->getSql()->prepareStatementForSqlObject($oQuery);
        $oRes = $oStmt->execute();

        $oResultSet = new ResultSet();
        $arrayObjectPrototypeClass = ($prototypeClass) ? $prototypeClass : $this->arrayObjectPrototypeClass;
        $oResultSet->setArrayObjectPrototype(new $arrayObjectPrototypeClass());

        $oResultSet->initialize($oRes);

        return $oResultSet->current();
    }

    /**
     * Retourne la premier ligne de la cette table respectant la clause Where
     *
     * @param Where $oWhere
     * @param mixed $order
     * @return mixed
     */
    public function fetchRowWhere(Where $oWhere, $order = null) {
        $oQuery = $this->getBaseQuery();
        $oQuery->where($oWhere);
        if (!is_null($order)) {
            $oQuery->order($order);
        }
        return $this->fetchRow($oQuery);
    }

    /**
     * Retourne les enregistrement de la query donnée.
     *
     * @param \Zend\Db\Sql\Select $oQuery
     * @param string | null $prototypeClass
     * @return \Zend\Db\ResultSet\ResultSet
     */
    public function fetchAll(\Zend\Db\Sql\Select $oQuery = null, $prototypeClass = null) {
        if (!$oQuery) {
            $oQuery = $this->getBaseQuery();
        }

        $oStmt = $this->getSql()->prepareStatementForSqlObject($oQuery);
        $oRes = $oStmt->execute();

        $oResultSet = new ResultSet();
        $arrayObjectPrototypeClass = (strlen($prototypeClass) > 0) ? $prototypeClass : $this->arrayObjectPrototypeClass;
        $oResultSet->setArrayObjectPrototype(new $arrayObjectPrototypeClass());

        $oResultSet->initialize($oRes);

        return $oResultSet;
    }

    /**
     * Retourne les enregistrement de la table correspodant a la clause WHERE.
     *
     * @param Where $oWhere
     * @param mixed $order
     * @return \Zend\Db\ResultSet\ResultSet
     */
    public function fetchAllWhere($oWhere, $order = null) {
        $oQuery = $this->getBaseQuery();
        $oQuery->where($oWhere);
        if (!is_null($order)) {
            $oQuery->order($order);
        }
        return $this->fetchAll($oQuery);
    }

    /**
     * Retourne le select query deja configuré par l'adapter et le nom de la table.
     *
     * @return Zend\Db\Sql\Select
     */
    public function getBaseQuery() {
        $sql = new Sql($this->getAdapter());
        $query = $sql->select();
        $query->from($this->table)->columns(array(
            '*'
        ));
        return $query;
    }

    /**
     * Retourne le nom de la clé a utiliser pour la recherche.
     *
     * @return string
     */
    public function getNomCle() {
        return $this->nomCle;
    }

    /**
     * Définit le nom de la clé a utiliser pour la recherche.
     *
     * @return string
     */
    public function setCleNom($sNomCle) {
        $this->nomCle = $sNomCle;
    }

    /**
     * Définit l'instance de eventmanager.
     *
     * @param \Zend\EventManager\EventManagerInterface $events
     * @return type
     */
    public function setEventManager(EventManagerInterface $events) {
        $events->setIdentifiers(array(
            __CLASS__,
            get_called_class()
        ));
        $this->events = $events;
        return $this;
    }

    /**
     * Retourne l' eventmanager
     *
     * @return \Zend\EventManager\EventManager
     */
    public function getEventManager() {
        if (null === $this->events) {
            $this->setEventManager(new EventManager());
        }
        return $this->events;
    }

    /**
     * Insert l'objet en base.
     *
     * @param mixed $mObject
     * @return int
     * @throws \Exception\BadMethodCallException
     */
    public function insert($mObject) {
        if (is_array($mObject)) {
            return parent::insert($mObject);
        }

        if (!is_callable(array(
                    $mObject,
                    'getArrayCopy'
                ))) {
            throw new \BadMethodCallException(sprintf('%s attend que l\'objet fournit implémente la méthode getArrayCopy()', __METHOD__));
        }

        $preInsertMethodName = $this->eventActions[self::PRE_INSERT];
        $postInsertMethodName = $this->eventActions[self::POST_INSERT];

        if (method_exists($mObject, $preInsertMethodName)) {
            $mObject->$preInsertMethodName($this->getEventManager());
        }

        $set = $mObject->getArrayCopy();

        if (isset($set[$this->nomCle])) {
            unset($set[$this->nomCle]);
        }

        $res = parent::insert($set);

        if (method_exists($mObject, $postInsertMethodName)) {
            $mObject->$postInsertMethodName($this->getEventManager());
        }

        return $res;
    }

    /**
     * Met à jour un objet en base.
     *
     * @param mixed $mObject
     * @return int
     * @throws \Exception\BadMethodCallException
     */
    public function update($mObject, $where = null) {
        $issetKey = (is_array($mObject)) ? isset($mObject[$this->nomCle]) : isset($mObject->{$this->nomCle});

        if (!$where && !$issetKey) {
            throw new \Exception(sprintf('%s attend que l\'objet fournit est une clé de définit', __METHOD__));
        }
        if (is_array($mObject)) {
            $id = $mObject[$this->nomCle];
            unset($mObject[$this->nomCle]);
            $where = ($where) ? $where : array(
                $this->nomCle => $id
            );

            return parent::update($mObject, $where);
        }

        if (!is_callable(array(
                    $mObject,
                    'getArrayCopy'
                ))) {
            throw new \BadMethodCallException(sprintf('%s attend que l\'objet fournit implémente la méthode getArrayCopy()', __METHOD__));
        }

        $preUpdateMethodName = $this->eventActions[self::PRE_UPDATE];
        $postUpdateMethodName = $this->eventActions[self::POST_UPDATE];

        if (method_exists($mObject, $preUpdateMethodName)) {
            $mObject->$preUpdateMethodName($this->getEventManager());
        }
        $set = $mObject->getArrayCopy();
        $id = $set[$this->nomCle];
        unset($set[$this->nomCle]);
        $where = ($where) ? $where : array(
            $this->nomCle => $id
        );
//        try {
        $res = parent::update($set, $where);
//        } catch (\Exception $e) {
//            \Zend\Debug\Debug::dump($e->__toString());
//            exit;
//        }
        if (method_exists($mObject, $postUpdateMethodName)) {
            $mObject->$postUpdateMethodName($this->getEventManager());
        }

        return $res;
    }

    /**
     *  Supprime un objet en base.
     *
     * @param mixed $mObjectOuWhere
     */
    public function delete($mObjectOuWhere) {
        $isEntityObjectDelete = $mObjectOuWhere instanceof \Core\Model\AbstractModel;

        if ($isEntityObjectDelete) {
            $object = $mObjectOuWhere;
            $id = (is_array($object)) ? $object[$this->nomCle] : $object->{$this->nomCle};
            $where = array(
                $this->nomCle => $id
            );
        } else {
            $where = $mObjectOuWhere;
        }

        $preDeleteMethodName = $this->eventActions[self::PRE_DELETE];
        $postDeleteMethodName = $this->eventActions[self::POST_DELETE];

        if ($isEntityObjectDelete && method_exists($object, $preDeleteMethodName)) {
            $object->$preDeleteMethodName($this->getEventManager());
        }

        parent::delete($where);

        if ($isEntityObjectDelete && method_exists($object, $postDeleteMethodName)) {
            $object->$postDeleteMethodName($this->getEventManager());
        }
    }

}
