<?php

namespace Core\Filter;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilterInterface;

/**
 * Classe de base pour les filtres permettant de stocker la factory et les inputfilter.
 *
 * @author Antarus
 * @project Murloc avenue
 */
class AbstractFilter {

    /**
     *
     * @var \Zend\InputFilter\Factory
     */
    protected $oInputFactory;

    /**
     *
     * @var \Zend\InputFilter\InputFilterInterface
     */
    protected $oInputFilter;

    /**
     * Retourne le inputfilter.
     * Instance un nouveau inputFilter si il est actuellement null.
     *
     * @return \Zend\InputFilter\InputFilter
     */
    public function getInputFilter() {
        if (!$this->oInputFilter) {
            $this->oInputFilter = new InputFilter();
        }
        return $this->oInputFilter;
    }

    /**
     * Définit le inputfilter.
     *
     * @param \Zend\InputFilter\InputFilterInterface $oInputFilter
     * @throws \Exception
     */
    public function setInputFilter(InputFilterInterface $oInputFilter) {
        $this->oInputFilter = $oInputFilter;
    }

    /**
     * Retourne le inputFactory.
     * Instanciee une nouvelle fabrique inputFactory si elle est actuellement null.
     *
     *
     * @return \Zend\InputFilter\Factory
     */
    public function getInputFactory() {
        if (!$this->oInputFactory) {
            $this->oInputFactory = new InputFactory();
        }
        return $this->oInputFactory;
    }

    /**
     * Définit le inputFactory.
     *
     * @param \Zend\InputFilter\Factory $oInputFactory
     */
    public function setInputFactory(\Zend\InputFilter\Factory $oInputFactory) {
        $this->oInputFactory = $oInputFactory;
    }

}
