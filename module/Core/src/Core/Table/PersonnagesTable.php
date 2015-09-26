<?php

namespace Core\Table;

/**
 * @author Antarus
 * @project Murloc avenue
 */
class PersonnagesTable extends \Core\Table\AbstractTable
{

    /**
     * Nom de la  table.
     *
     * @var string
     */
    protected $table = 'personnages';

    /**
     * Objet référent.
     *
     * @var \Backend\Model\Personnages
     */
    protected $arrayObjectPrototypeClass = '\\Core\\Model\\Personnages';

    /**
     * Clé primaire de la table.
     *
     * @var int
     */
    protected $nomCle = 'idPersonnage';


}

