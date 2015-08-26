<?php

/**
 * Fichier de config Generale du projet.
 *
 * @autor: Thomas Simon
 * @version: 1.0
 * @date: 08/10/2013
 */
// Autoload des modules installé.
$aModules = array();
$dir = scandir(__DIR__ . '/../module');
foreach ($dir as $file)
    if ($file != '.' && $file != '..')
        $aModules[] = $file;


return array(
    'modules' => $aModules,
    'module_listener_options' => array(
        'module_paths' => array(
            './module',
            './devModule'
        ),
        'config_glob_paths' => array(
            'config/autoload/{,*.}{global,local}.php',
        ),
    ),
);
