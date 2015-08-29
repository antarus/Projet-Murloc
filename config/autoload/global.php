<?php

/**
 * Global Configuration Override
 *
 * You can use this file for overriding configuration values from modules, etc.
 * You would place values in here that are agnostic to the environment and not
 * sensitive to security.
 *
 * @NOTE: In practice, this file will typically be INCLUDED in your source
 * control, so do not include passwords or other sensitive information in this
 * file.
 */
$dbParams = array(
    'database' => 'db580625521',
    'username' => 'dbo580625521',
    'password' => 'crocodile83',
    'hostname' => 'localhost'//db580625521.db.1and1.com'
);

return array(
    'service_manager' => array(
        'factories' => array(
            'Zend\Db\Adapter\Adapter' => 'Zend\Db\Adapter\AdapterServiceFactory',
            'Zend\Cache\Storage\Filesystem' => function($sm) {
                $cache = Zend\Cache\StorageFactory::factory(array(
                            'adapter' => 'filesystem',
                            'plugins' => array(
                                'exception_handler' => array('throw_exceptions' => false),
                                'serializer'
                            )
                ));

//                $cache->setOptions(array(
//                    'cache_dir' => './data/cache'
//                ));

                return $cache;
            },
                ),
                'abstract_factories' => array(
                    'Zend\Log\LoggerAbstractServiceFactory',
                ),
                'aliases' => array(
                    'translator' => 'MvcTranslator',
                ),
            ),
            'log' => array(
                '\Log' => array(
                    'writers' => array(
                        array(
                            'name' => 'stream',
                            'priority' => 1000,
                            'options' => array(
                                'stream' => 'log/murloc.log',),
                        ),
                    ),
                ),
            ),
            'db' => array(
                'driver' => 'pdo',
                'dsn' => 'mysql:dbname=' . $dbParams['database'] . ';host=' . $dbParams['hostname'],
                'database' => $dbParams['database'],
                'username' => $dbParams['username'],
                'password' => $dbParams['password'],
                'hostname' => $dbParams['hostname'],
                'driver_options' => array(
                    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''
                )
            ),
            'urlProjet' => 'dev.murloc-avenue.com',
        );
