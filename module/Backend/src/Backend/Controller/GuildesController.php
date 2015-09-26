<?php

namespace Backend\Controller;

use Zend\View\Model\ViewModel;

/**
 * Controller pour la vue.
 *
 * @author Antarus
 * @project Murloc avenue
 */
class GuildesController extends \Zend\Mvc\Controller\AbstractActionController {

    public $_servTranslator = null;
    public $_table = null;
    public $_tableJeux = null;

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
     * Returne une instance de la table en lazy.
     *
     * @return \Core\Table\JeuxTable
     */
    public function getTableJeux() {
        if (!$this->_tableJeux) {
            $this->_tableJeux = $this->getServiceLocator()->get('\Core\Table\JeuxTable');
        }
        return $this->_tableJeux;
    }

    /**
     * Retourne l'ecran de liste.
     * Affiche uniquement la page. Les données sont chargées via ajax plus tard.
     *
     * @return le template de la page liste.
     */
    public function listAction() {
        // Pour optimiser le rendu
        $oViewModel = new ViewModel();
        $oViewModel->setTemplate('backend/guildes/list');
        $aParamEvent = array(
            'viewModel' => $oViewModel,
        );
        $this->getEventManager()->trigger('guilde.pre.render.list', $this, $aParamEvent);
        return $oViewModel;
    }

    /**
     * Action pour le listing via AJAX.
     *
     * @return reponse au format Ztable
     */
    public function ajaxListAction() {
        $oTable = new \Core\Grid\GuildesGrid($this->getServiceLocator(), $this->getPluginManager());
        $aParamEvent = array(
            'table' => $oTable,
        );
        $this->getEventManager()->trigger('guilde.pre.ajaxlist', $this, $aParamEvent);
        $oTable->setAdapter($this->getAdapter())
                ->setSource($this->getTable()->getSelectListeJointe())
                ->setParamAdapter($this->getRequest()->getPost());
        $this->getEventManager()->trigger('guilde.post.ajaxlist', $this, $aParamEvent);
        return $this->htmlResponse($oTable->render());
    }

    /**
     * Action pour le listing via AJAX.
     *
     * @return reponse au format Ztable
     */
    public function selectJeuAction() {
        $sAct = $this->params()->fromRoute('act', '');
        $oRequest = $this->getRequest();
        if ($oRequest->isPost()) {
//            $value = $oRequest->getPost('changedValue');
            // your logic here....
            return $this->redirect()->toRoute('backend-guildes-' . $sAct, array('curJeu' => $oRequest->getPost('jeux')));
//            $date = date('Y-m-d'); // get the current date
//            $data = new \Zend\View\Model\JsonModel(array(
//                'currentdate' => $date,
//            ));
//            return $data;
        }
        $oViewModel = new ViewModel();
        $oViewModel->setTemplate('backend/guildes/select-jeu');
        $oViewModel->setVariable('act', $sAct);
        $aJeux = array();
        $aJeux[] = array("idJeux" => '0', "nom" => $this->getServiceLocator()->get('translator')->translate('---Veuillez choisir ---'));
        $aJeux = array_merge($aJeux, $this->getTableJeux()->fetchAll()->toArray());

        $oViewModel->setVariable('jeux', $aJeux);
        return $oViewModel;
    }

    /**
     * Action pour la création.
     *
     * @return array
     */
    public function createAction() {
        //jeux courant from selectJeux
        $sCurJeu = $this->params()->fromRoute('curJeu', '0');
        if ($sCurJeu == 0) {
            throw new \Exception('jeu courant non définit');
        }
        $oForm = new \Core\Form\GuildesForm($this->getServiceLocator());
        $oRequest = $this->getRequest();

        $oFiltre = new \Core\Filter\GuildesFilter();
        $oForm->setInputFilter($oFiltre->getInputFilter());


        $oEntite = new \Core\Model\Guildes();
        $oEntite->setIdJeux($sCurJeu);
        $oFiltre = new \Core\Filter\GuildesFilter();
        $oEntite->setInputFilter($oFiltre->getInputFilter());
        $oForm->bind($oEntite);



        $oViewModel = new ViewModel();
        $oViewModel->setTemplate('backend/guildes/create');
        $aParamEvent = array(
            'curJeu' => $sCurJeu,
            'form' => $oForm,
            'viewModel' => $oViewModel,
        );

        $this->getEventManager()->trigger('guilde.pre.create', $this, $aParamEvent);

        if ($oRequest->isPost()) {
            //$oEntite = new \Core\Model\Guildes();

            $oForm->setData($oRequest->getPost());

            if ($oForm->isValid()) {
                $oEntite = $oForm->getData();
                $aParamEvent[] = array('entite' => $oEntite);
                $this->getEventManager()->trigger('guilde.pre.create.valid', $this, $aParamEvent);
                // $oEntite->exchangeArray($oForm->getData());

                $this->getTable()->insert($oEntite);
                $this->getEventManager()->trigger('guilde.post.create.valid', $this, $aParamEvent);
                $this->flashMessenger()->addMessage($this->_getServTranslator()->translate("La guildes a été créé avec succès."), 'success');
                return $this->redirect()->toRoute('backend-guildes-list');
            }
        }

        $this->getEventManager()->trigger('guilde.pre.render.create', $this, $aParamEvent);

        return $oViewModel->setVariables(array('form' => $oForm, 'curJeu' => $sCurJeu));

//        $oForm = new \Core\Form\GuildesForm($this->getServiceLocator());
//        $oRequest = $this->getRequest();
//
//        $oFiltre = new \Core\Filter\GuildesFilter();
//        $oForm->setInputFilter($oFiltre->getInputFilter());
//
//        $oViewModel = new ViewModel();
//        $oViewModel->setTemplate('backend/guildes/create');
//        $aParamEvent = array(
//            'form' => $oForm,
//            'viewModel' => $oViewModel,
//        );
//        $this->getEventManager()->trigger('guilde.pre.create', $this, $aParamEvent);
//
//        if ($oRequest->isPost()) {
//            $oEntite = new \Core\Model\Guildes();
//
//            $oForm->setData($oRequest->getPost());
//
//            if ($oForm->isValid()) {
//                $this->getEventManager()->trigger('guilde.pre.create.valid', $this, $aParamEvent);
//                $oEntite->exchangeArray($oForm->getData());
//                $this->getTable()->insert($oEntite);
//                $this->getEventManager()->trigger('guilde.post.create.valid', $this, $aParamEvent);
//                $this->flashMessenger()->addMessage($this->_getServTranslator()->translate("La guildes a été créé avec succès."), 'success');
//                return $this->redirect()->toRoute('backend-guildes-list');
//            }
//        }
//
//        $this->getEventManager()->trigger('guilde.pre.render.create', $this, $aParamEvent);
//
//
//
//        return $oViewModel->setVariables(array('form' => $oForm));
    }

