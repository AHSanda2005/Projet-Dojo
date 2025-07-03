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

        // Assurez-vous que adult est bien un booléen (0 ou 1)
        $adult = isset($data->adult) ? (bool)$data->adult : false;

        $result = $model->insert($data->montant, $adult, $data->type_abonnement);
        $message = $result ?: "Échec de la création.";
        $tarifs = $model->getAll();
        Flight::render('EcolageViews/list_tarif', ['tarifs' => $tarifs, 'message' => $message]);
    }

    public function update($id) {
        $data = Flight::request()->data;
        $model = new TarifEcolageModel();

        $adult = isset($data->adult) ? (bool)$data->adult : false;

        $result = $model->update($id, $data->montant, $adult, $data->type_abonnement);
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

    // Récupérer le tarif actif en fonction du type d'abonnement (ex: '3 mois', '1 an')
    public function prixActif($type_abonnement) {
        $model = new TarifEcolageModel();
        $montant = $model->getActivePrice($type_abonnement);
        $message = $montant !== null ? "Prix actif : $montant" : "Aucun tarif actif trouvé.";
        Flight::render('EcolageViews/detail_prix_actif', ['montant' => $montant, 'message' => $message]);
    }

    // Calcul du prix après réduction en fonction de la durée (la logique est dans le modèle)
    public function calculerReduction() {
        $data = Flight::request()->data;

        $model = new TarifEcolageModel();

        if (!isset($data->montant) || !isset($data->type_abonnement)) {
            $message = "Données incomplètes.";
            Flight::render('EcolageViews/reduction_tarif', ['prix_reduit' => null, 'message' => $message]);
            return;
        }

        $montant = $data->montant;
        $duree = $data->type_abonnement;

        $prixReduit = $model->calculateDiscount($duree, $montant);
        $message = $prixReduit !== null ? "Prix après réduction : $prixReduit" : "Erreur de calcul.";

        Flight::render('EcolageViews/reduction_tarif', ['prix_reduit' => $prixReduit, 'message' => $message]);
    }
}
?>
