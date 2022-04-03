<?php

require_once  __DIR__ . '/../src/vendor/autoload.php';


use lbs\command\app\bootstrap\lbsBootstrap;


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
//localhost/squelette-projet-lbs-21/lbs.2021/lbs_commande_service/public/index.php/commandes/1


/*
$app->get('/commandes', function (Request $rq, Response $rs, array $args): Response {

    $commands = [
        ["id" => "45RF56TH", "mail_client" => "g@g.fr", "date_commande" => "2021-12-01", "montant" => 50.0],
        ["id" => "46RF56TH", "mail_client" => "a@a.fr", "date_commande" => "2022-01-06", "montant" => 45.0],
        ["id" => "57RF56TH", "mail_client" => "l@l.fr", "date_commande" => "2021-01-18", "montant" => 27.5],
        ["id" => "01RF56TH", "mail_client" => "m@m.fr", "date_commande" => "2021-01-19", "montant" => 30.0],

    ];

    $data = [
        "type" => "collection",
        "count" => count($commands),
        "commandes" => $commands
    ];

    $rs = $rs->withHeader('Content-Type', 'application/json');
    $rs->getBody()->write(json_encode($data));
    //$rs->getBody()->write(json_encode($commands));
    return $rs;
});
$app->run();
//$app = new \Slim\App;
/*
$app->get('/', function (Request $rq, Response $rs, array $args):Response {

    $host = $this->dbhost;
    $rs->getBody()->write(($this->m2html)( '# '. $host) );
    return $rs;

});/*
/*
$app->get('/hello/{name}[/]', TD1CommandController::class.':sayHello')
->setName('hello');

$app->get('/home', TD1CommandController::class.':welcome');

$app->run();*/
/*
$pdo = new PDO('mysql:dbname=commande_lbs;host=localhost', 'fcai', '010706');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
// Paramètre de connexion issus de conf.ini

$container = $app->getContainer();
$container['pdo'] = function() {
    
};

$container['logger'] = function($c) {
    $logger = new \Monolog\Logger('my_logger');
    $file_handler = new \Monolog\Handler\StreamHandler('../logs/app.log');
    $logger->pushHandler($file_handler);
    return $logger;

};

$this->logger->addInfo('Something interesting happened');
*/



/*
$app->get('/commandes/{id}', function(Request $rq, Response $rs, array $args): Response {
    $name = $args['id'];
    $commands = [
        ["id" => "45RF56TH", "mail_client" => "g@g.fr", "date_commande" => "2021-12-01", "montant" => 50.0],
        ["id" => "46RF56TH", "mail_client" => "a@a.fr", "date_commande" => "2022-01-06", "montant" => 45.0],
        ["id" => "57RF56TH", "mail_client" => "l@l.fr", "date_commande" => "2021-01-18", "montant" => 27.5],
        ["id" => "01RF56TH", "mail_client" => "m@m.fr", "date_commande" => "2021-01-19", "montant" => 30.0],

    ];

        $data = [
        "type" => "resource",
        "commande" => $name,
    ];
    $rs = $rs->withHeader('Content-Type', 'application/json');
    $rs->getBody()->write(json_encode($data));
    return $rs;
});
//localhost/squelette-projet-lbs-21/lbs.2021/lbs_commande_service/public/index.php/commandes/1
*/

/*
$app->get('/commandes', function (Request $rq, Response $rs, array $args): Response {

    $commands = [
        ["id" => "45RF56TH", "mail_client" => "g@g.fr", "date_commande" => "2021-12-01", "montant" => 50.0],
        ["id" => "46RF56TH", "mail_client" => "a@a.fr", "date_commande" => "2022-01-06", "montant" => 45.0],
        ["id" => "57RF56TH", "mail_client" => "l@l.fr", "date_commande" => "2021-01-18", "montant" => 27.5],
        ["id" => "01RF56TH", "mail_client" => "m@m.fr", "date_commande" => "2021-01-19", "montant" => 30.0],

    ];

    $data = [
        "type" => "collection",
        "count" => count($commands),
        "commandes" => $commands
    ];

    $rs = $rs->withHeader('Content-Type', 'application/json');
    $rs->getBody()->write(json_encode($data));
    //$rs->getBody()->write(json_encode($commands));
    return $rs;
});
$app->run();*/
/*
$app->get('/commandes', function(Request $rq, Response $rs, array $args): Response {
    $rs->getBody()->write("<h1>Hello</h1>");
    return $rs;
});
$app->run();*/

$app->get('/catalogue.html', \lbs\web\wrapper\controller\CatalogueController::class.':index')
->setName('index');

?>