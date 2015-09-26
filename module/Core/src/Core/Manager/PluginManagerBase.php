<?php

namespace Core\Manager;

use Zend\ServiceManager\AbstractPluginManager;

/**
 * Base commune a tous les managers.
 *
 * @author Antarus
 * @project Murloc avenue
 *
 */
class PluginManagerBase extends AbstractPluginManager {

    protected $plugins;

    public function bootstrapPlugin($e, $sPluginName) {
        $sPluginName = $this->canonicalizeName($sPluginName);

        $oPlugin = $this->get($sPluginName);
        $oPlugin->setServiceLocator($this->getServiceLocator());
        $oPlugin->onBootstrap($e);
        $this->plugins[$sPluginName] = $oPlugin;
    }

    public function validatePlugin($oPlugin) {
        if (!$oPlugin instanceof PluginInterface) {
            throw new \Exception("Le plugin ajouté n'est géré par ce manager.");
        }
    }

    /**
     * Retourne les plugins gérés.
     * @return array
     */
    function getBootstrappedPlugins() {
        return $this->plugins;
    }

}
