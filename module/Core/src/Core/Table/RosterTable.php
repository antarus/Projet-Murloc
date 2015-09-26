<?php

namespace Core\Table;

/**
 * @author Antarus
 * @project Murloc avenue
 */
class RosterTable extends \Core\Table\AbstractTable
{

    /**
     * Nom de la  table.
     *
     * @var string
     */
    protected $table = 'roster';

    /**
     * Objet référent.
     *
     * @var \Backend\Model\Roster
     */
    protected $arrayObjectPrototypeClass = '\\Core\\Model\\Roster';

    /**
     * Clé primaire de la table.
     *
     * @var int
     */
    protected $nomCle = 'idRoster';


}

