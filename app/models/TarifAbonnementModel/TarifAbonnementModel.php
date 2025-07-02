<?php
namespace app\models\TarifAbonnementModel;

use Flight;
use PDO;

class TarifAbonnementModel {
    public function insert($montant) {
        try {
            $db = Flight::db();
            $stmt = $db->prepare("INSERT INTO tarif_abonnement (montant) VALUES (:montant)");
            $stmt->execute([':montant' => $montant]);
            return "Insertion réussie !";
        } catch (\PDOException $e) {
            return "Erreur : " . $e->getMessage();
        }
    }

    public function getAll() {
        try {
            $db = Flight::db();
            $stmt = $db->query("SELECT * FROM tarif_abonnement");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            return [];
        }
    }

    public function getById($id) {
        try {
            $db = Flight::db();
            $stmt = $db->prepare("SELECT * FROM tarif_abonnement WHERE id_tarif = :id");
            $stmt->execute([':id' => $id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            return null;
        }
    }

    public function delete($id) {
        try {
            $db = Flight::db();
            $stmt = $db->prepare("DELETE FROM tarif_abonnement WHERE id_tarif = :id");
            $stmt->execute([':id' => $id]);
            return $stmt->rowCount() > 0 ? "Suppression réussie." : "Aucun tarif trouvé.";
        } catch (\PDOException $e) {
            return "Erreur de suppression : " . $e->getMessage();
        }
    }

    public function update($id, $montant) {
        try {
            $db = Flight::db();
            $stmt = $db->prepare("UPDATE tarif_abonnement SET montant = :montant WHERE id_tarif = :id");
            $stmt->execute([':montant' => $montant, ':id' => $id]);
            return $stmt->rowCount() > 0 ? "Mise à jour réussie." : "Aucune modification effectuée.";
        } catch (\PDOException $e) {
            return "Erreur de mise à jour : " . $e->getMessage();
        }
    }
}
?>