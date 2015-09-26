<?php

namespace Core\Service;

/**
 * Base commune a tous les plugins.
 *
 * @author Antarus
 * @project Murloc avenue
 *
 */
class JeuxService extends \Core\Service\AbstractService {

    /**
     *
     * @var \Core\Manager\Jeux\JeuxManager
     */
    protected $managerJeu;
    protected $canonicalNamesReplacements = array('-' => '', '_' => '', ' ' => '', '\\' => '', '/' => '');

    /**
     * stocke les healpers.
     * @var array
     */
    protected $viewHelpers;

    /**
     *
     * @var array
     */
    protected $listeJeux;

    /**
     * Code commenté pour enregsitrement en base mais pb de perf !
     *
     * @param \Zend\EventManager\EventInterface $e
     */
    public function bootstrapEnabledPlugins(\Zend\EventManager\EventInterface $e) {
        $oPluginManager = $this->getManagerJeux();
        $aPlugin = $oPluginManager->getCanonicalNames();
        foreach ($aPlugin as $sPlugin) {
            $oPluginManager->bootstrapPlugin($e, $sPlugin);
        }
    }

    /**
     * Rechercheles jeux installés.
     * @return array
     */
    public function getJeuxDisponible() {
        if (isset($this->listeJeux)) {
            return $this->listeJeux;
        }
        $aConfig = $this->getConfJeux();
        $aRetour = array();
        foreach ($aConfig['jeux_disponible'] as $sNom => $aConf) {
            $aJeu['Nom'] = $sNom;
            $aJeu['Installe'] = $aConf['Installe'];
            $aJeu['Actif'] = $aConf['Actif'];
            $aRetour[] = $aJeu;
        }
        $this->listeJeux = $aRetour;
        return $this->listeJeux;
    }

    public function getConfJeux() {
        $config = array();
        $aFichiersConf = array();
        $Contenu = \Core\Util\FileUtils::getDirContents(__DIR__ . '\..\..\..\..\..\jeux', 1);
        $aLstJeu = array();
        // par defaut chaque nouveau dossier est considéré comme un jeu non installé et inactif.
        foreach ($Contenu as $fichier => $type) {
            if ($type == 'rep') {
                $aLstJeu['jeux_disponible'][$fichier] = array(
                    'Installe' => false,
                    'Actif' => false);
            }
        }
        $aConfActuel = include __DIR__ . '\..\..\..\..\..\jeux\jeux.config.php';
        //fusionne les configuration existante et les potentiels nouveau jeu.
        return \Zend\Stdlib\ArrayUtils::merge($aLstJeu, $aConfActuel);
    }

    /**
     * Met a jour l'etat du plugin activé/désactivé passé en parametre.
     * @param string $sPlugin
     * @param boolean $bStatus
     * @return array
     */
    public function majActivationPlugin($sPlugin, $bStatus) {
        $aConfig = $this->getConfJeux();
        $aRetour = $aConfig;
        foreach ($aConfig['jeux_disponible'] as $sNom => $aConf) {
            if ($sNom !== $sPlugin) {
                continue;
            }
            $aRetour['jeux_disponible'][$sNom]['Actif'] = $bStatus;
            // si desactivation
            // l'activation ne peut etre gerer de la meme maniere car il n'est pas dans le pluginmanager.
            if (!$bStatus) {
                $oPluginManager = $this->getManagerJeux();
                $aPlugin = $oPluginManager->getCanonicalNames();
                foreach ($aPlugin as $sPlugin1 => $sPlugin2) {
                    if ('Jeux\\' . $sNom !== $sPlugin1) {
                        continue;
                    }
                    $oPlugin = $oPluginManager->get($sPlugin1);
                    $oPlugin->onDesActivation();
                }
            } else {
                $sChemin = __DIR__ . '\..\..\..\..\..\jeux\\' . $sPlugin . '\\' . $sPlugin;
                include $sChemin . '.php';
                $class = '\Jeux\\' . $sPlugin;
                $oJeux = new $class();
                $oJeux->onActivation();
            }
        }
        return $this->generateConfJeux($aRetour);
    }

    /**
     * Met a jour l'etat du plugin (installé/desinstallé passé en parametre.
     * @param string $sPlugin
     * @param boolean $bStatus
     * @return array
     */
    public function majInstallationPlugin($sPlugin, $bStatus) {
        $aConfig = $this->getConfJeux();
        $aRetour = $aConfig;
        foreach ($aConfig['jeux_disponible'] as $sNom => $aConf) {
            if ($sNom !== $sPlugin) {
                continue;
            }
            $aRetour['jeux_disponible'][$sNom]['Installe'] = $bStatus;
            // si desinstallation
            // l'installation ne peut etre gerer de la meme maniere car il n'est pas dans le pluginmanager.
            if (!$bStatus) {
                $oPluginManager = $this->getManagerJeux();
                $aPlugin = $oPluginManager->getCanonicalNames();
                foreach ($aPlugin as $sPlugin1 => $sPlugin2) {
                    if ('Jeux\\' . $sNom !== $sPlugin1) {
                        continue;
                    }
                    $oPlugin = $oPluginManager->get($sPlugin1);
                    $oPlugin->onDesinstallation();
                }
            } else {
                $sChemin = __DIR__ . '\..\..\..\..\..\jeux\\' . $sPlugin . '\\' . $sPlugin;
                include $sChemin . '.php';
                $class = '\Jeux\\' . $sPlugin;
                $oJeux = new $class();
                $oJeux->onInstallation();
            }
        }
        return $this->generateConfJeux($aRetour);
    }

    public function generateConfJeux(array $aConfig) {
        $oJeuxConfig = new \Zend\Code\Generator\FileGenerator();
        $oDocBlock = new \Zend\Code\Generator\DocBlockGenerator();
        $oDocBlock->setTag(new \Zend\Code\Generator\DocBlock\Tag\GenericTag('author', 'Murloc'));

        $oJeuxConfig->setDocBlock($oDocBlock);
        $oJeuxConfig->getDocBlock()->setShortDescription('Configuration des jeux.');
        $oJeuxConfig->setBody('return ' . var_export($aConfig, true) . ';');

        file_put_contents(__DIR__ . '\..\..\..\..\..\jeux\jeux.config.php', $oJeuxConfig->generate());
    }

    /**
     * Retourne le view helper associé au jeux.
     * @param type $sJeux
     * @return type
     */
    public function getViewHelper($sJeux) {
        if ($this->viewHelpers[$sJeux]) {
            return $this->viewHelpers[$sJeux];
        }
        $oPluginManager = $this->getManagerJeux();

        $sPluginCanon = $oPluginManager->getCanonicalNames();
        foreach ($sPluginCanon as $sPlugin) {
            $oPlugin = $oPluginManager->get($sPlugin);
            if ($oPlugin->isForMe($sJeux)) {
                $this->viewHelpers[$sJeux] = $oPlugin->getViewHelper();
                return $this->viewHelpers[$sJeux];
            }
        }
    }

    /**
     * retourne le gestionnaire de jeux.
     * @return \Core\Manager\Jeux\JeuxManager
     */
    public function getManagerJeux() {
        return $this->managerJeu;
    }

    /**
     * Definit le manager de jeux.
     * @param \Core\Manager\Jeux\JeuxManager $pluginManager
     */
    public function setManagerJeux(\Core\Manager\Jeux\JeuxManager $pluginManager) {
        $this->managerJeu = $pluginManager;
    }

}
