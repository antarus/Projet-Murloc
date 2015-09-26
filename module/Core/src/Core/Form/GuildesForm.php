<?php

namespace Core\Form;

/**
 * @author Antarus
 * @project Murloc avenue
 */
class GuildesForm extends \Core\Form\AbstractServiceForm {

    public function __construct(\Zend\ServiceManager\ServiceLocatorInterface $oServLocat = null) {
        parent::__construct('guildes', $oServLocat);
        $this->setAttribute('method', 'post');

        $this->add(array(
            'name' => 'idGuildes',
            'attributes' => array(
                'type' => 'hidden',
            ),
        ));
        $this->add(array(
            'name' => 'idJeux',
            'attributes' => array(
                'type' => 'hidden',
            ),
        ));
//        $this->add(array(
//            'type' => 'Core\Form\Element\ObjectSelect',
//            'name' => 'idJeux',
//            'attributes' => array(
//                'class' => 'form-control'
//            ),
//            'options' => array(
//                'label' => 'Jeux',
//                'service_manager' => $this->getServiceLocator(),
//                'target_class' => 'Core\Table\JeuxTable',
//                'property' => 'nom',
//                'empty_option' => $this->getServiceLocator()->get('translator')->translate('---Veuillez choisir ---')
//            ),
//        ));
        $this->add(array(
            'name' => 'nom',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control'
            ),
            'options' => array(
                'label' => 'Nom',
            ),
        ));

//        $this->add(array(
//            'name' => 'serveur',
//            'attributes' => array(
//                'type' => 'text',
//                'class' => 'form-control'
//            ),
//            'options' => array(
//                'label' => 'Serveur',
//            ),
//        ));
//        $this->add(array(
//            'name' => 'idJeux',
//            'attributes' => array(
//                'type' => 'text',
//                'class' => 'form-control'
//            ),
//            'options' => array(
//                'label' => 'IdJeux',
//            ),
//        ));



        $this->add(array(
            'name' => 'data',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control'
            ),
            'options' => array(
                'label' => 'Data',
            ),
        ));

        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Go',
                'id' => 'submitbutton',
                'class' => 'form-control btn-success',
                'style' => 'width: 50%'
            ),
        ));
    }

}
