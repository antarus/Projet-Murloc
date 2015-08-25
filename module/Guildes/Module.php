<?php

namespace Guildes;

use Guildes\Model\Guildes;
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
                'Guildes\Model\Guildes' => function($sm) {
                    $tableGateway = $sm->get('GuildesGateway');
                    $config = $sm->get('config');
                    $table = new Guildes($tableGateway, $config);
                    return $table;
                },
                'GuildesGateway' => function($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    return new TableGateway('guildes', $dbAdapter);
                },
            )
        );
    }

}
