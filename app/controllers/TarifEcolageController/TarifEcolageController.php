<?php
namespace app\controllers\TarifEcolageController;
use app\models\TarifEcolageModel\TarifEcolageModel;
use Flight;

class TarifEcolageController {

    public function index() {
        $model = new TarifEcolageModel();
        $tarifs = $model->getAll();
        Flight::render('EcolageViews/list_tarif', ['tarifs' => $tarifs]);
    }

    public function show($id) {
        $model = new TarifEcolageModel();
        $tarif = $model->getById($id);
        Flight::render('EcolageViews/detail_tarif', ['tarif' => $tarif]);
    }

    public function create() {
        $data = Flight::request()->data;
        $model = new TarifEcolageModel();
        $result = $model->insert($data->montant, $data->type);
        $message = $result ?: "Échec de la création.";
        $tarifs = $model->getAll();
        Flight::render('EcolageViews/list_tarif', ['tarifs' => $tarifs, 'message' => $message]);
    }

    public function update($id) {
        $data = Flight::request()->data;
        $model = new TarifEcolageModel();
        $result = $model->update($id, $data->montant, $data->type);
        $message = $result ?: "Échec de la mise à jour.";
        $tarif = $model->getById($id);
        Flight::render('EcolageViews/detail_tarif', ['tarif' => $tarif, 'message' => $message]);
    }

    public function delete($id) {
        $model = new TarifEcolageModel();
        $message = $model->delete($id);
        $tarifs = $model->getAll();
        Flight::render('EcolageViews/list_tarif', ['tarifs' => $tarifs, 'message' => $message]);
    }

    public function prixActif($id) {
        $model = new TarifEcolageModel();
        $montant = $model->getActivePrice($id);
        $message = $montant !== null ? "Prix actif : $montant" : "Aucun tarif actif trouvé.";
        Flight::render('EcolageViews/detail_prix_actif', ['montant' => $montant, 'message' => $message]);
    }

    public function calculerReduction($id, $pourcentage) {
        $model = new TarifEcolageModel();
        $nouveauPrix = $model->calculateDiscount($id, $pourcentage);
        $message = $nouveauPrix !== null ? "Prix après réduction : $nouveauPrix" : "Erreur de calcul.";
        Flight::render('EcolageViews/reduction_tarif', ['prix_reduit' => $nouveauPrix, 'message' => $message]);
    }
}
?>
