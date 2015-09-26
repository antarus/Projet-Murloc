<?php

return array(
    'manager_jeux' => array(
        'invokables' => array(
            'Jeux\Wow' => 'Jeux\Wow',
        ),
    ),
    'view_helpers' => array(
        'factories' => array(
            'jeu_wow' => function($sm) {
                $helper = new \Jeux\Wow\View\Helper\WowHelper();
                return $helper;
            }
        )
    ),
    'view_jeux' => array(
        'jeu_wow' => array(
            'template_path_stack' => array(
                'wow' => __DIR__ . '/../view',
            ),
            'template_map' => include '/../template_map.php',
        )
    ),
    'router' =>
    array(
        'routes' =>
        array(
            'wow-import-guilde' =>
            array(
                'type' => 'segment',
                'options' =>
                array(
                    'route' => '/wow/import/guilde/[:id]',
                    'constraints' =>
                    array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]+',
                        'id' => '[0-9]+',
                    ),
                    'defaults' =>
                    array(
                        'controller' => 'Jeux\Wow\Controller\WowGuildeController',
                        'action' => 'afficheImportUpdate',
                    ),
                ),
            ),
            'wow-import-guilde-traitement' =>
            array(
                'type' => 'segment',
                'options' =>
                array(
                    'route' => '/wow/import/guilde/traitement[:id]',
                    'constraints' =>
                    array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]+',
                        'id' => '[0-9]+',
                    ),
                    'defaults' =>
                    array(
                        'controller' => 'Jeux\Wow\Controller\WowGuildeController',
                        'action' => 'importUpdate',
                    ),
                ),
            ),
        )
    ),
    // TODO Test surcharge.
    // Pose des pb avec le rendu layout, le nom du controller changeant...
    // de plus ce choix de surcharge implique une gestion de jeux unique pour le site
    // donc dependra des choix finaux.
    'controllers' => array(
        'invokables' => array(
            //test surcharge les controller a utiliser
            //'Backend\Controller\Guildes' => 'Jeux\Wow\Controller\GuildesController',
            'Jeux\Wow\Controller\WowGuildeController' => 'Jeux\Wow\Controller\WowGuildeController'
        ))
);
