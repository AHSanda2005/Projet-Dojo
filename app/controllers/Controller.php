<?php

namespace app\controllers;

use app\models\utilisateurModels\Database;
use Flight;

class Controller {

    public function __construct() {
    }

    public function acceuil() {
        // Test de la connexion à la base de données uniquement
        $config = Flight::get('config');
        $database = new Database($config['database']);
        $dbStatus = $database->testConnection();

        // Passer les données à la vue
        Flight::render('acceuil', [
            'db_status' => $dbStatus
        ]);
    }
}