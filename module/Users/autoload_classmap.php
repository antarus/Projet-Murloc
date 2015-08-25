<?php

/**
 * Autoload classmap permet de liée un namespace a un fichier.
 * Permet l'optimisation du temps de chargement.
 *
 * @autor: Thomas Simon
 * @version: 1.0
 * @date: 08/10/2013
 */
return array(
    'Users\Controller\IndexController' => __DIR__ . '/src/Users/Controller/IndexController.php',
    'Users\Model\Users' => __DIR__ . '/src/Users/Model/Users.php',
);
