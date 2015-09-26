<?php

namespace Core\Grid;

use \Zend\ServiceManager\ServiceLocatorInterface;
use \Zend\Mvc\Controller\PluginManager;
use \Zend\Mvc\Controller\Plugin\Url;

/**
 * @author Antarus
 * @project Murloc avenue
 */
class AppPluginGrid extends \ZfTable\AbstractTable {

    /**
     * @var ServiceLocatorInterface
     */
    private $_serviceLocator = null;

    /**
     * @var \Zend\Mvc\Controller\PluginManager
     */
    private $_pluginManager = null;

    /**
     * @var \Zend\Mvc\Controller\Plugin\Url
     */
    private $_url = null;

    /**
     * @var \Zend\I18n\Translator\Translator
     */
    private $_servTranslator = null;
    protected $config = array(
        'name' => 'Liste des jeux',
        'showPagination' => true,
        'showQuickSearch' => false,
        'showItemPerPage' => true,
        'showColumnFilters' => true,
    );

    /**
     * @var array Definition of headers
     */
    protected $headers = array(
        'Nom' => array('title' => 'Nom', 'width' => '50', 'filters' => 'text'),
        'Installe' => array('title' => 'Installer', 'filters' => 'text'),
        'Actif' => array('title' => 'Actif', 'filters' => 'text'),
    );

    /**
     * Constructeur du tableau.
     *
     * @param ServiceLocatorInterface
     * @param PluginManager
     */
    public function __construct(ServiceLocatorInterface $oServiceLocator, PluginManager $oPluginManager) {
        $this->_serviceLocator = $oServiceLocator;
        $this->_pluginManager = $oPluginManager;
    }

    /**
     * Retourne le plugin url.
     *
     * @var \Zend\Mvc\Controller\PluginManager
     */
    public function url() {
        if (!$this->_url) {
            $this->_url = $this->_pluginManager->get('url');
        }
        return $this->_url;
    }

    /**
     * Retourne le translator.
     *
     * @var \Zend\I18n\Translator\Translator
     */
    public function _getServTranslator() {
        if (!$this->_servTranslator) {
            $this->_servTranslator = $this->_serviceLocator->get('translator');
        }
        return $this->_servTranslator;
    }

    public function init() {
        $this->getHeader("Installe")->getCell()->addDecorator("callable", array(
            "callable" => function($context, $record) {
                $sBtnType = $record["Installe"] ? 'btn-danger' : 'btn-info';
                $sRoute = $record["Installe"] ? $this->url()->fromRoute('backend-plugin-desinstall', array('nomCourt' => $record["Nom"])) : $this->url()->fromRoute('backend-plugin-install', array('nomCourt' => $record["Nom"]));
                $sTxtBoutton = $record["Installe"] ? $this->_getServTranslator()->translate("Désinstaller") : $this->_getServTranslator()->translate("Installer");
                return sprintf("<a class=\"btn " . $sBtnType . "\" href=\"" . $sRoute . "\"><span class=\"glyphicon glyphicon-pencil \"></span>&nbsp;" . $sTxtBoutton . "</a>", $record["Nom"]);
            }
                ));

                $this->getHeader("Actif")->getCell()->addDecorator("callable", array(
                    "callable" => function($context, $record) {
                        if (!$record["Installe"]) {
                            return $this->_getServTranslator()->translate("Non");
                        }
                        $sBtnType = $record["Actif"] ? 'btn-danger' : 'btn-info';
                        $sRoute = $record["Actif"] ? $this->url()->fromRoute('backend-plugin-desactif', array('nomCourt' => $record["Nom"])) : $this->url()->fromRoute('backend-plugin-actif', array('nomCourt' => $record["Nom"]));
                        $sTxtBoutton = $record["Actif"] ? $this->_getServTranslator()->translate("Désactiver") : $this->_getServTranslator()->translate("Activer");
                        return sprintf("<a class=\"btn " . $sBtnType . "\" href=\"" . $sRoute . "\"><span class=\"glyphicon glyphicon-pencil \"></span>&nbsp;" . $sTxtBoutton . "</a>", $record["Nom"]);
                    }
                        ));
                    }

                    protected function initFilters($arrayData) {
                        $keys = array();

                        foreach ($arrayData as $key => $row) {
                            if ($value = $this->getParamAdapter()->getValueOfFilter('Nom')) {
                                if (strpos($row['Nom'], $value) === false && !isset($keys[$key])) {
                                    $keys[] = $key;
                                }
                            }
                            if ($value = $this->getParamAdapter()->getValueOfFilter('Installe')) {
                                if (strpos($row['Installe'], $value) === false && !isset($keys[$key])) {
                                    $keys[] = $key;
                                }
                            }
                            if ($value = $this->getParamAdapter()->getValueOfFilter('Actif')) {
                                if (strpos($row['Actif'], $value) === false && !isset($keys[$key])) {
                                    $keys[] = $key;
                                }
                            }
                        }

                        foreach ($keys as $key) {
                            unset($arrayData[$key]);
                        }
                    }

                }
