<?php

namespace Core\Plugin;

use Zend\EventManager\EventInterface;

/**
 * Base commune a tous les plugins.
 *
 * @author Antarus
 * @project Murloc avenue
 *
 */
interface PluginInterface {

    public function onBootstrap(EventInterface $oEventI);

    public function getNom();

    public function getVersion();

    public function getAuteur();

    public function getDescription();

    public function getNomCourt();
}
