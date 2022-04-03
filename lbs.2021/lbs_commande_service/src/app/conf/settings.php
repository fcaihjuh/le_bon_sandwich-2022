<?php
/* FONCTIONNE
return [
    'settings' => [
        'displayErrorDetails'=> true,
        'dbfile'=>parse_ini_file('commande.db.conf.ini.dist'),
        */
        /*
        'determineRouteBeforeAppMiddleware' => false,
        'displayErrorDetails' => true,
        'db' => [
            'driver' => 'mysql',
            'host' => 'localhost',
            'database' => 'slim',
            'username' => 'acai',
            'password' => 'root',
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',

        ]*/
  /*  ],
];
*/
use Slim\Container;


return [
    'settings' => [
        'displayErrorDetails' => true,

        'dbfile' => __DIR__ . '/commande.db.conf.ini.dist',

        'debug.name' => 'lbs.log',
        'debug.log' => __DIR__ . '/../log/debug.log',
        'debug.level' => \Monolog\Logger::DEBUG, 

        'warn.name' => 'lbs.log',
        'warn.log' => __DIR__ . '/../log/warn.log',
        'warn.level' => \Monolog\Logger::WARNING,

        'error.name' => 'lbs.log',               //Nom du log    
        'error.log' => __DIR__ . '/../log/error.log',  //* Nom du fichier du log    
        'error.level' => \Monolog\Logger::ERROR,  
    ]
];
