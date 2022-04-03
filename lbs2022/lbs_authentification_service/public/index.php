<?php

require_once  __DIR__ . '/../src/vendor/autoload.php';

use \lbs\auth\app\controller\CommandController as CommandController;

//Controlleur
use \lbs\auth\app\controller\TD7 as TD7Command_Controller;
use \lbs\auth\app\controller\LBSAuthController as LBSAuthController;

//Midldleware
use \lbs\auth\app\middleware\Middleware as Middleware;

//Validator
use lbs\auth\app\validators\Validators as validators;
use \DavidePastore\Slim\Validation\Validation as Validation ;

$settings = require_once __DIR__. '/../src/app/conf/settings.php';
$errors = require_once __DIR__. '/../src/app/conf/errors.php';
$dependencies= require_once __DIR__. '/../src/app/conf/dependencies.php';

$app_config = array_merge($settings, $errors, $dependencies);


$app = new \Slim\App(new \Slim\Container($app_config));

// Initiate DB connection with Eloquent
$capsule = new \Illuminate\Database\Capsule\Manager;
$capsule->addConnection($app_config['settings']['dbfile']);
$capsule->bootEloquent();
$capsule->setAsGlobal();

// Set the differents routes
 
$app->get('/hello[/]', CommandController::class . ':hello')
    ->setName('hello');

$app->get('/TD7/commandes[/]', TD7Command_Controller::class . ':')
    ->setName('Authentification');

$app->post('/TD7/auth[/]', LBSAuthController::class . ':authenticate')
    ->setName('auth');

$app->get('/TD7/check[/]', LBSAuthController::class . ':check')
    ->setName('check');
    
$app->run();