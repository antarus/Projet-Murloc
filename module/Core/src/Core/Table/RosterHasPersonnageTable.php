<?php

namespace Core\Table;

/**
 * @author Antarus
 * @project Murloc avenue
 */
class RosterHasPersonnageTable extends \Core\Table\AbstractTable
{

    /**
     * Nom de la  table.
     *
     * @var string
     */
    protected $table = 'roster_has_personnage';

    /**
     * Objet référent.
     *
     * @var \Backend\Model\RosterHasPersonnage
     */
    protected $arrayObjectPrototypeClass = '\\Core\\Model\\RosterHasPersonnage';

    /**
     * Clé primaire de la table.
     *
     * @var int
     */
    protected $nomCle = 'idRoster';


}

