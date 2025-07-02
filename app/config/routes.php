<?php

//importation de controller
use app\controllers\GroupeControllers\GroupeController;
use app\controllers\GroupeControllers\ReservationController;

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

$GroupeController = new GroupeController();
$ReservationController = new ReservationController();


$router->get('/test', function() {
    Flight::json(['message' => 'Test OK']);
});

$router->get('/', [ $GroupeController, 'formGroupe' ]);
$router->get('/groupes', [ $GroupeController, 'GetAllGroupes' ]);
$router->get('/groupe/@id:[0-9]+', [ $GroupeController, 'GetGroupeById' ]);
$router->get('/groupe/insert', [ $GroupeController, 'formGroupe' ]);
$router->post('/groupe/insert', [ $GroupeController, 'InsertGroupe' ]);
$router->post('/groupe/update/@id:[0-9]+', [ $GroupeController, 'UpdateGroupe' ]);
$router->get('/groupe/delete/@id:[0-9]+', [ $GroupeController, 'DeleteGroupe' ]);

$router->get('/reservations', [ $ReservationController, 'GetAllReservations' ]);
$router->get('/reservation/@id:[0-9]+', [ $ReservationController, 'GetReservationById' ]);
$router->get('/reservation/insert', [ $ReservationController, 'formReservation' ]);
$router->post('/reservation/insert', [ $ReservationController, 'InsertReservation' ]);
$router->post('/reservation/update/@id:[0-9]+', [ $ReservationController, 'UpdateReservation' ]);
$router->get('/reservation/delete/@id:[0-9]+', [ $ReservationController, 'DeleteReservation' ]);



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