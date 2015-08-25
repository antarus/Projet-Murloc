<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Users\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Service\LogService;
use Zend\Session\Container;
use Zend\Validator;
use Zend\View\Model\JsonModel;

class IndexController extends AbstractActionController
{
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
        return  $this->_logService ?
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
    
    public function indexAction()
    {
        
        $sMessenger = $this->flashMessenger();
        $sMessenger->setNamespace('err');
        $sErrorMessage = $sMessenger->getMessages();
        $sMessenger->setNamespace('info');
        $sInfosMessage = $sMessenger->getMessages();   
                
        return new ViewModel(array('err' => $sErrorMessage,
                                    'info' => $sInfosMessage));
    }
    
     public function querypwdswapAction()
    {
        $forgetkey = $this->params('forgetKey');
        $sMessenger = $this->flashMessenger();
        $sMessenger->setNamespace('err');
        $sErrorMessage = $sMessenger->getMessages();
        $sMessenger->setNamespace('info');
        $sInfosMessage = $sMessenger->getMessages();   
        
        if(empty($forgetkey))
        {
            $this->_getLogService()->log(LogService::INFO, "Demande de changement de mot de passe refuser. forgetKey vide.", LogService::USER);
            $sErrorMessage[] = $this->_getServTranslator()->translate("Votre demande n'est plus valide, merci de la reformuler, ou de contacter Murloc Avenue.");
            return new ViewModel(array('err' => $sErrorMessage));
        }
        else
        {
            $users = $this->_getServUsers()->getByForgetKey($forgetkey);
            if(empty($users) && empty($sInfosMessage))
            {
                $this->_getLogService()->log(LogService::INFO, "Demande de changement de mot de passe refuser. forgetKey introuvable.", LogService::USER);
                $sErrorMessage[] = $this->_getServTranslator()->translate("L'url de la demande n'es pas correct, merci de la reformuler, ou de contacter Murloc Avenue.");
                return new ViewModel(array('err' => $sErrorMessage));
            }
            else
            {
                return new ViewModel(array('pseudo' => $users[0]['pseudo'],
                                            'forgetkey'=>$forgetkey,
                                            'err' => $sErrorMessage,
                                           'info' => $sInfosMessage));
            }
        }
    }
    
    public function changepasswordAction()
    {
        $aRequest = $this->getRequest();
        $aResult = $aRequest->getPost();
        
        $pass = $aResult['pwd'];
        $passConfirm = $aResult['pwdConfirm'];
        $forgetkey = $aResult['forgetkey'];
        
        if(empty($pass) || empty($passConfirm) || empty($forgetkey))
        {
            $this->flashMessenger()->setNamespace('err');
            $this->flashMessenger()->addMessage($this->_getServTranslator()
                        ->translate("Veuillez renseigner les deux champs mot de passe ."));  
        
            $this->_getLogService()->log(LogService::INFO, "Demande de changement de mot de passe refuser. champs vide.", LogService::USER);
        
        
            return $this->redirect()->toRoute('usager-swap-pwd',array('forgetKey'=>$forgetkey));
        }
        elseif( $pass !== $passConfirm)
        {
            $this->flashMessenger()->setNamespace('err');
            $this->flashMessenger()->addMessage($this->_getServTranslator()
                        ->translate("Veuillez renseigner les deux champs mot de passe de façon identique ."));  
        
            $this->_getLogService()->log(LogService::INFO, "Demande de changement de mot de passe refuser. champs non identique.", LogService::USER);
        
        
            return $this->redirect()->toRoute('usager-swap-pwd',array('forgetKey'=>$forgetkey));
        }
        else
        {
            if($this->_getServUsers()->setpwd(md5($pass),$forgetkey))
            {
                $this->_getServUsers()->resetforgetkey($forgetkey);
                $this->flashMessenger()->setNamespace('info');
                $this->flashMessenger()->addMessage($this->_getServTranslator()
                            ->translate("Changement de mot de passe effectué avec succes ."));  

                $this->_getLogService()->log(LogService::INFO, "Demande de changement de mot de passe effectuer.", LogService::USER);


                return $this->redirect()->toRoute('usager-swap-pwd',array('forgetKey'=>$forgetkey));
            }
            else
            {
                 $this->flashMessenger()->setNamespace('err');
                $this->flashMessenger()->addMessage($this->_getServTranslator()
                            ->translate("Une erreur interne est survenue ."));  

                $this->_getLogService()->log(LogService::INFO, "Demande de changement de mot de passe refuser. erreur bdd.", LogService::USER);


                return $this->redirect()->toRoute('usager-swap-pwd',array('forgetKey'=>$forgetkey));
            }
        }
    }
    public function forgetpwdAction()
    {
        
        $sMessenger = $this->flashMessenger();
        $sMessenger->setNamespace('err');
        $sErrorMessage = $sMessenger->getMessages();
        $sMessenger->setNamespace('info');
        $sInfosMessage = $sMessenger->getMessages();   
                
        return new ViewModel(array('err' => $sErrorMessage,
                                    'info' => $sInfosMessage));
    }
    
    public function pwdswapAction()
    {
        $aRequest = $this->getRequest();
        $aResult = $aRequest->getPost();
        $vMail = new Validator\EmailAddress;
        
        if(!isset($aResult['mail']) || empty($aResult['mail']))
        {
            
            $this->flashMessenger()->setNamespace('err');
            $this->flashMessenger()->addMessage($this->_getServTranslator()
                        ->translate("Veuillez renseigner votre adresse e-mail. ."));  
        
            $this->_getLogService()->log(LogService::INFO, "Demande de changement de mot de passe refuser. mail VIDE.", LogService::USER);
        
        
            return $this->redirect()->toRoute('users-forgekey');
        }
        else if(! $vMail->isValid($aResult['mail'])) 
        {
            $this->flashMessenger()->setNamespace('err');
            $this->flashMessenger()->addMessage($this->_getServTranslator()
                        ->translate("Adresse Email non valid ."));  
        
            $this->_getLogService()->log(LogService::INFO, "Demande de changement de mot de passe refuser. mail non valide. Mail: ".$aResult['mail'], LogService::USER);
        
        
            return $this->redirect()->toRoute('users-forgekey');
        }
        else
        {
            $aCompteSearch = $this->_getServUsers()->getByMail($aResult['mail']);
            if(! $aCompteSearch)
            {
                $this->flashMessenger()->setNamespace('err');
                $this->flashMessenger()->addMessage($this->_getServTranslator()
                            ->translate("Aucun compte n'est associé a ce compte mail."));  

                $this->_getLogService()->log(LogService::INFO, "Demande de changement de mot de passe refuser. aucun compte. Mail: ".$aResult['mail'], LogService::USER);


                return $this->redirect()->toRoute('users-forgekey');
            }
            else
            {
                $forgetKey = uniqid('',true);
                $this->_getServUsers()->setforgetKey($aCompteSearch[0]['idUsers'],$forgetKey);
                 return $this->redirect()->toRoute('contact',array('action'=>'swappwd',
                                                                   'recipient'=>$aResult['mail'],
                                                                   'pseudo' => $aCompteSearch[0]['pseudo'],
                                                                   'forgetkey'=>$forgetKey,
                                                                    ));
            }
        }
    }
    
}
