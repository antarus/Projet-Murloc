<?php

namespace Core\Manager\Theme;

use Zend\Stdlib\PriorityQueue;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Gestionnaire de thème.
 *
 * @author Antarus
 * @project Murloc avenue
 *
 */
class ThemeManager {

    /**
     * @var null|\Zend\Stdlib\PriorityQueue
     */
    protected $CheminTheme = null;

    /**
     * @var null|string
     */
    protected $themeCourrant = null;

    /**
     *
     * @var array
     */
    protected $themeConfig = array();

    /**
     * @var null|\Core\Manager\Theme\Source\SourceInterface
     */
    protected $derniereSource = null;

    /**
     * @var null|\Zend\Stdlib\PriorityQueue
     */
    protected $sources = null;

    /**
     * @var \Zend\ServiceManager\ServiceLocatorInterface
     */
    protected $serviceLocator;

    /**
     * Constructeur.
     * @param ServiceLocatorInterface $serviceLocator
     * @param array $aOptions
     */
    public function __construct(ServiceLocatorInterface $serviceLocator, $aOptions = array()) {
        $this->serviceLocator = $serviceLocator;

        // Définit les chemins des theme (LIFO dernier arrivé, premier parti)
        $this->CheminTheme = new PriorityQueue();
        if (isset($aOptions['chemin_themes'])) {
            $iPriorite = 1;
            foreach ($aOptions['chemin_themes'] as $sChemin) {
                $this->CheminTheme->insert($sChemin, $iPriorite++);
            }
        }

        //éfinit les adapteur (LIFO dernier arrivé, premier parti)
        $this->sources = new PriorityQueue();
        if (isset($aOptions['sources'])) {
            $iPriorite = 1;
            foreach ($aOptions['sources'] as $sSourcerClass) {
                $oSource = new $sSourcerClass($serviceLocator);
                $this->sources->insert($oSource, $iPriorite++);
            }
        }
    }

    /**
     * Initialise ke thème en selectionnant un theme via les adapteurs.
     */
    public function init() {
        // Deja initialisé on sort.
        if ($this->themeCourrant) {
            return true;
        }

        // permet de changer le layout selon le module actuel.
        $this->serviceLocator->get('EventManager')->getSharedManager()->attach('Zend\Mvc\Controller\AbstractController', 'dispatch', function($e) {
            $controller = $e->getTarget();
            $controllerClass = get_class($controller);
            $moduleNamespace = substr($controllerClass, 0, strpos($controllerClass, '\\'));
            //$config = $e->getApplication()->getServiceManager()->get('config');
            $aConfig = $this->getThemeConfig($this->themeCourrant);
            if (isset($aConfig['module_layouts'][$moduleNamespace])) {
                $controller->layout($aConfig['module_layouts'][$moduleNamespace]);
            }
        }, 100);


        // Cherche le thème courrant qui devrait $etre utilisé.
        $sTheme = $this->selectThemeCourrant();
        if (!$sTheme) {
            return false;
        }

        // Retourne la configuration du thème.
        $aConfig = $this->getThemeConfig($sTheme);
        if (!$aConfig) {
            return false;
        }

        $oViewResolver = $this->serviceLocator->get('ViewResolver');
        $oResolverTheme = new \Zend\View\Resolver\AggregateResolver();
        if (isset($aConfig['template_map'])) {
            $oTempLateMapResolv = $this->serviceLocator->get('ViewTemplateMapResolver');
            $oTempLateMapResolv->add($aConfig['template_map']);
            $oMapResolver = new \Zend\View\Resolver\TemplateMapResolver($aConfig['template_map']);
            $oResolverTheme->attach($oMapResolver);
        }

        if (isset($aConfig['template_path_stack'])) {
            $oPathStackResolv = $this->serviceLocator->get('ViewTemplatePathStack');
            $oPathStackResolv->addPaths($aConfig['template_path_stack']);
            $oPathResolv = new \Zend\View\Resolver\TemplatePathStack(array('script_paths' => $aConfig['template_path_stack']));
            $oPathStackDefaut = $this->serviceLocator->get('ViewTemplatePathStack');
            $oPathResolv->setDefaultSuffix($oPathStackDefaut->getDefaultSuffix());
            $oResolverTheme->attach($oPathResolv);
        }

        $oViewResolver->attach($oResolverTheme, 100);



        return true;
    }

    /**
     * Retourne le theme courant.Si le manager n'a pas été initialisé ou le thrme n'a pas trouvé retourne null.
     * @return string | null
     */
    public function getTheme() {
        return $this->themeCourrant;
    }

    /**
     * Definit le nom du theme utilisé par la derniere source.
     * @param string $sTheme
     * @return bool
     */
    public function setTheme($sTheme) {
        if (!$this->derniereSource) {
            return false;
        }

        $sTheme = $this->nettoyerNomTheme($sTheme);
        return $this->derniereSource->setTheme($sTheme);
    }

    /**
     * Retourne la configuration d'un theme.
     * @param string $sTheme
     * @return array | null
     */
    public function getThemeConfig($sTheme) {
        if (!isset($this->themeConfig[$sTheme])) {
            $sTheme = $this->nettoyerNomTheme($sTheme);
            $oIterateurChemin = $this->CheminTheme->getIterator();
            $config = null;
            $n = $oIterateurChemin->count();
            while (!$config && $n-- > 0) {

                $path = $oIterateurChemin->extract();
                $appConfig = $this->serviceLocator->get('Configuration');

                if ($appConfig['manager_theme']['remplaceChemin'] === true) {
                    $configFile = str_replace('{theme}', $sTheme, $path) . '/config.php';
                } else
                    $configFile = $path . $sTheme . '/config.php';

                if (file_exists($configFile)) {
                    $config = include ($configFile);
                }
            }
            if (isset($appConfig['view_jeux'])) {
                foreach ($appConfig['view_jeux'] as $jeux) {
                    $config = \Zend\Stdlib\ArrayUtils::merge($config, $jeux);
                }
            }
            $this->themeConfig[$sTheme] = $config;
        }



        return $this->themeConfig[$sTheme];
    }

    /**
     * Supprime les caractères non désirés du nom de theme.
     * @param string $sTheme
     * @return string
     */
    protected function nettoyerNomTheme($sTheme) {
        $sTheme = str_replace('.', '', $sTheme);
        return str_replace('/', '', $sTheme);
    }

    /**
     * Appel chaque source pour selectionner un theme jusqu'a ce qu'un retourne un nom valide.
     * @return string | null
     */
    protected function selectThemeCourrant() {
        $oIterateur = $this->sources;
        $sTheme = null;
        $oSource = null;
        $iNb = $oIterateur->count();
        while (!$sTheme && $iNb-- > 0) {
            $oSource = $oIterateur->extract();
            $sTheme = $oSource->getTheme();
        }

        if (!$sTheme) {
            return null;
        }
        $this->derniereSource = $oSource;
        $this->themeCourrant = $sTheme;
        return $sTheme;
    }

}
