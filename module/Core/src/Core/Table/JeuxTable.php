<?php

namespace Core\Table;

/**
 * @author Antarus
 * @project Murloc avenue
 */
class JeuxTable extends \Core\Table\AbstractTable
{

    /**
     * Nom de la  table.
     *
     * @var string
     */
    protected $table = 'jeux';

    /**
     * Objet référent.
     *
     * @var \Backend\Model\Jeux
     */
    protected $arrayObjectPrototypeClass = '\\Core\\Model\\Jeux';

    /**
     * Clé primaire de la table.
     *
     * @var int
     */
    protected $nomCle = 'idJeux';


}

