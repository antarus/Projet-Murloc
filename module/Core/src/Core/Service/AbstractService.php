<?php

namespace Core\Service;

use Zend\ServiceManager\ServiceLocatorAwareInterface,
    Zend\ServiceManager\ServiceLocatorInterface,
    Zend\EventManager\EventManagerAwareInterface,
    Zend\EventManager\EventManagerInterface;

/**
 * Base commune a tous les services.
 *
 * @author Antarus
 * @project Murloc avenue
 *
 */
abstract class AbstractService implements ServiceLocatorAwareInterface, EventManagerAwareInterface {

    /**
     * @var EventManagerInterface
     */
    protected $eventManager;

    /**
     * @var ServiceLocatorInterface
     */
    protected $locator;

    public function setServiceLocator(ServiceLocatorInterface $oLocator) {
        $this->locator = $oLocator;
    }

    public function getServiceLocator() {
        return $this->locator;
    }

    /**
     * Définit l'event manager .
     *
     * @param  EventManagerInterface $oEvents
     * @return mixed
     */
    public function setEventManager(EventManagerInterface $oEvents) {
        $oEvents->setIdentifiers(array(__CLASS__, get_called_class()));
        $this->eventManager = $oEvents;
        $this->attachDefaultListeners();
        return $this;
    }

    /**
     * Retourne l' event manager.
     *
     * @return EventManagerInterface
     */
    public function getEventManager() {
        return $this->eventManager;
    }

    protected function triggerEvent($event, $argv = array(), $callback = null) {
        return $this->getEventManager()->trigger($event, $this, $argv, $callback);
    }

    protected function attachDefaultListeners() {

    }

}
