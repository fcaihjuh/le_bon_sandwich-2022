<?php

require_once  __DIR__ . '/../src/vendor/autoload.php';

use \lbs\fab\app\controller\CommandController as CommandController;

//Controlleurs
use \lbs\fab\app\controller\TD6 as TD6Command_Controller;

//Middleware
use \lbs\fab\app\middleware\Middleware as Middleware;

//Validator
use lbs\fab\app\validators\Validators as validators;
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

$app->get('/TD6/commandes/{id}[/]', TD6Command_Controller::class . ':oneCommand')
    ->setName('command');

$app->get('/TD6/commandes[/]', TD6Command_Controller::class . ':allCommands')
    ->setName('allCommands');
    
//
    
$app->run();