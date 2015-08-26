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
    'Jeux\Controller\JeuxController' => __DIR__ . '/src/Jeux/Controller/JeuxController.php',
    'Jeux\Model\Jeux' => __DIR__ . '/src/Jeux/Model/Jeux.php',
);
