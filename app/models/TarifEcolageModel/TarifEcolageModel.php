<?php
namespace app\models\TarifEcolageModel;

use Flight;
use PDO;

class TarifEcolageModel {

    // Insertion d'un nouvel abonnement
    public function insert($montant, $adult, $type_abonnement) {
        try {
            $db = Flight::db();
            $stmt = $db->prepare("INSERT INTO tarif_ecolage (montant, adult, type_abonnement) VALUES (:montant, :adult, :type_abonnement)");
            $stmt->execute([':montant' => $montant, ':adult' => $adult, ':type_abonnement' => $type_abonnement]);
            return "Insertion réussie !";
        } catch (\PDOException $e) {
            return "Erreur : " . $e->getMessage();
        }
    }

    // Récupérer tous les abonnements
    public function getAll() {
        try {
            $db = Flight::db();
            $stmt = $db->query("SELECT * FROM tarif_ecolage");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            return [];
        }
    }

    // Récupérer un abonnement par son ID
    public function getById($id) {
        try {
            $db = Flight::db();
            $stmt = $db->prepare("SELECT * FROM tarif_ecolage WHERE id = :id");
            $stmt->execute([':id' => $id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            return null;
        }
    }

    // Supprimer un abonnement
    public function delete($id) {
        try {
            $db = Flight::db();
            $stmt = $db->prepare("DELETE FROM tarif_ecolage WHERE id = :id");
            $stmt->execute([':id' => $id]);
            return $stmt->rowCount() > 0 ? "Suppression réussie." : "Aucun abonnement trouvé.";
        } catch (\PDOException $e) {
            return "Erreur de suppression : " . $e->getMessage();
        }
    }

    // Mettre à jour un abonnement
    public function update($id, $montant, $adult, $type_abonnement) {
        try {
            $db = Flight::db();
            $stmt = $db->prepare("UPDATE tarif_ecolage SET montant = :montant, adult = :adult, type_abonnement = :type_abonnement WHERE id = :id");
            $stmt->execute([':montant' => $montant, ':adult' => $adult, ':type_abonnement' => $type_abonnement, ':id' => $id]);
            return $stmt->rowCount() > 0 ? "Mise à jour réussie." : "Aucune modification effectuée.";
        } catch (\PDOException $e) {
            return "Erreur de mise à jour : " . $e->getMessage();
        }
    }

    // Méthode pour obtenir le prix actif en fonction de la durée
    public function getActivePrice($duration) {
        try {
            $db = Flight::db();
            $stmt = $db->prepare("SELECT montant FROM tarif_ecolage WHERE type_abonnement = :duration ORDER BY id DESC LIMIT 1");
            $stmt->execute([':duration' => $duration]);
            return $stmt->fetch(PDO::FETCH_ASSOC)['montant'];
        } catch (\PDOException $e) {
            return null;
        }
    }

    // Calculer le prix après réduction en fonction de la durée de l'abonnement
    public function calculateDiscount($duration, $price) {
        $discount = 0;
        if ($duration == '1 mois') {
            $discount = 0;  // Pas de réduction
        } elseif ($duration == '3 mois') {
            $discount = 0.05;  // 5% de réduction
        } elseif ($duration == '6 mois') {
            $discount = 0.10;  // 10% de réduction
        } elseif ($duration == '1 an') {
            $discount = 0.15;  // 15% de réduction
        }

        $finalPrice = $price * (1 - $discount);
        return $finalPrice;
    }
}
?>
