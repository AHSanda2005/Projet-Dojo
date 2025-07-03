<?php

namespace app\controllers;

use app\models\PaiementModel;
use app\models\StatusModel;
use app\models\ReservationModel;
use Flight;

class PaiementController {

    public function __construct() {
    }

    public function payerReservation() {
        $id_reservation = (int) Flight::request()->data->id_reservation;

        // 1. Enregistrer le paiement
        $paiementModel = new PaiementModel(Flight::db());
        $paiementModel->create($id_reservation);

        // 2. Mettre à jour le statut
        $statusModel = new StatusModel(Flight::db());
        $statusModel->updateByReservation($id_reservation, 'payee');

        // 3. Recharger les résultats de recherche
        $reservationModel = new ReservationModel(Flight::db());
        $reservations = $reservationModel->searchReservation([]); // recharge tout

        Flight::render('reservation/search', [
            'reservations' => $reservations,
            'old' => [] // champs vides pour ne pas remplir le formulaire
        ]);
    }

    //Afficher tous les paiements
    public function index() {
        $model = new \app\models\PaiementModel(Flight::db());
        $paiements = $model->getAll();
        Flight::render('paiement/index', ['paiements' => $paiements]);
    }

    //Afficher un paiement par ID
    public function show($id) {
        $model = new \app\models\PaiementModel(Flight::db());
        $paiement = $model->getById($id);
        Flight::render('paiement/show', ['paiement' => $paiement]);
    }

    //Formulaire de création
    public function createForm() {
        Flight::render('paiement/create');
    }

    //Créer un paiement (POST)
    public function create() {
        $model = new \app\models\PaiementModel(Flight::db());
        $data = Flight::request()->data->getData();
        $model->create($data);
        Flight::redirect('/paiement');
    }

    //Formulaire d'édition
    public function editForm($id) {
        $model = new \app\models\PaiementModel(Flight::db());
        $paiement = $model->getById($id);
        Flight::render('paiement/edit', ['paiement' => $paiement]);
    }

    //Modifier un paiement (POST)
    public function update($id) {
        $model = new \app\models\PaiementModel(Flight::db());
        $data = Flight::request()->data->getData();
        $model->update($id, $data);
        Flight::redirect('/paiement');
    }

    //Supprimer un paiement
    public function delete($id) {
        $model = new \app\models\PaiementModel(Flight::db());
        $model->delete($id);
        Flight::redirect('/paiement');
    }

    //Paiements par groupe
    public function paiementsParGroupe($id_groupe) {
        $model = new \app\models\PaiementModel(Flight::db());
        $paiements = $model->getAllByGroupe($id_groupe);
        Flight::render('paiement/by_groupe', ['paiements' => $paiements, 'id_groupe' => $id_groupe]);
    }


}

?>
