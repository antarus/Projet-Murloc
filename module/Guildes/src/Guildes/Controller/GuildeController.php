<?php

/**
 * @author Cedric durand
 */

namespace Guildes\Controller;

use Application\Service\LogService;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use \Bnet\Region;
use \Bnet\ClientFactory;

/**
 * Controller principal du module guilde
 */
class GuildeController extends AbstractActionController {

    private $_servTranslator;
    private $_logService;
    private $_servGuildes;
    private $_servJeux;

    /**
     *
     * @var Bnet\ClientFactory
     */
    private $_servBnet;

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
     * Retourne le service de gestion des guildes.
     * @return type
     */
    private function _getServGuildes() {
        if (!$this->_servGuildes) {
            $this->_servGuildes = $this->getServiceLocator()->get('Guildes\Model\Guildes');
        }
        return $this->_servGuildes;
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
     * Retourne le service de gestion des jeux.
     * @return Bnet\ClientFactory
     */
    private function _getServBnet() {
        if (!$this->_servBnet) {
            $this->_servBnet = $this->getServiceLocator()->get('Bnet\ClientFactory');
        }
        return $this->_servBnet;
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
     * Affiche la liste des guildes.
     * @return ViewModel
     */
    public function listeAction() {
        //$this->_getLogService()->log(LogService::INFO, "test log. IndexAction", LogService::USER);
        $sMessenger = $this->flashMessenger();
        $sMessenger->setNamespace('err');
        $sErrorMessage = $sMessenger->getMessages();
        $sMessenger->setNamespace('info');
        $sInfosMessage = $sMessenger->getMessages();

//        $guild = $this->_getServBnet()->warcraft(new Region(Region::EUROPE))->guilds();
//        $guild->on("garona");
//        $aListeGuilde = $guild->find("mystra");
        $aListeGuilde = $this->_getServGuildes()->fetchAll();
        return new ViewModel(array('err' => $sErrorMessage,
            'info' => $sInfosMessage, 'guildes' => $aListeGuilde));
    }

    /**
     * Ajout d'une guilde
     * @return ViewModel
     */
    public function addAction() {
        $sMessenger = $this->flashMessenger();
        $sMessenger->setNamespace('err');
        $sErrorMessage = $sMessenger->getMessages();
        $sMessenger->setNamespace('info');
        $sInfosMessage = $sMessenger->getMessages();
        $aRequest = $this->getRequest();


        if ($aRequest->isPost()) {

            $aPost = $aRequest->getPost();
            if (!isset($aPost['nom']) || empty($aPost['nom'])) {
                $this->_getLogService()->log(LogService::INFO, $this->_getServTranslator()->translate("Guilde - Nom manquant."), LogService::USER);
                $sErrorMessage[] = $this->_getServTranslator()->translate("Guilde - Nom manquant");
                $this->layout()->setVariable('err', $sErrorMessage);
                return new ViewModel(array('jeux' => $this->_getServJeux()->fetchAll()));
            }
            if (!isset($aPost['serveur']) || empty($aPost['serveur'])) {
                $this->_getLogService()->log(LogService::INFO, $this->_getServTranslator()->translate("Guilde - Nom manquant."), LogService::USER);
                $sErrorMessage[] = $this->_getServTranslator()->translate("Guilde - Serveur manquant");
                $this->layout()->setVariable('err', $sErrorMessage);
                return new ViewModel(array('jeux' => $this->_getServJeux()->fetchAll()));
            }

            if (!isset($aPost['jeux']) || empty($aPost['jeux'])) {
                $this->_getLogService()->log(LogService::INFO, $this->_getServTranslator()->translate("Guilde - Nom manquant."), LogService::USER);
                $sErrorMessage[] = $this->_getServTranslator()->translate("Guilde - Jeux manquant");
                $this->layout()->setVariable('err', $sErrorMessage);
                return new ViewModel(array('jeux' => $this->_getServJeux()->fetchAll()));
            }
            $aGuilde = array('nom' => $aPost['nom'],
                'serveur' => $aPost['serveur'],
                'idJeux' => $aPost['jeux']);
            if (isset($aPost['idGuildes'])) {
                $aGuilde['idGuildes'] = $aPost['idGuildes'];
            }
            $this->_getServGuildes()->save($aGuilde);

            return $this->redirect()->toRoute('guildes-liste');
        }

        $this->layout()->setVariable('err', $sErrorMessage);
        $this->layout()->setVariable('info', $sInfosMessage);
        return new ViewModel(array('jeux' => $this->_getServJeux()->fetchAll()));
    }

    /**
     * Modification d'une guilde.
     * @return ViewModel
     */
    public function editAction() {

    }

    /**
     * Suppression d'une guilde.
     * @return ViewModel
     */
    public function removeAction() {

    }

}
