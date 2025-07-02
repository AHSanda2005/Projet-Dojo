<?php

//importation de controller

use app\controllers\AbonnementController\AbonnementController;
use app\controllers\TarifAbonnementController\TarifAbonnementController;
use app\controllers\TarifClubController\TarifClubController;

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
$AbonnementController = new AbonnementController();
$TarifAbonnementController = new TarifAbonnementController();
$TarifClubController = new TarifClubController();

$router->get('/test', function() {
    Flight::json(['message' => 'Test OK']);
});




$router->get('/abonnements', [ $AbonnementController, 'index' ]);
$router->get('/abonnement/@id:[0-9]+', [ $AbonnementController, 'show' ]);
$router->get('/abonnement/insert', [ $AbonnementController, 'createForm' ]);
$router->post('/abonnement/insert', [ $AbonnementController, 'create' ]);
$router->post('/abonnement/update/@id:[0-9]+', [ $AbonnementController, 'update' ]);
$router->get('/abonnement/delete/@id:[0-9]+', [ $AbonnementController, 'delete' ]);
$router->get('/abonnement/renouveler/@id:[0-9]+', [ $AbonnementController, 'renouveler' ]);
$router->get('/abonnement/annuler/@id:[0-9]+', [ $AbonnementController, 'annuler' ]);
$router->get('/abonnements/rappel', [ $AbonnementController, 'rappelAutomatique' ]);
$router->get('/abonnement/facture/@id:[0-9]+', [ $AbonnementController, 'facture' ]);
$router->get('/abonnements/historique', [ $AbonnementController, 'historique' ]);


$router->get('/tarifs', [ $TarifAbonnementController, 'index' ]);
$router->get('/tarif/@id:[0-9]+', [ $TarifAbonnementController, 'show' ]);
$router->post('/tarif/insert', [ $TarifAbonnementController, 'create' ]);
$router->post('/tarif/update/@id:[0-9]+', [ $TarifAbonnementController, 'update' ]);
$router->get('/tarif/delete/@id:[0-9]+', [ $TarifAbonnementController, 'delete' ]);


$router->get('/tarifs-club', [ $TarifClubController, 'index' ]);
$router->get('/tarif-club/@id:[0-9]+', [ $TarifClubController, 'show' ]);
$router->post('/tarif-club/insert', [ $TarifClubController, 'create' ]);
$router->post('/tarif-club/update/@id:[0-9]+', [ $TarifClubController, 'update' ]);
$router->get('/tarif-club/delete/@id:[0-9]+', [ $TarifClubController, 'delete' ]);
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