<?php
namespace app\controllers\GroupeControllers;

use app\models\TarifModels\TarifClubModel;
use Flight;

class TarifClubController {
    public function index() {
        $model = new TarifClubModel();
        $tarifs = $model->getAll();
        Flight::render('TarifViews/club_list', ['tarifs' => $tarifs]);
    }

    public function show($id) {
        $model = new TarifClubModel();
        $tarif = $model->getById($id);
        Flight::render('TarifViews/club_detail', ['tarif' => $tarif]);
    }

    public function create() {
        $montant = Flight::request()->data->montant_par_heure;
        $model = new TarifClubModel();
        $message = $model->insert($montant);
        Flight::render('TarifViews/club_form', ['message' => $message]);
    }

    public function update($id) {
        $montant = Flight::request()->data->montant_par_heure;
        $model = new TarifClubModel();
        $message = $model->update($id, $montant);
        $tarif = $model->getById($id);
        Flight::render('TarifViews/club_detail', ['tarif' => $tarif, 'message' => $message]);
    }

    public function delete($id) {
        $model = new TarifClubModel();
        $message = $model->delete($id);
        $tarifs = $model->getAll();
        Flight::render('TarifViews/club_list', ['tarifs' => $tarifs, 'message' => $message]);
    }
}
?>