<?php

/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Service\LogService;
use Zend\Session\Container;
use Zend\Validator;
use Zend\View\Model\JsonModel;

class IndexController extends AbstractActionController {

    private $_servTranslator;
    private $_oSessionUser;
    private $_logService;
    private $_servUsers;

    private function _getServTranslator() {
        if (!$this->_servTranslator) {
            $this->_servTranslator = $this->getServiceLocator()->get('translator');
        }
        return $this->_servTranslator;
    }

    private function _getSessionUser() {
        if (!$this->_oSessionUser)
            $this->_oSessionUser = new Container('users');
        return $this->_oSessionUser;
    }

    private function _getLogService() {
        return $this->_logService ?
                $this->_logService :
                $this->_logService = $this->getServiceLocator()->get('LogService');
    }

    /**
     * Lazzy-getter de service des logs de connections usagers
     * @return service Object
     */
    private function _getServUsers() {
        if (!$this->_servUsers) {
            $this->_servUsers = $this->getServiceLocator()->get('Users\Model\Users');
        }
        return $this->_servUsers;
    }

    public function indexAction() {

        $sMessenger = $this->flashMessenger();
        $sMessenger->setNamespace('err');
        $sErrorMessage = $sMessenger->getMessages();
        $sMessenger->setNamespace('info');
        $sInfosMessage = $sMessenger->getMessages();
        $this->layout()->setVariable('err', $sErrorMessage);
        $this->layout()->setVariable('info', $sInfosMessage);
        return new ViewModel();
    }

    public function loginAction() {
        $aRequest = $this->getRequest();
        $aResult = $aRequest->getPost();

        if (!isset($aResult['login']) || !isset($aResult['pwd'])) {

            $this->flashMessenger()->setNamespace('err');
            $this->flashMessenger()->addMessage($this->_getServTranslator()
                            ->translate("Connexion imposible ."));

            $this->_getLogService()->log(LogService::INFO, "connexion refusée, tentative de hack", LogService::USER);

            return $this->redirect()->toRoute('home');
        } else if (empty($aResult['login']) || empty($aResult['pwd'])) {
            $this->flashMessenger()->setNamespace('err');
            $this->flashMessenger()->addMessage($this->_getServTranslator()
                            ->translate("Veuillez renseigner les champs login et mot de passe ."));

            $this->_getLogService()->log(LogService::INFO, "connexion refusée ,champs vide", LogService::USER);


            return $this->redirect()->toRoute('home');
        } else {
            $aRLogin = $this->_getServUsers()->connect($aResult['login'], $aResult['pwd']);
            if (empty($aRLogin)) {
                $this->flashMessenger()->setNamespace('err');
                $this->flashMessenger()->addMessage($this->_getServTranslator()->translate("Connexion refusee. Verifiez votre login et mot de passe ."));

                $this->_getLogService()->log(LogService::INFO, "Connexion refusée. Vérifiez votre login et mot de passe. Login: {$aResult['login']} Mdp: {$aResult['pwd']} ", LogService::USER);

                return $this->redirect()->toRoute('home');
            } else {
                $oSession = $this->_getSessionUser();
                $oSession->offsetSet('users', $aRLogin);
                $this->_getLogService()->log(LogService::INFO, "Connexion ok", LogService::USER);
                return $this->redirect()->toRoute('home');
            }
        }
    }

    public function logoutAction() {

        $this->_getLogService()->log(LogService::INFO, "Déconnexion", LogService::USER);
        $oUserContainer = new Container('users');
        $oUserContainer->getManager()->getStorage()->clear();

        return $this->redirect()->toRoute('home');
    }

}
