<?php
namespace app\controllers\GroupeControllers;

use app\models\TarifModels\TarifAbonnementModel;
use Flight;

class TarifAbonnementController {
    public function index() {
        $model = new TarifAbonnementModel();
        $tarifs = $model->getAll();
        Flight::render('GroupeViews/abonnement_list', ['tarifs' => $tarifs]);
    }

    public function show($id) {
        $model = new TarifAbonnementModel();
        $tarif = $model->getById($id);
        Flight::render('GroupeViews/abonnement_detail', ['tarif' => $tarif]);
    }

    public function create() {
        $montant = Flight::request()->data->montant;
        $model = new TarifAbonnementModel();
        $message = $model->insert($montant);
        Flight::render('GroupeViews/abonnement_form', ['message' => $message]);
    }

    public function update($id) {
        $montant = Flight::request()->data->montant;
        $model = new TarifAbonnementModel();
        $message = $model->update($id, $montant);
        $tarif = $model->getById($id);
        Flight::render('GroupeViews/abonnement_detail', ['tarif' => $tarif, 'message' => $message]);
    }

    public function delete($id) {
        $model = new TarifAbonnementModel();
        $message = $model->delete($id);
        $tarifs = $model->getAll();
        Flight::render('GroupeViews/abonnement_list', ['tarifs' => $tarifs, 'message' => $message]);
    }
}
?>
