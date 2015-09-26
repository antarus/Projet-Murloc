<?php

namespace Jeux\Wow\Controller;

use Zend\View\Model\ViewModel;
use \Bnet\Region;
use \Bnet\ClientFactory;

/**
 * Controller specifique au plugin wow.
 *
 * @author Antarus
 * @project Murloc avenue
 */
class WowGuildeController extends \Zend\Mvc\Controller\AbstractActionController {

    private $_servBnet;
    private $_table;
    public $_servTranslator = null;

    /**
     * Retourne le service de battlnet.
     * @return \Bnet\ClientFactory
     */
    private function _getServBnet() {
        if (!$this->_servBnet) {
            $this->_servBnet = $this->getServiceLocator()->get('Bnet\ClientFactory');
        }
        return $this->_servBnet;
    }

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
     * Returne une instance de la table en lazy.
     *
     * @return \Core\Table\GuildesTable
     */
    public function getTable() {
        if (!$this->_table) {
            $this->_table = $this->getServiceLocator()->get('\Core\Table\GuildesTable');
        }
        return $this->_table;
    }

    /**
     * Action pour la création.
     *
     * @return array
     */
    public function afficheImportUpdateAction() {
        $iId = (int) $this->params()->fromRoute('id', 0);
//        try {
//            $oEntite = $this->getTable()->findRow($iId);
//            if (!$oEntite) {
//                $this->flashMessenger()->addMessage($this->_getServTranslator()->translate("Identifiant de guildes inconnu."), 'error');
//                return $this->redirect()->toRoute('backend-guildes-list');
//            }
//        } catch (Exception $ex) {
//            $this->flashMessenger()->addMessage($this->_getServTranslator()->translate("Une erreur est survenue lors de la récupération de la guildes."), 'error');
//            return $this->redirect()->toRoute('backend-guildes-list');
//        }
//        if ($this->getRequest()->isXmlHttpRequest()) {
        $this->layout('layout/ajax');
//        }
//        $oRequest = $this->getRequest();
//        $aPost = $oRequest->getPost();
//        $aGuilde = array(
//            'nom' => $oEntite->getNom(),
//            'serveur' => '', //TODO extrait les information dans la colonne Data
//            'lvlMin' => '',
//            'imp-membre' => 'Oui',
//        );
// Pour optimiser le rendu
        $oViewModel = new ViewModel();
        $oViewModel->setTemplate('wow/guilde/import-option-dlg');
//        $oViewModel->setVariable("guilde", $aGuilde);
        $oViewModel->setVariable("id", $iId);
        return $oViewModel;
    }

    /**
     * Action pour la création.
     *
     * @return array
     */
    public function importUpdateAction() {
        $iId = (int) $this->params()->fromRoute('id', 0);
        try {
            $oEntite = $this->getTable()->findRow($iId);
            if (!$oEntite) {
                $this->flashMessenger()->addMessage($this->_getServTranslator()->translate("Identifiant de guildes inconnu."), 'error');
                return $this->redirect()->toRoute('backend-guildes-list');
            }
        } catch (Exception $ex) {
            $this->flashMessenger()->addMessage($this->_getServTranslator()->translate("Une erreur est survenue lors de la récupération de la guildes."), 'error');
            return $this->redirect()->toRoute('backend-guildes-list');
        }
        //if ($this->getRequest()->isXmlHttpRequest()) {
        $this->layout('layout/ajax');
        //}
        $oRequest = $this->getRequest();
        $aPost = $oRequest->getPost();
        $aOptGuilde = array(
            'nom' => $oEntite->getNom(),
            'serveur' => '', //TODO extrait les information dans la colonne Data
            'lvlMin' => '',
            'imp-membre' => 'Oui',
        );
        if ($oRequest->isPost()) {
            $guild = $this->_getServBnet()->warcraft(new Region(Region::EUROPE))->guilds();
            $guild->on($aPost['nomServeur']);
            $aOptionBnet = array();
            if ($aPost['imp-membre'] == "Oui") {
                $aOptionBnet[] = 'members';
            }
            $aGuildeBnet = $guild->find($aPost['nomGuilde'], $aOptionBnet);

            $aOptionFiltre = array();
            if (isset($aPost['lvlMin'])) {
                $aOptionFiltre = array('lvlMin' => $aPost['lvlMin']);
            }
            $aGuilde = \Jeux\Wow\Util\ParserWow::extraitGuildeDepuisBnetGuilde($aGuildeBnet, $oEntite->getIdJeux());
            $aOptGuilde['bnetData'] = $aGuilde->getData();
            if ($aPost['imp-membre'] == "Oui") {
                $aMembreGuilde = \Jeux\Wow\Util\ParserWow::extraitMembreDepuisBnetGuilde($aGuildeBnet, $oEntite, $aOptionFiltre);
            } else {
                $aMembreGuilde = array();
            }

            $this->layout('layout/ajax');
            //$adapter = new \Zend\ProgressBar\Adapter\JsPull();
            $adapter = new \Zend\ProgressBar\Adapter\JsPush();
            $adapter->setUpdateMethodName('progressImportPersonnage');
            $adapter->setFinishMethodName('progressImportPersonnageFin');
            $progressBar = new \Zend\ProgressBar\ProgressBar($adapter, 0, count($aMembreGuilde), 'importWow');
            $iCpt = 1;
            $tabPersonnage = /* new \Core\Table\PersonnagesTable(); */ $this->getServiceLocator()->get('\Core\Table\PersonnagesTable');
            foreach ($aMembreGuilde as $oPersonnage) {
                $tabPersonnage->insert($oPersonnage);
                $progressBar->update($iCpt, $oPersonnage->getNom());
                $iCpt++;
            }
            $progressBar->finish();
        }
        // Pour optimiser le rendu
        $oViewModel = new ViewModel();
        $oViewModel->setTemplate('wow/guilde/import-options');
        $oViewModel->setVariable("guilde", $aOptGuilde);
        $oViewModel->setVariable("id", $iId);
        return $oViewModel;
    }

}
