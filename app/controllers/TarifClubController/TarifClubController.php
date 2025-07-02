<?php
namespace app\controllers\TarifClubController;

use app\models\TarifClubModel\TarifClubModel;
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
    public function hourlyRate($id){
        $model = new TarifClubModel();
        $tarif = $model->getById($id);
        if ($tarif) {
            Flight::json(['montant_par_heure' => $tarif['montant_par_heure']]);
        } else {
            Flight::json(['error' => 'Tarif non trouvé'], 404);
        }
    }
    public function groupPrice($id, $taille) {
        $model = new TarifClubModel();
        $tarif = $model->getById($id);
        if ($tarif) {
            $montant_par_heure = $tarif['montant_par_heure'];
            $prix_total = $montant_par_heure * $taille;
            Flight::json(['prix_total' => $prix_total]);
        } else {
            Flight::json(['error' => 'Tarif non trouvé'], 404);
        }
    }
}
?>