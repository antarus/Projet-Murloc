<?php

namespace Jeux;

use Jeux\Model\Jeux;
use Zend\Db\TableGateway\TableGateway;

class Module {

    public function getConfig() {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig() {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getServiceConfig() {
        return array(
            'factories' => array(
                'Jeux\Model\Jeux' => function($sm) {
                    $tableGateway = $sm->get('JeuxGateway');
                    $config = $sm->get('config');
                    $table = new Jeux($tableGateway, $config);
                    return $table;
                },
                'JeuxGateway' => function($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    return new TableGateway('jeux', $dbAdapter);
                },
            )
        );
    }

}
