<?php

namespace Jeux\Wow\Controller;

use Zend\View\Model\ViewModel;

/**
 * TEst surcharge controller original depuis jeu.
 * Pose des pb avec le rendu layout, le nom du controller changeant...
 *
 * @author Antarus
 * @project Murloc avenue
 */
class GuildesController extends \Backend\Controller\GuildesController {

    /**
     * Action pour la création.
     *
     * @return array
     */
    public function createAction() {
        $oForm = new \Core\Form\GuildesForm($this->getServiceLocator());
        $oRequest = $this->getRequest();

        $oFiltre = new \Core\Filter\GuildesFilter();
        $oForm->setInputFilter($oFiltre->getInputFilter());

        if ($oRequest->isPost()) {
            $oEntite = new \Core\Model\Guildes();

            $oForm->setData($oRequest->getPost());

            if ($oForm->isValid()) {
                $oEntite->exchangeArray($oForm->getData());
                $this->getTable()->insert($oEntite);
                $this->flashMessenger()->addMessage($this->_getServTranslator()->translate("La guildes a été créé avec succès."), 'success');
                return $this->redirect()->toRoute('backend-guildes-list');
            }
        }
        // Pour optimiser le rendu
        $oViewModel = new ViewModel();
        $oViewModel->setTemplate('backend/guildes/create');

        return $oViewModel->setVariables(array('form' => $oForm));
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

        $oFiltre = new \Core\Filter\GuildesFilter();
        $oEntite->setInputFilter($oFiltre->getInputFilter());
        $oForm->bind($oEntite);


        $aParamEvent = array(
            'form' => $oForm,
            'viewModel' => $oViewModel,
        );


        $oRequest = $this->getRequest();
        if ($oRequest->isPost()) {
            $oForm->setInputFilter($oFiltre->getInputFilter());
            $oForm->setData($oRequest->getPost());

            if ($oForm->isValid()) {
                $this->getTable()->update($oEntite);
                $this->flashMessenger()->addMessage($this->_getServTranslator()->translate("La guildes a été modifié avec succès."), 'success');
                return $this->redirect()->toRoute('backend-guildes-list');
            }
        }

        $ret = $this->getEventManager()->trigger('jeux.pre.update', $this, $aParamEvent);

        // Pour optimiser le rendu

        $oViewModel->setTemplate('backend/guildes/update');
        return $oViewModel->setVariables(array('id' => $id, 'form' => $oForm));
    }

}
