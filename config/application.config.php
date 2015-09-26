<?php

$env = getenv("APPLICATION_ENV")? : 'production';
//$env = 'developpement';



/**
 * Fichier de config Generale du projet.
 *
 * @autor: Thomas Simon
 * @version: 1.0
 * @date: 08/10/2013
 */
// Autoload des modules installé.

if ($env == 'development') {
    $aModules = array();
    $dir = scandir(__DIR__ . '/../module');
    foreach ($dir as $file)
        if ($file != '.' && $file != '..')
            $aModules[] = $file;
    $aModules[] = 'ZfTable';
    // $aModules[] = 'AsseticBundle';
} else {
    $aModules = array(
        'Application',
        'Core',
        'ZfTable',
        'Jeux',
        'Backend',
        'Bnet',
        //  'Guildes',
        'Users'
    );
}

return array(
    'modules' => $aModules,
    'module_listener_options' => array(
        'module_paths' => array(
            './module',
            './vendor',
        ),
        'config_glob_paths' => array(
            'config/autoload/{{,*.}global,{,*.}local}.php',
        ),
        // Active ou non la configuration du cache pour la configuration.
        //Si activé,la fusion des fichiers de configurations sera caché et réutilisé dans les requêtes.
        'config_cache_enabled' => false, //($env == 'production'),
        // La clé a utiliser pour le cache.
        'config_cache_key' => "2245023265ae4cf87d02c8b6ba991139",
        // Active ou non le cache pour le mappage des classes.
        // Si activé,le mappage des classes sera caché afin de réduire le proces d'autochargemeent.
        'module_map_cache_enabled' => false, //($env == 'production'),
        // La clé utilisé pour créé le fichier de cache du mappage.
        'module_map_cache_key' => "496fe9daf9baed5ab03314f04518b928",
        // Dossier ou seront caché les fichiers.
        'cache_dir' => "./data/cache/config",
        'check_dependencies' => ($env != 'production')
    ),
    'view_manager' => array(
        'display_exceptions' => ($env != 'production'))
);

