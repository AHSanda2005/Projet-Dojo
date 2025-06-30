<?php

namespace app\controllers;

use app\models\EcolageModel;
use DateTime;
use PDO;
use Flight;

class EcolageController {
    public function __construct() {

    }

    public function paiementEcolageForm($id_eleve) {
        // Récupérer les infos de l'élève pour affichage
        $model = new \app\models\EcolageModel(Flight::db());
        $eleve = $model->find($id_eleve);
        // $isAdult = true; // a recuperer selon age 
        $isAdult = false; // a recuperer selon age 
        $tarif = $model->getTarif($isAdult);
        Flight::render('eleve/paiement', ['eleve' => $eleve, 'tarif' => $tarif]);
    }
    
    public function paiementEcolage() {
        $data = Flight::request()->data->getData();
    
        $ecolageModel = new \app\models\EcolageModel(Flight::db());
        $success = $ecolageModel->insert($data);
        Flight::redirect('eleve/paiement/'.$data['id_eleve']);
    }

    public function afficherPaiements($id_eleve) {
        $model = new \app\models\EcolageModel(Flight::db());
        $paiements = $model->getAllPaiement($id_eleve);
    
        Flight::render('eleve/liste_paiements', [
            'paiements' => $paiements,
            'id_eleve' => $id_eleve
        ]);
    }
    
}



?>