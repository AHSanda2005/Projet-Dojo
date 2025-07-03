<?php
namespace app\models;

use Flight;
use PDO;

class TarifClubModel {
    protected $db;
    protected $table = 'reservation';

    public function __construct($db) {
        $this->db = $db;
    }

    public function insert($montant_par_heure) {
        try {
            $stmt = $this->db->prepare("INSERT INTO tarif_club (montant_par_heure) VALUES (:montant)");
            $stmt->execute([':montant' => $montant_par_heure]);
            return "Insertion réussie !";
        } catch (\PDOException $e) {
            return "Erreur : " . $e->getMessage();
        }
    }

    public function getAll() {
        try {
            $stmt = $this->db->query("SELECT * FROM tarif_club");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            return [];
        }
    }

    public function getById($id) {
        try {
            $stmt = $this->db->prepare("SELECT * FROM tarif_club WHERE id_tarif = :id");
            $stmt->execute([':id' => $id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            return null;
        }
    }

    public function delete($id) {
        try {
            $stmt = $this->db->prepare("DELETE FROM tarif_club WHERE id_tarif = :id");
            $stmt->execute([':id' => $id]);
            return $stmt->rowCount() > 0 ? "Suppression réussie." : "Aucun tarif trouvé.";
        } catch (\PDOException $e) {
            return "Erreur de suppression : " . $e->getMessage();
        }
    }

    public function update($id, $montant_par_heure) {
        try {
            $stmt = $this->db->prepare("UPDATE tarif_club SET montant_par_heure = :montant WHERE id_tarif = :id");
            $stmt->execute([':montant' => $montant_par_heure, ':id' => $id]);
            return $stmt->rowCount() > 0 ? "Mise à jour réussie." : "Aucune modification effectuée.";
        } catch (\PDOException $e) {
            return "Erreur de mise à jour : " . $e->getMessage();
        }
    }
    /**
     * Récupère le taux horaire pour un tarif club.
     */
    public function getHourlyRate($id) {
        $tarif = $this->getById($id);
        return $tarif ? $tarif['montant_par_heure'] : null;
    }
    /**
     * Calcule le prix total pour un groupe basé sur la taille du groupe et le taux horaire.
     */
    public function calculateGroupPrice($id, $group_size) {
        $tarif = $this->getById($id);
        if ($tarif && $group_size > 0) {
            return $tarif['montant_par_heure'] * $group_size;
        }
        return null;
    }
}