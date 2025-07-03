<?php
// Importation des controllers
use app\controllers\AbonnementController\AbonnementController;
use app\controllers\TarifAbonnementController\TarifAbonnementController;
use app\controllers\TarifClubController\TarifClubController;
use app\controllers\TarifEcolageController\TarifEcolageController;

use flight\Engine;
use flight\net\Router;

/** @var Router $router */
/** @var Engine $app */

$AbonnementController = new AbonnementController();
$TarifAbonnementController = new TarifAbonnementController();
$TarifClubController = new TarifClubController();
$TarifEcolageController = new TarifEcolageController();

// TEST
$router->get('/test', function () {
    Flight::json(['message' => 'Test OK']);
});

// Abonnement routes
$router->get('/abonnements', [ $AbonnementController, 'index' ]);
$router->get('/abonnement/@id:[0-9]+', [ $AbonnementController, 'show' ]);
$router->post('/abonnement/create', [ $AbonnementController, 'create' ]);
$router->post('/abonnement/update/@id:[0-9]+', [ $AbonnementController, 'update' ]);
$router->get('/abonnement/delete/@id:[0-9]+', [ $AbonnementController, 'delete' ]);
$router->post('/abonnement/renouveler/@id:[0-9]+/@nom:[a-zA-Z0-9_-]+/@prix:[0-9]+/@duree:[0-9]+', [ $AbonnementController, 'renouveler' ]);
$router->get('/abonnement/annuler/@id:[0-9]+', [ $AbonnementController, 'annuler' ]);
$router->get('/abonnement/actif/@id:[0-9]+', [ $AbonnementController, 'isActive' ]);
$router->get('/abonnement/jours-restants/@id:[0-9]+', [ $AbonnementController, 'daysRemaining' ]);
$router->get('/abonnement/rappel', [ $AbonnementController, 'rappelAutomatique' ]);
$router->get('/abonnement/proforma/@id:[0-9]+', [ $AbonnementController, 'proforma' ]);
$router->get('/abonnement/send-reminder/@id:[0-9]+', [ $AbonnementController, 'sendReminderEmail' ]);

// Tarif Abonnement routes
$router->get('/tarifs', [ $TarifAbonnementController, 'index' ]);
$router->get('/tarif/@id:[0-9]+', [ $TarifAbonnementController, 'show' ]);
$router->post('/tarif/insert', [ $TarifAbonnementController, 'create' ]);
$router->post('/tarif/update/@id:[0-9]+', [ $TarifAbonnementController, 'update' ]);
$router->get('/tarif/delete/@id:[0-9]+', [ $TarifAbonnementController, 'delete' ]);
$router->get('/tarif/current', [ $TarifAbonnementController, 'getCurrentTarif' ]);

// Tarif Club routes
$router->get('/tarifs-club', [ $TarifClubController, 'index' ]);
$router->get('/tarif-club/@id:[0-9]+', [ $TarifClubController, 'show' ]);
$router->post('/tarif-club/insert', [ $TarifClubController, 'create' ]);
$router->post('/tarif-club/update/@id:[0-9]+', [ $TarifClubController, 'update' ]);
$router->get('/tarif-club/delete/@id:[0-9]+', [ $TarifClubController, 'delete' ]);
$router->get('/tarif-club/hourly/@id:[0-9]+', [ $TarifClubController, 'hourlyRate' ]);
$router->get('/tarif-club/calcule/@id:[0-9]+/@taille:[0-9]+', [ $TarifClubController, 'groupPrice' ]);

// Tarif Ecolage routes
$router->get('/tarif-ecolage', [ $TarifEcolageController, 'index' ]);
$router->get('/tarif-ecolage/@id:[0-9]+', [ $TarifEcolageController, 'show' ]);
$router->post('/tarif-ecolage/insert', [ $TarifEcolageController, 'create' ]);
$router->post('/tarif-ecolage/update/@id:[0-9]+', [ $TarifEcolageController, 'update' ]);
$router->get('/tarif-ecolage/delete/@id:[0-9]+', [ $TarifEcolageController, 'delete' ]);
$router->get('/tarif-ecolage/actif/@type_abonnement', [ $TarifEcolageController, 'prixActif' ]);
$router->post('/tarif-ecolage/reduction', [ $TarifEcolageController, 'calculerReduction' ]);


?>
