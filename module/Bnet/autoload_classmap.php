<?php

/**
 * Autoload classmap permet de liée un namespace a un fichier.
 * Permet l'optimisation du temps de chargement.
 *
 * @autor: Antarus
 * @version: 1.0
 * @date: 27/08/2015
 */
return array(
    'Bnet\Core\AbstractClient' => __DIR__ . '/src/Bnet/Core/AbstractClient.php',
    'Api\Model\WowConnexion' => __DIR__ . '/src/Api/Model/WowConnexion.php',
    'Api\Model\Guilde' => __DIR__ . '/src/Api/Model/Guilde.php',
);
