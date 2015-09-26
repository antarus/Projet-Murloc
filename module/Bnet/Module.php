<?php

namespace Bnet;

class Module {

    public function getConfig() {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig() {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
        );
    }

    public function getServiceConfig() {
        return array(
            'factories' => array(
                'Bnet\ClientFactory' => function($sm) {
                    $config = $sm->get('config');
                    $cache = $sm->get('Zend\Cache\Storage\Filesystem');
                    return new ClientFactory($config['battlenet']['apikey'], $cache);
                },
            )
        );
    }

}
