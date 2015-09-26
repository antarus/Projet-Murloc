<?php

namespace Core\Form;

/**
 * @author Antarus
 * @project Murloc avenue
 */
class RosterForm extends \Core\Form\AbstractForm
{

    public function __construct()
    {
        parent::__construct('roster');
        $this->setAttribute('method', 'post');

        $this->add(array(
           'name' => 'idRoster',
           'attributes' => array(
               'type'  => 'hidden',
           ),
        ));

        $this->add(array(
            'name' => 'nom',
            'attributes' => array(
                'type'  => 'text',
                'class' => 'form-control'
            ),
            'options' => array(
                'label' => 'Nom',
            ),
        ));

        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Go',
                'id' => 'submitbutton',
                'class' => 'form-control btn-success',
                'style' => 'width: 50%'
            ),
        ));
    }


}

