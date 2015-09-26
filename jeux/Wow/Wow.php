<?php

namespace Jeux;

use Zend\EventManager\EventInterface;
use Core\Plugin\PluginJeuxInterface;
use Core\Plugin\AbstractPlugin;

class Wow extends AbstractPlugin implements PluginJeuxInterface {

//    protected $classes = array();
//    protected $roles = array();
//    protected $races = array();
//    protected $factions = array();
    protected $config = array();

    public function getAuteur() {
        return 'Antarus';
    }

    public function getDescription() {
        return 'Implémentation du jeux World of Warcraft.';
    }

    public function getNomCourt() {
        return 'WoW';
    }

    public function getId() {
        return 1;
    }

    public function getNom() {
        return 'World Of Warcraft';
    }

    public function getVersion() {
        return '1.0';
    }

    public function getLogo() {
        return 'wow.jpg';
    }

    public function onBootstrap(EventInterface $e) {
        $this->config = include __DIR__ . '\config\wow.config.php';


        $sharedEm = $this->getServiceLocator()->get('EventManager')->getSharedManager();
        /**
         * @var \Zend\Mvc\Controller\ControllerManager
         */
        // $er=new \Zend\Mvc\Controller\ControllerManager();
        //   $er = $this->getServiceLocator()->get('controllerloader');
        //$er->setInvokableClass($name, $invokableClass)
        $sharedEm->attach('*', \Zend\View\ViewEvent::EVENT_RENDERER, array($this, 'preRender'), 100);
        $sharedEm->attach('*', 'guilde.pre.create', array($this, 'preCreateGuilde'), -10);
        $sharedEm->attach('*', 'guilde.pre.update', array($this, 'preUpdateGuilde'), -10);
//        $sharedEm->attach($this->eventId, 'remove.post', function($e) {
////            $cont = $e->getTarget();
////            $fm->addMessage('Item deleted');
//        });
    }

    /**
     * Avant le rendu de la page.
     * Ajoute les fichiers css propre au jeu.
     * TODO A déplacer dans le viewHelper
     * @param type $e
     */
    public function preRender($e) {
        $oCss = $this->getServiceLocator()->get('viewhelpermanager')->get('headLink');
        $oCss->prependStylesheet('/jeux/wow/css/classes.css');
        $oCss->prependStylesheet('/jeux/wow/css/races.css');
        $oCss->prependStylesheet('/jeux/wow/css/wow.css');
        $oJs = $this->getServiceLocator()->get('viewhelpermanager')->get('headScript');
        $oJs->prependFile('/jeux/wow/js/wow.js');
    }

    /**
     * Modifie le formulaire envoyé.
     * Ajout les element propre au jeux
     * @param type $e
     */
    public function preUpdateGuilde($e) {
//        $form = $e->getParam('form');
//        $cont = $e->getTarget();
//        //  $form = new \Core\Form\GuildesForm();
//        //$boutton = $form->get('submit');
//        $form->remove('submit');
//
//        //$form->add($boutton);
//        return $form;
    }

    /**
     * Modifie le formulaire envoyé.
     * Ajout les element propre au jeux
     * @param type $e
     */
    public function preCreateGuilde($e) {
//        $form = $e->getParam('form');
//        $cont = $e->getTarget();
//        //  $form = new \Core\Form\GuildesForm();
//        //$boutton = $form->get('submit');
//        $form->remove('submit');
//
//        //$form->add($boutton);
//        return $form;
    }

    public function onActivation() {

    }

    public function onDesActivation() {

    }

    public function onDesinstallation() {
        //supprime les donné ajouté a l'installation
        $oTableJeux = $this->getServiceLocator()->get('\Core\Table\JeuxTable');

        $oJeux = new \Core\Model\Jeux();
        $oJeux->setIdJeux($this->getId());
        $oJeux->setLogo($this->getLogo());
        $oJeux->setNom($this->getNom());
        $oTableJeux->delete($oJeux);
    }

    public function onInstallation() {
        // on ajoute le jeux en base.
        /**
         * @var \Core\Table\JeuxTable
         */
        $oTableJeux = $this->getServiceLocator()->get('\Core\Table\JeuxTable');

        $oJeux = new \Core\Model\Jeux();
        $oJeux->setIdJeux($this->getId());
        $oJeux->setLogo($this->getLogo());
        $oJeux->setNom($this->getNom());
        $oTableJeux->insert($oJeux);
    }

    public function getViewHelper() {
        return $this->getServiceLocator()->get('viewhelpermanager')->get('jeu_wow');
    }

    public function isForMe($sNomJeu) {
        return ($sNomJeu == $this->getId()) ? TRUE : FALSE;
    }

}
