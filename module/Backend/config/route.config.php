<?php

return array(
    'router' =>
    array(
        'routes' =>
        array(
            'backend-index' =>
            array(
                'type' => 'segment',
                'options' =>
                array(
                    'route' => '/backend/',
                    'constraints' =>
                    array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]+',
                    ),
                    'defaults' =>
                    array(
                        'controller' => 'Backend\\Controller\\Index',
                        'action' => 'index',
                    ),
                ),
            ),
            'backend-guildes-list' =>
            array(
                'type' => 'segment',
                'options' =>
                array(
                    'route' => '/backend/guildes/list',
                    'constraints' =>
                    array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]+',
                    ),
                    'defaults' =>
                    array(
                        'controller' => 'Backend\\Controller\\Guildes',
                        'action' => 'list',
                    ),
                ),
            ),
            'backend-guildes-ajaxList' =>
            array(
                'type' => 'segment',
                'options' =>
                array(
                    'route' => '/backend/guildes/ajaxList',
                    'constraints' =>
                    array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]+',
                    ),
                    'defaults' =>
                    array(
                        'controller' => 'Backend\\Controller\\Guildes',
                        'action' => 'ajaxList',
                    ),
                ),
            ),
            'backend-guildes-create' =>
            array(
                'type' => 'segment',
                'options' =>
                array(
                    'route' => '/backend/guildes/create[/:curJeu]',
                    'constraints' =>
                    array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]+',
                        'curJeu' => '[0-9_-]+',
                    ),
                    'defaults' =>
                    array(
                        'controller' => 'Backend\\Controller\\Guildes',
                        'action' => 'create',
                    ),
                ),
            ),
            'backend-guildes-update' =>
            array(
                'type' => 'segment',
                'options' =>
                array(
                    'route' => '/backend/guildes/update[/:curJeu]/[:id]',
                    'constraints' =>
                    array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]+',
                        'id' => '[0-9]+',
                        'curJeu' => '[0-9_-]+',
                    ),
                    'defaults' =>
                    array(
                        'controller' => 'Backend\\Controller\\Guildes',
                        'action' => 'update',
                    ),
                ),
            ),
            'backend-guildes-select-jeu' =>
            array(
                'type' => 'segment',
                'options' =>
                array(
                    'route' => '/backend/guildes/select/jeux/:act',
                    'constraints' =>
                    array(
                        'act' => '[a-zA-Z][a-zA-Z]+',
                        'id' => '[0-9]+',
                    ),
                    'defaults' =>
                    array(
                        'controller' => 'Backend\\Controller\\Guildes',
                        'action' => 'selectJeu',
                    ),
                ),
            ),
            'backend-guildes-delete' =>
            array(
                'type' => 'segment',
                'options' =>
                array(
                    'route' => '/backend/guildes/delete/[:id]',
                    'constraints' =>
                    array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]+',
                        'id' => '[0-9]+',
                    ),
                    'defaults' =>
                    array(
                        'controller' => 'Backend\\Controller\\Guildes',
                        'action' => 'delete',
                    ),
                ),
            ),
            'backend-jeux-list' =>
            array(
                'type' => 'segment',
                'options' =>
                array(
                    'route' => '/backend/jeux/list',
                    'constraints' =>
                    array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]+',
                    ),
                    'defaults' =>
                    array(
                        'controller' => 'Backend\\Controller\\Jeux',
                        'action' => 'list',
                    ),
                ),
            ),
            'backend-jeux-ajaxList' =>
            array(
                'type' => 'segment',
                'options' =>
                array(
                    'route' => '/backend/jeux/ajaxList',
                    'constraints' =>
                    array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]+',
                    ),
                    'defaults' =>
                    array(
                        'controller' => 'Backend\\Controller\\Jeux',
                        'action' => 'ajaxList',
                    ),
                ),
            ),
            'backend-jeux-create' =>
            array(
                'type' => 'segment',
                'options' =>
                array(
                    'route' => '/backend/jeux/create',
                    'constraints' =>
                    array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]+',
                    ),
                    'defaults' =>
                    array(
                        'controller' => 'Backend\\Controller\\Jeux',
                        'action' => 'create',
                    ),
                ),
            ),
            'backend-jeux-update' =>
            array(
                'type' => 'segment',
                'options' =>
                array(
                    'route' => '/backend/jeux/update/[:id]',
                    'constraints' =>
                    array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]+',
                        'id' => '[0-9]+',
                    ),
                    'defaults' =>
                    array(
                        'controller' => 'Backend\\Controller\\Jeux',
                        'action' => 'update',
                    ),
                ),
            ),
            'backend-jeux-delete' =>
            array(
                'type' => 'segment',
                'options' =>
                array(
                    'route' => '/backend/jeux/delete/[:id]',
                    'constraints' =>
                    array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]+',
                        'id' => '[0-9]+',
                    ),
                    'defaults' =>
                    array(
                        'controller' => 'Backend\\Controller\\Jeux',
                        'action' => 'delete',
                    ),
                ),
            ),
            'backend-personnages-list' =>
            array(
                'type' => 'segment',
                'options' =>
                array(
                    'route' => '/backend/personnages/list',
                    'constraints' =>
                    array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]+',
                    ),
                    'defaults' =>
                    array(
                        'controller' => 'Backend\\Controller\\Personnages',
                        'action' => 'list',
                    ),
                ),
            ),
            'backend-personnages-ajaxList' =>
            array(
                'type' => 'segment',
                'options' =>
                array(
                    'route' => '/backend/personnages/ajaxList',
                    'constraints' =>
                    array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]+',
                    ),
                    'defaults' =>
                    array(
                        'controller' => 'Backend\\Controller\\Personnages',
                        'action' => 'ajaxList',
                    ),
                ),
            ),
            'backend-personnages-create' =>
            array(
                'type' => 'segment',
                'options' =>
                array(
                    'route' => '/backend/personnages/create',
                    'constraints' =>
                    array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]+',
                    ),
                    'defaults' =>
                    array(
                        'controller' => 'Backend\\Controller\\Personnages',
                        'action' => 'create',
                    ),
                ),
            ),
            'backend-personnages-update' =>
            array(
                'type' => 'segment',
                'options' =>
                array(
                    'route' => '/backend/personnages/update/[:id]',
                    'constraints' =>
                    array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]+',
                        'id' => '[0-9]+',
                    ),
                    'defaults' =>
                    array(
                        'controller' => 'Backend\\Controller\\Personnages',
                        'action' => 'update',
                    ),
                ),
            ),
            'backend-personnages-delete' =>
            array(
                'type' => 'segment',
                'options' =>
                array(
                    'route' => '/backend/personnages/delete/[:id]',
                    'constraints' =>
                    array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]+',
                        'id' => '[0-9]+',
                    ),
                    'defaults' =>
                    array(
                        'controller' => 'Backend\\Controller\\Personnages',
                        'action' => 'delete',
                    ),
                ),
            ),
            'backend-roster-list' =>
            array(
                'type' => 'segment',
                'options' =>
                array(
                    'route' => '/backend/roster/list',
                    'constraints' =>
                    array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]+',
                    ),
                    'defaults' =>
                    array(
                        'controller' => 'Backend\\Controller\\Roster',
                        'action' => 'list',
                    ),
                ),
            ),
            'backend-roster-ajaxList' =>
            array(
                'type' => 'segment',
                'options' =>
                array(
                    'route' => '/backend/roster/ajaxList',
                    'constraints' =>
                    array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]+',
                    ),
                    'defaults' =>
                    array(
                        'controller' => 'Backend\\Controller\\Roster',
                        'action' => 'ajaxList',
                    ),
                ),
            ),
            'backend-roster-create' =>
            array(
                'type' => 'segment',
                'options' =>
                array(
                    'route' => '/backend/roster/create',
                    'constraints' =>
                    array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]+',
                    ),
                    'defaults' =>
                    array(
                        'controller' => 'Backend\\Controller\\Roster',
                        'action' => 'create',
                    ),
                ),
            ),
            'backend-roster-update' =>
            array(
                'type' => 'segment',
                'options' =>
                array(
                    'route' => '/backend/roster/update/[:id]',
                    'constraints' =>
                    array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]+',
                        'id' => '[0-9]+',
                    ),
                    'defaults' =>
                    array(
                        'controller' => 'Backend\\Controller\\Roster',
                        'action' => 'update',
                    ),
                ),
            ),
            'backend-roster-delete' =>
            array(
                'type' => 'segment',
                'options' =>
                array(
                    'route' => '/backend/roster/delete/[:id]',
                    'constraints' =>
                    array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]+',
                        'id' => '[0-9]+',
                    ),
                    'defaults' =>
                    array(
                        'controller' => 'Backend\\Controller\\Roster',
                        'action' => 'delete',
                    ),
                ),
            ),
            'backend-roster_has_personnage-list' =>
            array(
                'type' => 'segment',
                'options' =>
                array(
                    'route' => '/backend/roster_has_personnage/list',
                    'constraints' =>
                    array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]+',
                    ),
                    'defaults' =>
                    array(
                        'controller' => 'Backend\\Controller\\RosterHasPersonnage',
                        'action' => 'list',
                    ),
                ),
            ),
            'backend-roster_has_personnage-ajaxList' =>
            array(
                'type' => 'segment',
                'options' =>
                array(
                    'route' => '/backend/roster_has_personnage/ajaxList',
                    'constraints' =>
                    array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]+',
                    ),
                    'defaults' =>
                    array(
                        'controller' => 'Backend\\Controller\\RosterHasPersonnage',
                        'action' => 'ajaxList',
                    ),
                ),
            ),
            'backend-roster_has_personnage-create' =>
            array(
                'type' => 'segment',
                'options' =>
                array(
                    'route' => '/backend/roster_has_personnage/create',
                    'constraints' =>
                    array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]+',
                    ),
                    'defaults' =>
                    array(
                        'controller' => 'Backend\\Controller\\RosterHasPersonnage',
                        'action' => 'create',
                    ),
                ),
            ),
            'backend-roster_has_personnage-update' =>
            array(
                'type' => 'segment',
                'options' =>
                array(
                    'route' => '/backend/roster_has_personnage/update/[:id]',
                    'constraints' =>
                    array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]+',
                        'id' => '[0-9]+',
                    ),
                    'defaults' =>
                    array(
                        'controller' => 'Backend\\Controller\\RosterHasPersonnage',
                        'action' => 'update',
                    ),
                ),
            ),
            'backend-roster_has_personnage-delete' =>
            array(
                'type' => 'segment',
                'options' =>
                array(
                    'route' => '/backend/roster_has_personnage/delete/[:id]',
                    'constraints' =>
                    array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]+',
                        'id' => '[0-9]+',
                    ),
                    'defaults' =>
                    array(
                        'controller' => 'Backend\\Controller\\RosterHasPersonnage',
                        'action' => 'delete',
                    ),
                ),
            ),
            'backend-plugin-list' =>
            array(
                'type' => 'segment',
                'options' =>
                array(
                    'route' => '/backend/plugin/list',
                    'constraints' =>
                    array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]+',
                    ),
                    'defaults' =>
                    array(
                        'controller' => 'Backend\\Controller\\Plugin',
                        'action' => 'list',
                    ),
                ),
            ),
            'backend-plugin-ajaxList' =>
            array(
                'type' => 'segment',
                'options' =>
                array(
                    'route' => '/backend/plugin/ajaxList',
                    'constraints' =>
                    array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]+',
                    ),
                    'defaults' =>
                    array(
                        'controller' => 'Backend\\Controller\\Plugin',
                        'action' => 'ajaxList',
                    ),
                ),
            ),
            'backend-plugin-install' =>
            array(
                'type' => 'segment',
                'options' =>
                array(
                    'route' => '/backend/plugin/install/[:nomCourt]',
                    'constraints' =>
                    array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]+',
                        'nomCourt' => '[a-zA-Z][a-zA-Z0-9]+',
                    ),
                    'defaults' =>
                    array(
                        'controller' => 'Backend\\Controller\\Plugin',
                        'action' => 'install',
                    ),
                ),
            ),
            'backend-plugin-actif' =>
            array(
                'type' => 'segment',
                'options' =>
                array(
                    'route' => '/backend/plugin/active/[:nomCourt]',
                    'constraints' =>
                    array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]+',
                        'nomCourt' => '[a-zA-Z][a-zA-Z0-9]+',
                    ),
                    'defaults' =>
                    array(
                        'controller' => 'Backend\\Controller\\Plugin',
                        'action' => 'active',
                    ),
                ),
            ),
            'backend-plugin-desactif' =>
            array(
                'type' => 'segment',
                'options' =>
                array(
                    'route' => '/backend/plugin/desactive/[:nomCourt]',
                    'constraints' =>
                    array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]+',
                        'nomCourt' => '[a-zA-Z][a-zA-Z0-9]+',
                    ),
                    'defaults' =>
                    array(
                        'controller' => 'Backend\\Controller\\Plugin',
                        'action' => 'desactive',
                    ),
                ),
            ),
            'backend-plugin-desinstall' =>
            array(
                'type' => 'segment',
                'options' =>
                array(
                    'route' => '/backend/plugin/desinstall/[:nomCourt]',
                    'constraints' =>
                    array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]+',
                        'nomCourt' => '[a-zA-Z][a-zA-Z0-9]+',
                    ),
                    'defaults' =>
                    array(
                        'controller' => 'Backend\\Controller\\Plugin',
                        'action' => 'desinstall',
                    ),
                ),
            ),
        ),
    )
);
