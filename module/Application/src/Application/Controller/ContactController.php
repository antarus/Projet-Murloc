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
use Zend\View\Model\JsonModel;
use Zend\Mail;

class ContactController extends AbstractActionController
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
            $this->_servUsers = $this->getServiceLocator()->get('Application\Model\Users');
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
   
    public function swappwdAction()
    {
        
        $config = $this->getServiceLocator()->get('Config');
        
        
        $contactUrl = 'http://'.$config['urlProjet'].$this->url()->fromRoute('contact');
        $swapUrl = 'http://'.$config['urlProjet'].$this->url()->fromRoute('usager-swap-pwd',array('forgetKey'=>$this->params('forgetkey')));
        $message = $this->_getServTranslator()->translate(
                sprintf('<html><body>'
                      .  'Bonjour %s,<br/><br/>'
                      . " cliquer <a href='%s'>ici</a> pour initialiser un nouveau mot-de-passe !<br/>"
                      . "Si vous rencontrez le moindre soucis pour la récupération de votre mot-de-passe, "
                      . "n'hésitez pas a contacter un membre du Staff en utilisant le formulaire de "
                      . "contact disponible <a href='%s'>ici</a> <br/><br/>"
                      . 'A bientôt !'
                      . '</body></html>',$this->params('forgetKey'),$swapUrl,$contactUrl)
        );
        
        $bodyPart = new \Zend\Mime\Message();
        $bodyMessage = new \Zend\Mime\Part($message);
        $bodyMessage->type = 'text/html';

        $bodyPart->setParts(array($bodyMessage));
        
        $mail = new Mail\Message();
        $mail->setBody($bodyPart);
        $mail->setEncoding('UTF-8');
        $mail->setFrom('contact@murloc-avenue.fr', 'Murloc-Avenue');
        $mail->addTo($this->params('recipient'), $this->params('pseudo'));
        $mail->setSubject('Récupération de votre mot-de-passe');
        
        $headers = $mail->getHeaders();
        $headers->removeHeader('Content-Type');
        $headers->addHeaderLine('Content-Type', 'text/html; charset=UTF-8');
        
        $transport = new Mail\Transport\Sendmail();
        $transport->send($mail);        
        
        $this->flashMessenger()->setNamespace('info');
        $this->flashMessenger()->addMessage($this->_getServTranslator()
                    ->translate("Email envoyer."));  

        $this->_getLogService()->log(LogService::INFO, "Demande de changement de mot de passe accepter, email envoyer: ".$this->params('recipient'), LogService::USER);


        return $this->redirect()->toRoute('users-forgekey');
    }
    
}
