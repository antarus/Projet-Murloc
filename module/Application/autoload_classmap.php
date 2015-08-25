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
        'Application\Service\LogService' => __DIR__ . '/src/Application/Service/LogService.php',
        'Application\Controller\IndexController' => __DIR__.'/src/Application/Controller/IndexController.php',
        'Application\Controller\ContactController' => __DIR__.'/src/Application/Controller/ContactController.php',
);
