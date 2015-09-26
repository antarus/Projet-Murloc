<?php

namespace Jeux\View\Helper;

use Zend\View\Helper\AbstractHelper;

/**
 * Classe faisant le lien entre les different helper de jeux possible.
 */
class JeuxHelper extends AbstractHelper {

    private $serviceLocator;
    private $viewHelper;

    function __construct(\Zend\ServiceManager\ServiceLocatorInterface $oServiceLocator) {
        $this->serviceLocator = $oServiceLocator;
    }

    protected $count = 0;

    public function __invoke($sJeux) {
        $e = $this->serviceLocator->get('Core\Service\JeuxService');
        $this->viewHelper = $e->getViewHelper($sJeux);
        return $this; //$this->viewHelper;
    }

    /**
     * Proxy le helper du plugin jeux.
     *
     * @param  string $method
     * @param  array  $argv
     * @return mixed
     */
    public function __call($method, $argv) {
        if (!$this->viewHelper) {
            return null;
        }
        return call_user_func_array(array($this->viewHelper, $method), $argv);
    }

}
