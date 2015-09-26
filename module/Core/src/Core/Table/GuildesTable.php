<?php

namespace Core\Table;

use Zend\Db\Sql\Predicate\Expression;

/**
 * @author Antarus
 * @project Murloc avenue
 */
class GuildesTable extends \Core\Table\AbstractTable {

    /**
     * Nom de la  table.
     *
     * @var string
     */
    protected $table = 'guildes';

    /**
     * Objet référent.
     *
     * @var \Backend\Model\Guildes
     */
    protected $arrayObjectPrototypeClass = '\\Core\\Model\\Guildes';

    /**
     * Clé primaire de la table.
     *
     * @var int
     */
    protected $nomCle = 'idGuildes';

    /**
     *
     * @return Zend\Db\Sql\Select
     */
    public function getSelectListeJointe() {
        $sql = $this->getSql();
        $query = $sql->select();
        $query->from(array('gu' => $this->table))->columns(array(
            '*'
        ));
        $query->join(array('j' => 'jeux'), 'gu.idJeux = j.idJeux', array(), $query::JOIN_LEFT);
        $query->columns(array(
            'idGuildes' => new Expression('gu.idGuildes'),
            'nom' => new Expression('gu.nom'),
            'nomJeux' => new Expression('j.nom')));

        return $query;
    }

}
