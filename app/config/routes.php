<?php

//importation de controller
use app\controllers\AuthController;
use app\controllers\Controller;
use app\controllers\EnregistrementController;
use app\controllers\CrudController;
use app\controllers\EcolageController;
use app\controllers\PaiementController;

//importation lié flight
use flight\Engine;
use flight\net\Router;

//use Flight;

/** 
 * @var Router $router 
 * @var Engine $app
 */
/*$router->get('/', function() use ($app) {
	$Welcome_Controller = new WelcomeController($app);
	$app->render('welcome', [ 'message' => 'It works!!' ]);
});*/

$Controller = new Controller();
$router->get('/', [ $Controller, 'acceuil' ]);

$ecolageController = new EcolageController();

$router->get('/ecolage/paiement/@id_eleve', [$ecolageController, 'paiementEcolageForm']);
Flight::route('POST /ecolage/paiement', [$ecolageController, 'paiementEcolage']);
$router->get('/ecolage/liste_paiement/@id_eleve', [$ecolageController, 'afficherPaiements']);


Flight::route('GET /ecolage', [$ecolageController, 'index']);
Flight::route('GET /ecolage/create', [$ecolageController, 'createForm']);
Flight::route('POST /ecolage/create', [$ecolageController, 'create']);
Flight::route('GET /ecolage/edit/@id', [$ecolageController, 'editForm']);
Flight::route('POST /ecolage/edit/@id', [$ecolageController, 'update']);
Flight::route('GET /ecolage/delete/@id', [$ecolageController, 'delete']);
Flight::route('GET /ecolage/@id', [$ecolageController, 'show']);
Flight::route('GET /ecolage/eleve/@id', [$ecolageController, 'byEleve']);


$paiementControlleur = new PaiementController();
Flight::route('GET /paiement/create', [$paiementControlleur, 'createForm']);
Flight::route('POST /paiement/create', [$paiementControlleur, 'create']);
Flight::route('GET /paiement/edit/@id', [$paiementControlleur, 'editForm']);
Flight::route('POST /paiement/edit/@id', [$paiementControlleur, 'update']);
Flight::route('GET /paiement/delete/@id', [$paiementControlleur, 'delete']);
Flight::route('GET /paiement/groupe/@id', [$paiementControlleur, 'paiementsParGroupe']);
Flight::route('GET /paiement/@id', [$paiementControlleur, 'show']);
Flight::route('GET /paiement', [$paiementControlleur, 'index']);



// $router->get('/', \app\controllers\WelcomeController::class.'->home'); 

// $router->get('/hello-world/@name', function($name) {
// 	echo '<h1>Hello world! Oh hey '.$name.'!</h1>';
// });

// $router->group('/api', function() use ($router, $app) {
// 	$Api_Example_Controller = new ApiExampleController($app);
// 	$router->get('/users', [ $Api_Example_Controller, 'getUsers' ]);
// 	$router->get('/users/@id:[0-9]', [ $Api_Example_Controller, 'getUser' ]);
// 	$router->post('/users/@id:[0-9]', [ $Api_Example_Controller, 'updateUser' ]);
// });

?>