<?php

return array('template_path_stack' => array(
        'default' => __DIR__ . '/view',
    ),
    'template_map' => include 'template_map.php',
    // spécifique layout pour certain modules
    'module_layouts' => array('Application' => 'layout/layout', 'Backend' => 'layout/backend',),
);
