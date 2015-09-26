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
            $this->_servGuildes = $this->getServiceLocator()->get('Guildes\Service\Guildes');
        }
        return $this->_servGuildes;
    }

    /**
     * Retourne le service de gestion des jeux.
     * @return type
     */
    private function _getServJeux() {
        if (!$this->_servJeux) {
            $this->_servJeux = $this->getServiceLocator()->get('Jeux\Service\Jeux');
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
//        $guild = $this->_getServBnet()->warcraft(new Region(Region::EUROPE))->guilds();
//        $guild->on("garona");
//        $aListeGuilde = $guild->find("mystra");

        $aListeGuilde = $this->_getServGuildes()->fetchAll();
        return new ViewModel(array('guildes' => $aListeGuilde));
    }

    /**
     * Ajout d'une guilde.
     * @return ViewModel
     */
    public function addAction() {
        $oRequest = $this->getRequest();
        $aGuilde = array('nom' => '',
            'serveur' => '',
            'idJeux' => '');
        if ($oRequest->isPost()) {
            $aPost = $oRequest->getPost();
            $aGuilde = array('nom' => $aPost['nom'],
                'serveur' => $aPost['serveur'],
                'idJeux' => $aPost['jeux']);
            if ($this->_getServGuildes()->isValid($aGuilde)) {
                $this->_getServGuildes()->save($aGuilde);
                $this->flashMessenger()->addMessage($this->_getServTranslator()->translate("La guilde a été créée avec succès."), 'success');
                return $this->redirect()->toRoute('guildes-liste');
            }
        }
        return new ViewModel(array('guilde' => $aGuilde, 'jeux' => $this->_getServJeux()->fetchAll()));
    }

    /**
     * Modification d'une guilde.
     * @return ViewModel
     */
    public function editAction() {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('guildes-add');
        }
        try {
            $aGuilde = $this->_getServGuildes()->getById($id);
        } catch (\Exception $ex) {
            return $this->redirect()->toRoute('guildes-liste');
        }
        $oRequest = $this->getRequest();
        if ($oRequest->isPost()) {
            $aPost = $oRequest->getPost();
            $aGuilde = array('idGuildes' => $aPost['id'],
                'nom' => $aPost['nom'],
                'serveur' => $aPost['serveur'],
                'idJeux' => $aPost['jeux']);
            if ($this->_getServGuildes()->isValid($aGuilde)) {
                $this->_getServGuildes()->update($aGuilde);
                $eventParams = array(
                    'viewModel' => '$viewModel',
                    'form' => '$form',
                    'entity' => '$entity',
                );
                $ret = $this->getEventManager()->trigger('update.persist', $this, $eventParams, function($ret) {
                    return ($ret instanceof Response);
                });

                $this->flashMessenger()->addMessage($this->_getServTranslator()->translate("La guilde a été modifiée avec succès."), 'success');
                return $this->redirect()->toRoute('guildes-liste');
            }
        }

        return new ViewModel(array('id' => $id,
            'guilde' => $aGuilde,
            'jeux' => $this->_getServJeux()->fetchAll())
        );
    }

    /**
     * Suppression d'une guilde.
     * @return ViewModel
     */
    public function removeAction() {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('guildes-liste');
        }
        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'Non');
            if ($del == 'Oui') {
                $id = (int) $request->getPost('id');
                if (!$this->_getServGuildes()->delete($id)) {
                    $this->flashMessenger()->addMessage($this->_getServTranslator()->translate("Une erreur est survenue lors de la suppression de la guilde."), 'error');
                } else {
                    $this->flashMessenger()->addMessage($this->_getServTranslator()->translate("La guilde a été supprimée avec succès."), 'success');
                }
            }
            return $this->redirect()->toRoute('guildes-liste');
        }

        return new ViewModel(array('id' => $id, 'guilde' => $this->_getServGuildes()->getById($id)));
    }

}
