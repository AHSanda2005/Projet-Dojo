<?php

//importation de controller
use app\controllers\Controller;
use app\controllers\controllersCours\CoursController;
use app\controllers\controllersCours\SeancesController;
use app\controllers\controllersCours\CalendrierController;

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

$coursController = new CoursController();
$seancesController = new SeancesController();
$calendrierController = new CalendrierController();

$router->get('/formHistorique', [$coursController, 'afficherHistorique']);
$router->get('/formEmploi', [$coursController, 'genererEmploiDuTemps']);

// Cours
$router->get('/listeCours',[$coursController,'getAllCours']);
$router->get('/formCours', [$coursController, 'getFormCours']);
$router->post('/insertCours', [$coursController, 'insertCours']);
$router->post('/updateCours', [$coursController, 'updateCours']);
$router->get('/deleteCours', [$coursController, 'deleteCours']);

// Seances
$router->get('/formSeance', [$seancesController, 'getFormSeance']);
$router->post('/insertSeance', [$seancesController, 'insertSeance']);
$router->post('/updateSeance', [$seancesController, 'updateSeance']);
$router->get('/deleteSeance', [$seancesController, 'deleteSeance']);
$router->get('/listeSeances', [$seancesController, 'getAllSeances']);
$router->get('/historiqueSeances', [$seancesController, 'historiqueSeances']);

// EDT
$router->get('/calendrier', [$calendrierController, 'afficherMoisComplet']);
$router->get('/calendrier/details', [$calendrierController, 'detailsGroupe']);

?>