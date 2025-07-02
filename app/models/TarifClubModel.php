<?php
namespace app\models;

use Flight;
use PDO;

class TarifClubModel {
    public function insert($montant_par_heure) {
        try {
            $db = Flight::db();
            $stmt = $db->prepare("INSERT INTO tarif_club (montant_par_heure) VALUES (:montant)");
            $stmt->execute([':montant' => $montant_par_heure]);
            return "Insertion réussie !";
        } catch (\PDOException $e) {
            return "Erreur : " . $e->getMessage();
        }
    }

    public function getAll() {
        try {
            $db = Flight::db();
            $stmt = $db->query("SELECT * FROM tarif_club");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            return [];
        }
    }

    public function getById($id) {
        try {
            $db = Flight::db();
            $stmt = $db->prepare("SELECT * FROM tarif_club WHERE id_tarif = :id");
            $stmt->execute([':id' => $id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            return null;
        }
    }

    public function delete($id) {
        try {
            $db = Flight::db();
            $stmt = $db->prepare("DELETE FROM tarif_club WHERE id_tarif = :id");
            $stmt->execute([':id' => $id]);
            return $stmt->rowCount() > 0 ? "Suppression réussie." : "Aucun tarif trouvé.";
        } catch (\PDOException $e) {
            return "Erreur de suppression : " . $e->getMessage();
        }
    }

    public function update($id, $montant_par_heure) {
        try {
            $db = Flight::db();
            $stmt = $db->prepare("UPDATE tarif_club SET montant_par_heure = :montant WHERE id_tarif = :id");
            $stmt->execute([':montant' => $montant_par_heure, ':id' => $id]);
            return $stmt->rowCount() > 0 ? "Mise à jour réussie." : "Aucune modification effectuée.";
        } catch (\PDOException $e) {
            return "Erreur de mise à jour : " . $e->getMessage();
        }
    }
}