    /**
     * Action pour la mise à jour.
     *
     * @return array
     */
    public function updateAction() {
        $id = (int) $this->params()->fromRoute('id', 0);
        try {
            $oEntite = $this->getTable()->findRow($id);
            if (!$oEntite) {
                $this->flashMessenger()->addMessage($this->_getServTranslator()->translate("Identifiant de guildes inconnu."), 'error');
                return $this->redirect()->toRoute('backend-guildes-list');
            }
        } catch (Exception $ex) {
            $this->flashMessenger()->addMessage($this->_getServTranslator()->translate("Une erreur est survenue lors de la récupération de la guildes."), 'error');
            return $this->redirect()->toRoute('backend-guildes-list');
        }
        $oForm = new \Core\Form\GuildesForm($this->getServiceLocator()); //new \Core\Form\GuildesForm($this->getServiceLocator());
        $oViewModel = new ViewModel();
        $oViewModel->setTemplate('backend/guildes/update');
        $oFiltre = new \Core\Filter\GuildesFilter();
        $oEntite->setInputFilter($oFiltre->getInputFilter());
        $oForm->bind($oEntite);


        $aParamEvent = array(
            'curJeu' => $oEntite->getIdJeux(),
            'form' => $oForm,
            'viewModel' => $oViewModel,
        );
        $this->getEventManager()->trigger('guilde.pre.update', $this, $aParamEvent);

        $oRequest = $this->getRequest();
        if ($oRequest->isPost()) {
            $oForm->setInputFilter($oFiltre->getInputFilter());
            $aData = $oRequest->getPost();
            $aData['idJeux'] = $oEntite->getIdJeux();
            $oForm->setData($aData);

            if ($oForm->isValid()) {
                $this->getEventManager()->trigger('guilde.pre.update.valid', $this, $aParamEvent);
                $this->getTable()->update($oEntite);
                $this->getEventManager()->trigger('guilde.post.update.valid', $this, $aParamEvent);
                $this->flashMessenger()->addMessage($this->_getServTranslator()->translate("La guildes a été modifié avec succès."), 'success');
                return $this->redirect()->toRoute('backend-guildes-list');
            }
        }

        $this->getEventManager()->trigger('guilde.pre.render.update', $this, $aParamEvent);

        // Pour optimiser le rendu


        return $oViewModel->setVariables(array('id' => $id, 'form' => $oForm, 'curJeu' => $oEntite->getIdJeux()));
    }

    /**
     * Action pour la suppression.
     *
     * @return redirection vers la liste
     */
    public function deleteAction() {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('backend-guildes-list');
        }
        $oTable = $this->getTable();
        $oEntite = $oTable->findRow($id);
        $aParamEvent = array(
            'entite' => $oEntite,
        );
        $this->getEventManager()->trigger('guilde.pre.delete', $this, $aParamEvent);
        $oTable->delete($oEntite);
        $this->getEventManager()->trigger('guilde.post.delete', $this, $aParamEvent);
        $this->flashMessenger()->addMessage($this->_getServTranslator()->translate("La guildes a été supprimé avec succès."), 'success');

        $this->getEventManager()->trigger('guilde.pre.render.update', $this, $aParamEvent);

        return $this->redirect()->toRoute('backend-guildes-list');
    }

    /**
     * Retourne l'adapter associé a ce modèle.
     *
     * @return \Zend\Db\Adapter\Adapter
     */
    public function getAdapter() {
        return $this->getServiceLocator()->get('\Zend\Db\Adapter\Adapter');
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

}
