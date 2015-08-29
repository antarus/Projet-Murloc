<?php

/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Jeux\Controller;

use Application\Service\LogService;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

/**
 * Controller principal du module jeux
 */
class JeuxController extends AbstractActionController {

    private $_servTranslator;
    private $_logService;
    private $_servJeux;

    /**
     * Retourne le service de traduction.
     * @return translator
     */
    private function _getServTranslator() {
        if (!$this->_servTranslator) {
            $this->_servTranslator = $this->getServiceLocator()->get('translator');
        }
        return $this->_servTranslator;
    }

    /**
     * Retourne le service de logging.
     * @return type
     */
    private function _getLogService() {
        return $this->_logService ?
                $this->_logService :
                $this->_logService = $this->getServiceLocator()->get('LogService');
    }

    /**
     * Retourne le service de gestion des jeux.
     * @return type
     */
    private function _getServJeux() {
        if (!$this->_servJeux) {
            $this->_servJeux = $this->getServiceLocator()->get('Jeux\Model\Jeux');
        }
        return $this->_servJeux;
    }

    /**
     * Action par defaut du controller.
     *
     * Affiche la liste des guildes.
     * @return ViewModel
     */
    public function indexAction() {
        return $this->listeAction();
    }

    /**
     * Affiche la liste des jeux.
     * @return ViewModel
     */
    public function listeAction() {
        //$this->_getLogService()->log(LogService::INFO, "test log. IndexAction", LogService::USER);
        $sMessenger = $this->flashMessenger();
        $sMessenger->setNamespace('err');
        $sErrorMessage = $sMessenger->getMessages();
        $sMessenger->setNamespace('info');
        $sInfosMessage = $sMessenger->getMessages();
        $aListeJeux = $this->_getServJeux()->fetchAll();
        return new ViewModel(array('err' => $sErrorMessage,
            'info' => $sInfosMessage, 'jeux' => $aListeJeux));
    }

    /**
     * Ajout d'un jeu.
     * @return ViewModel
     */
    public function addAction() {

    }

    /**
     * Modification d'un jeu.
     * @return ViewModel
     */
    public function editAction() {

    }

    /**
     * Suppression d'un jeu.
     * @return ViewModel
     */
    public function removeAction() {

    }

}
