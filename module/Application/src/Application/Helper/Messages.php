<?php

/**
 * Helper permettant d'ajouter la possibilité d'affiché les messages courants et destinés a la prochaine requête.
 *
 * @author Antarus
 */

namespace Application\Helper;

use Zend\Mvc\Controller\Plugin\FlashMessenger as PluginFlashMessenger;
use Zend\View\Helper\FlashMessenger as ZendFlash;

/**
 * Helper to proxy the plugin flash messenger
 */
class Messages extends ZendFlash {

    /**
     * Affiche tous les messages qu'il soit de la requête courante ou destiné a la prochaine.
     *
     * @param string    $namespace
     * @param array     $messages
     * @param array     $classes
     * @param bool|null $autoEscape
     * @return string
     */
    public function renderAllMessages($namespace = PluginFlashMessenger::NAMESPACE_DEFAULT, array $messages = array(), array $classes = array(), $autoEscape = null) {
        return $this->renderMessages($namespace, $messages, $classes, $autoEscape);
    }

}
