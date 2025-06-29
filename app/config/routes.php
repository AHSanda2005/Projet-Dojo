<?php

//importation de controller
use app\controllers\AuthController;
use app\controllers\Controller;
use app\controllers\EnregistrementController;
use app\controllers\CrudController;
use app\controllers\UtilisateurControllers\GenreController;
use app\controllers\UtilisateurControllers\UserController;

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

$GenreController = new GenreController();

// Routes pour la gestion des genres (CRUD)
$router->get('/genres', [ $GenreController, 'index' ]);
$router->get('/genres/create', [ $GenreController, 'create' ]);
$router->post('/genres/store', [ $GenreController, 'store' ]);
$router->get('/genres/edit/@id:[0-9]+', [ $GenreController, 'edit' ]);
$router->post('/genres/update/@id:[0-9]+', [ $GenreController, 'update' ]);
$router->get('/genres/delete/@id:[0-9]+', [ $GenreController, 'delete' ]);
$router->post('/genres/destroy/@id:[0-9]+', [ $GenreController, 'destroy' ]);

// Routes API pour les genres
$router->get('/api/genres', [ $GenreController, 'apiIndex' ]);
$router->get('/api/genres/@id:[0-9]+', [ $GenreController, 'apiShow' ]);

// Routes pour la gestion des utilisateurs (CRUD)
$UserController = new UserController();
$router->get('/users', [ $UserController, 'index' ]);
$router->get('/users/create', [ $UserController, 'create' ]);
$router->post('/users/store', [ $UserController, 'store' ]);
$router->get('/users/edit/@type/@id:[0-9]+', [ $UserController, 'edit' ]);
$router->post('/users/update/@type/@id:[0-9]+', [ $UserController, 'update' ]);
$router->get('/users/delete/@type/@id:[0-9]+', [ $UserController, 'delete' ]);
$router->post('/users/destroy/@type/@id:[0-9]+', [ $UserController, 'destroy' ]);

$router->get('/api/users', [ $UserController, 'apiIndex' ]);

// Routes pour la gestion des relations parent-élève
$router->get('/parent-eleve', [ $UserController, 'parentEleveIndex' ]);
$router->get('/parent-eleve/create', [ $UserController, 'parentEleveCreate' ]);
$router->post('/parent-eleve/store', [ $UserController, 'parentEleveStore' ]);
$router->get('/parent-eleve/link/@id_eleve:[0-9]+', [ $UserController, 'parentEleveLinkForm' ]);
$router->post('/parent-eleve/link/@id_eleve:[0-9]+', [ $UserController, 'parentEleveLink' ]);
$router->get('/parent-eleve/unlink/@id:[0-9]+', [ $UserController, 'parentEleveUnlink' ]);

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