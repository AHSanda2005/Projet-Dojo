<?php
namespace app\controllers;

use app\models\Presence;
use PDO;

class PresenceController {
    private $presenceModel;

    public function __construct(PDO $db) {
        $this->presenceModel = new Presence($db);
    }

    // Afficher toutes les présences
    public function index() {
        return $this->presenceModel->getAll();
    }

    // Enregistrer une présence
    public function store($data) {
        return $this->presenceModel->insert($data);
    }

    // Modifier une présence
    public function update($id, $data) {
        return $this->presenceModel->update($id, $data);
    }

    // Supprimer une présence
    public function delete($id) {
        return $this->presenceModel->delete($id);
    }

    // Vue feuille de présence pour une séance
    public function feuillePresence($id_seances) {
        return $this->presenceModel->getBySeance($id_seances);
    }

    // Obtenir les absences d'un élève
    public function absencesEleve($id_eleve) {
        return $this->presenceModel->getAbsencesByEleve($id_eleve);
    }

    public function absentsParDate($date_debut, $date_fin) {
        return $this->presenceModel->getAbsentByDate($date_debut, $date_fin);
    }

    
    public function presentsParDate($date_debut, $date_fin) {
        return $this->presenceModel->getPresentByDate($date_debut, $date_fin);
    }

    // Vérifier si l'annulation est possible pour une séance
    public function annulationPossible($id_seances) {
        return $this->presenceModel->annulationPossible($id_seances);
    }
}
?>
