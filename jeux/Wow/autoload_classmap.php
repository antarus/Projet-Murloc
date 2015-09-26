<?php

return array(
    'Jeux\Wow' => __DIR__ . '/Wow.php',
    'Jeux\Wow\View\Helper\WowHelper' => __DIR__ . '/src/Wow/View/Helper/WowHelper.php',
    // TODO Test surcharge.
    // Pose des pb avec le rendu layout, le nom du controller changeant...
    // de plus ce choix de surcharge implique une gestion de jeux unique pour le site
    // donc dependra des choix finaux.
    //'Jeux\Wow\Controller\GuildesController' => __DIR__ . '/src/Wow/Controller/GuildesController.php',
    'Jeux\Wow\Controller\WowGuildeController' => __DIR__ . '/src/Wow/Controller/WowGuildeController.php',
    'Jeux\Wow\Util\ParserWow' => __DIR__ . '/src/Wow/Util/ParserWow.php',
);
