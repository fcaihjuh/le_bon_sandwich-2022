<?php

require_once  __DIR__ . '/../src/vendor/autoload.php';

use \lbs\command\app\controller\CommandController as CommandController;

//Controlleurs
use \lbs\command\app\controller\TD2 as TD2Command_Controller;
use \lbs\command\app\controller\TD3 as TD3Command_Controller;
use \lbs\command\app\controller\TD4 as TD4Command_Controller;
use \lbs\command\app\controller\TD5 as TD5Command_Controller;

//Middleware
use \lbs\command\app\middleware\Middleware as Middleware;

//Validator
use lbs\command\app\validators\Validators as validators;
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

//TD1



//TD2
$app->get('/TD2/commandes[/]', TD2Command_Controller::class . ':listCommands')
    ->setName('commands');

$app->get('/TD2/commandes/{id}[/]', TD2Command_Controller::class . ':oneCommand')
    ->setName('command')
    ->add(Middleware::class . ':checkToken');

//TD3
$app->put('/TD3/commandes/{id}[/]', TD3Command_Controller::class . ':replaceCommand')
    ->setName('replaceCommand');

//TD4
$app->get('/TD4/commandes/{id}/items[/]', TD4Command_Controller::class . ':getItemsOfCommand')
    ->setName('ItemsCommand');

//TD5
$app->post('/TD5/commandes[/]', TD5Command_Controller::class . ':createCommand')
    ->setName('creationCommand')
    ->add(Middleware::class . ':createID')
    ->add(Middleware::class . ':createToken')
    ->add(new Validation( Validators::validators_createCommand()) );

/*
$app->put('/commands/{id}[/]', CommandController::class . ':replaceCommand')->setName('replaceCommand');
    
$app->get('/commands/{id}/items[/]', CommandController::class . ':getItemsOfCommand')->setName('commandWithItems');
 */   
    
$app->run();
?>