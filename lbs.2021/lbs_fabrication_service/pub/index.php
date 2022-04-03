<?php

require_once  __DIR__ . '/../src/vendor/autoload.php';


use lbs\fab\app\bootstrap\lbsBootstrap;


// Les fichiers contenant les dépendance de l'application
$config = require_once __DIR__ . '/../src/app/conf/settings.php';
$dependencies = require_once __DIR__ . '/../src/app/conf/dependencies.php';
$errors = require_once __DIR__ . '/../src/app/conf/error.php';


//Une instance du conteneur de dépendance
$c = new \Slim\Container(array_merge($config,$dependencies,$errors));
$app = new \Slim\App($c);
lbsBootstrap::startEloquent($c->settings['dbfile']);
//Les routes de l'application
require_once __DIR__ . '/../src/app/routes/routes_td.php';
$app->run();

/*
$app->get('/catalogue.html', \lbs\web\wrapper\controller\CatalogueController::class.':index')
->setName('index');*/

?>