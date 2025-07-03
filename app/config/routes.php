<?php

//importation de controller
use app\controllers\AuthController;
use app\controllers\Controller;
use app\controllers\EnregistrementController;
use app\controllers\CrudController;

use app\controllers\EvolutionController;

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

$evolutionController = new EvolutionController();
$router->get('/evolution', [$evolutionController, 'listElevesEvolution']);
$router->get('/evolutionForm', [$evolutionController, 'goToEvolutionForm']);
$router->post('/save', [$evolutionController, 'saveEvolution']);
$router->get('/details', [$evolutionController, 'detailsEvolution']);
$router->get('/supp', [$evolutionController, 'suppression']);
$router->get('/modif', [$evolutionController, 'goToModifForm']);
$router->post('/updateEvolution', [$evolutionController, 'modification']);
$router->get('/retour', [$evolutionController, 'retour']);
$router->get('/statEvolution', [$evolutionController, 'showGlobalStats']);

?>