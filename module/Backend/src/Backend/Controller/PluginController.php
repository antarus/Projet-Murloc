<?php

namespace Backend\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class PluginController extends AbstractActionController {

    public $_servTranslator = null;
    public $_table = null;
    public $_servJeu;

    /**
     * Retourne le service de traduction en mode lazy.
     *
     * @return
     */
    public function _getServTranslator() {
        if (!$this->_servTranslator) {
            $this->_servTranslator = $this->getServiceLocator()->get('translator');
        }
        return $this->_servTranslator;
    }

    /**
     * Retourne le service de traduction en mode lazy.
     *
     * @return \Core\Service\JeuxService
     */
    public function _getServJeu() {
        if (!$this->_servJeu) {
            $this->_servJeu = $this->getServiceLocator()->get('Core\Service\JeuxService');
        }
        return $this->_servJeu;
    }

    /**
     * Retourne l'ecran de liste.
     * Affiche uniquement la page. Les données sont chargées via ajax plus tard.
     *
     * @return le template de la page liste.
     */
    public function listAction() {

    }

    /**
     * Action pour le listing via AJAX.
     *
     * @return reponse au format Ztable
     */
    public function ajaxListAction() {
        $ret = $this->getEventManager()->trigger('plugin.list.pre', $this);
        $oGrid = new \Core\Grid\AppPluginGrid($this->getServiceLocator(), $this->getPluginManager());
        $aJeux = $this->_getServJeu()->getJeuxDisponible();
        $oGrid->setAdapter($this->getAdapter())
                ->setSource($aJeux)
                ->setParamAdapter($this->getRequest()->getPost());
        $this->getEventManager()->trigger('plugin.list.post', $this, array(
            'grid' => $oGrid,
        ));

        return $this->htmlResponse($oGrid->render());
    }

    /**
     * Retourne l'adapter associé a ce modèle.
     *
     * @return \Zend\Db\Adapter\Adapter
     */
    public function getAdapter() {
        return new \ZfTable\Source\ArrayAdapter(array());
    }

    /**
     * Retourne une response en tant que html.
     *
     * @return page html
     */
    public function htmlResponse($html) {
        $response = $this->getResponse()
                ->setStatusCode(200)
                ->setContent($html);
        return $response;
    }

    public function desinstallAction() {
        return $this->majInstallationPlugin(false);
    }

    public function installAction() {
        return $this->majInstallationPlugin(true);
    }

    public function activeAction() {
        return $this->majActivationPlugin(true);
    }

    public function desactiveAction() {
        return $this->majActivationPlugin(false);
    }

    protected function majInstallationPlugin($bStatus) {
        $sAct = $this->params()->fromRoute('nomCourt', '');
        $this->_getServJeu()->majInstallationPlugin($sAct, $bStatus);
        if ($bStatus) {
            $this->flashMessenger()->addMessage($this->_getServTranslator()->translate("Le jeu '" . $sAct . "' a été installé avec succès."), 'success');
        } else {
            $this->flashMessenger()->addMessage($this->_getServTranslator()->translate("Le jeu '" . $sAct . "' a été désinstallé avec succès."), 'success');
        }

        return $this->redirect()->toRoute('backend-plugin-list');
    }

    protected function majActivationPlugin($bStatus) {
        $sAct = $this->params()->fromRoute('nomCourt', '');
        $this->_getServJeu()->majActivationPlugin($sAct, $bStatus);
        if ($bStatus) {
            $this->flashMessenger()->addMessage($this->_getServTranslator()->translate("Le jeu '" . $sAct . "' a été activé avec succès."), 'success');
        } else {
            $this->flashMessenger()->addMessage($this->_getServTranslator()->translate("Le jeu '" . $sAct . "' a été désactivé avec succès."), 'success');
        }

        return $this->redirect()->toRoute('backend-plugin-list');
    }

}
