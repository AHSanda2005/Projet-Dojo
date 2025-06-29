<?php

//importation de controller
use app\controllers\AuthController;
use app\controllers\Controller;
use app\controllers\EnregistrementController;
use app\controllers\CrudController;

//importation lié flight
use app\controllers\FacturationController;
use app\controllers\HistoriqueGardeController;
use app\controllers\MaterielTypeController;
use app\controllers\StockMaterielController;
use app\controllers\SuiviSalleController;
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
$materielTypeController = new  MaterielTypeController();

define('BASE', '/materiel');
Flight::route("GET " . BASE,               [$materielTypeController, 'index']);
Flight::route("GET " . BASE . "/create", [$materielTypeController, 'create']);
Flight::route("POST " . BASE . "/store",  [$materielTypeController, 'store']);
Flight::route("GET " . BASE . "/@id",     [$materielTypeController, 'show']);
Flight::route("GET " . BASE . "/@id/edit",[$materielTypeController, 'edit']);
Flight::route("POST " . BASE . "/@id/update",[$materielTypeController, 'update']);
Flight::route("GET " . BASE . "/@id/delete",[$materielTypeController, 'delete']);

$stockMaterielController = new  StockMaterielController();
Flight::route('GET /stock', [$stockMaterielController, 'index']);

Flight::route('POST /stock/add', [$stockMaterielController, 'store']);

Flight::route('GET /stock/delete/@id', function($id) {
    (new StockMaterielController())->delete($id);
});

Flight::route('GET /stock/confirmation/@mouvement/@id_type/@quantite', function($mouvement, $id_type, $quantite){
    (new StockMaterielController())->confirm($mouvement, $id_type, $quantite);
});

Flight::route('POST /stock/insert-series', [$stockMaterielController, 'insertSeries']);


Flight::route('POST /stock/remove-items', [$stockMaterielController, 'removeItems']);



$suiviSalleController = new  SuiviSalleController();
Flight::route('GET /suivi-salle', [$suiviSalleController, 'index']);

Flight::route('POST /suivi-salle/add', [$suiviSalleController,'store']);

Flight::route('GET /suivi-salle/delete/@id', function($id) {
    (new SuiviSalleController())->delete($id);
});

$facturationController = new  FacturationController();
Flight::route('GET /facturation/creer/@id_suivi_salle', function($id) {
    (new  FacturationController())->create($id);
});

Flight::route('POST /facturation/valider', [$facturationController, 'store']);

Flight::route('/facturation/pdf/@id', [$facturationController, 'generatePdf']);

Flight::route('GET /facturation/liste', [$facturationController, 'liste']);
Flight::route('GET /facturation/valider/@id_facture', [$facturationController, 'valider']);


$dashboardController = new  DashboardController();
Flight::route('GET /dashboard', [$dashboardController, 'index']);

$historique = new HistoriqueGardeController();

// Liste des historiques
Flight::route('GET /historique-garde', [$historique, 'index']);

// Formulaire création
Flight::route('GET /historique-garde/create', [$historique, 'createForm']);

// Soumission création
Flight::route('POST /historique-garde/create', [$historique, 'create']);

// Formulaire modification
Flight::route('GET /historique-garde/edit/@id', [$historique, 'editForm']);

// Soumission modification
Flight::route('POST /historique-garde/edit/@id', [$historique, 'update']);

// Suppression
Flight::route('GET /historique-garde/delete/@id', [$historique, 'delete']);
?>