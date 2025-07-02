<?php

namespace app\controllers;

use app\models\EcolageModel;
use DateTime;
use PDO;
use Flight;

class EcolageController {
    public function __construct() {

    }

    public function index() {
        $model = new \app\models\EcolageModel(Flight::db());
        $data = $model->getAll();
        Flight::render('ecolage/index', ['ecolages' => $data]);
    }

    public function show($id) {
        $model = new \app\models\EcolageModel(Flight::db());
        $item = $model->getById($id);
        Flight::render('ecolage/show', ['ecolage' => $item]);
    }

    public function createForm() {
        Flight::render('ecolage/create');
    }

    public function create() {
        $model = new \app\models\EcolageModel(Flight::db());
        $data = Flight::request()->data->getData();
        $model->create($data);
        Flight::redirect('/ecolage');
    }

    public function editForm($id) {
        $model = new \app\models\EcolageModel(Flight::db());
        $item = $model->getById($id);
        Flight::render('ecolage/edit', ['ecolage' => $item]);
    }

    public function update($id) {
        $model = new \app\models\EcolageModel(Flight::db());
        $data = Flight::request()->data->getData();
        $model->update($id, $data);
        Flight::redirect('/ecolage');
    }

    public function delete($id) {
        $model = new \app\models\EcolageModel(Flight::db());
        $model->delete($id);
        Flight::redirect('/ecolage');
    }

    public function byEleve($id_eleve) {
        $model = new \app\models\EcolageModel(Flight::db());
        $data = $model->getByEleve($id_eleve);
        Flight::render('ecolage/by_eleve', ['ecolages' => $data, 'id_eleve' => $id_eleve]);
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
        $success = $ecolageModel->create($data);
        Flight::redirect('eleve/paiement/'.$data['id_eleve']);
    }

    public function afficherPaiements($id_eleve) {
        $model = new \app\models\EcolageModel(Flight::db());
        $paiements = $model->getAllPaiementByEleve($id_eleve);
    
        Flight::render('eleve/liste_paiements', [
            'paiements' => $paiements,
            'id_eleve' => $id_eleve
        ]);
    }
    
}



?>