<?php
namespace app\controllers\AbonnementController;
use app\models\AbonnementModel\AbonnementModel ;
use Abonnement;
use Flight;

class AbonnementController {

    public function index() {
        $abonnements = new AbonnementModel();
        $abonnements = $abonnements->getAll();
        Flight::render('GroupesViews/list_abonnement', ['abonnements' => $abonnements]);
    }

    public function show($id) {
        $abonnement = new AbonnementModel();
        $abonnement = $abonnement->getById($id);
        Flight::render('GroupesViews/detail_abonnement', ['abonnement' => $abonnement]);
    }


    public function create() {
        $data = Flight::request()->data;
        $success = new AbonnementModel();
        $success = $success->insert([
            'id_club' => $data->id_club,
            'jour' => $data->jour,
            'mois' => $data->mois,
            'actif' => $data->actif
        ]);
        $message = $success ? "Création réussie." : "Échec de création.";
        Flight::render('GroupesViews/form_abonnement', ['message' => $message]);
    }

    public function update($id) {
        $data = Flight::request()->data;
        $success = new AbonnementModel();
        $success = $success->update($id, [
            'id_club' => $data->id_club,
            'jour' => $data->jour,
            'mois' => $data->mois,
            'actif' => $data->actif
        ]);
        $message = $success ? "Mise à jour réussie." : "Échec de mise à jour.";
        $abonnement = $success->getById($id);
        Flight::render('GroupesViews/detail_abonnement', ['abonnement' => $abonnement, 'message' => $message]);
    }

    public function delete($id) {
        $success = new AbonnementModel();
        $success = $success->delete($id);
        $message = $success ? "Suppression réussie." : "Échec de suppression.";
        $abonnements = $success->getAll();
        Flight::render('GroupesViews/list_abonnement', ['abonnements' => $abonnements, 'message' => $message]);
    }

    public function renouveler($id) {
        $success = new AbonnementModel();
        $success = $success->renouveler($id);
        $message = $success ? "Abonnement renouvelé." : "Échec du renouvellement.";
        $abonnements = $success->getAll();
        Flight::render('GroupesViews/list_abonnement', ['abonnements' => $abonnements, 'message' => $message]);
    }

    public function annuler($id) {
        $success = new AbonnementModel();
        $success = $success->annuler($id);
        $message = $success ? "Abonnement annulé." : "Échec de l'annulation.";
        $abonnements = $success->getAll();
        Flight::render('GroupesViews/list_abonnement', ['abonnements' => $abonnements, 'message' => $message]);
    }

    public function rappelAutomatique() {
        $expirants = new AbonnementModel();
        $expirants = $expirants->getExpirationsDans7Jours();
        Flight::render('GroupesViews/rappel_abonnement', ['abonnements' => $expirants]);
    }

    public function facture($id) {
        $pdf = new AbonnementModel();
        $pdf = $pdf->facturePDF($id);
        Flight::render('GroupesViews/facture_abonnement', ['message' => $pdf]);
    }

    public function historique() {
        $pdf = new AbonnementModel();
        $pdf = $pdf->historiquePDF();
        Flight::render('GroupesViews/historique_abonnement', ['message' => $pdf]);
    }
}
?>