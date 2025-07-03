<?php

//importation de controller
use app\controllers\AuthController;
use app\controllers\Controller;
use app\controllers\EnregistrementController;
use app\controllers\CrudController;

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
// exemple de base
$router->get('/', [ $Controller, 'acceuil' ]);
$router->get('/login', [ $Controller, 'login' ]);
$router->get('/signin', [ $Controller, 'login' ]);

// page statistique
$router->get('/demographie', [ $Controller, 'demographie' ]);
$router->get('/abonnement', [ $Controller, 'abonnement' ]);

// page suivi
$router->get('/presence', [ $Controller, 'presence' ]);
$router->get('/personnel', [ $Controller, 'personnel' ]);
$router->get('/club', [ $Controller, 'club' ]);

$router->get('/salle', [ $Controller, 'club' ]);


// page gestion
$router->get('/tarif', [ $Controller, 'tarif' ]);
$router->get('/edt', [ $Controller, 'edt' ]);

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