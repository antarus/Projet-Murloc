<?php

// TODO revoir la traduction
$translator = new \Zend\I18n\Translator\Translator();
return array(
    'default' => array(
        array(
            'label' => $translator->translate('Home'),
            'route' => 'home',
            'action' => 'index',
        ),
        array(
            'label' => $translator->translate('Système'),
            'route' => 'back-plugin-list',
            'action' => 'index',
            'pages' => array(
                array(
                    'label' => $translator->translate('Jeux'),
                    'route' => 'backend-plugin-list',
                    'action' => 'index',
                ),
            )
        ),
        array(
            'label' => $translator->translate('Référentiel'),
            'route' => null,
            'action' => 'index',
            'pages' => array(
                array(
                    'label' => $translator->translate('Guildes'),
                    'route' => 'backend-guildes-list',
                    'action' => 'index',
                ),
                array(
                    'label' => $translator->translate('Jeux'),
                    'route' => 'backend-jeux-list',
                    'action' => 'index',
                ),
                array(
                    'label' => $translator->translate('Personnages'),
                    'route' => 'backend-personnages-list',
                    'action' => 'index',
                ),
                array(
                    'label' => $translator->translate('Roster'),
                    'route' => 'backend-roster-list',
                    'action' => 'index',
                ),
            )
        ),
    )
);
