<?php
namespace app\models\TarifEcolageModel;

use Flight;
use PDO;

class TarifEcolageModel {
    public function insert($montant, $type) {
        try {
            $db = Flight::db();
            $stmt = $db->prepare("INSERT INTO tarif_ecolage (montant, type) VALUES (:montant, :type)");
            $stmt->execute([':montant' => $montant, ':type' => $type]);
            return "Insertion réussie !";
        } catch (\PDOException $e) {
            return "Erreur : " . $e->getMessage();
        }
    }

   
    public function getAll() {
        try {
            $db = Flight::db();
            $stmt = $db->query("SELECT * FROM tarif_ecolage");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            return [];
        }
    }

    public function getById($id) {
        try {
            $db = Flight::db();
            $stmt = $db->prepare("SELECT * FROM tarif_ecolage WHERE id_tarif = :id");
            $stmt->execute([':id' => $id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            return null;
        }
    }


    public function delete($id) {
        try {
            $db = Flight::db();
            $stmt = $db->prepare("DELETE FROM tarif_ecolage WHERE id_tarif = :id");
            $stmt->execute([':id' => $id]);
            return $stmt->rowCount() > 0 ? "Suppression réussie." : "Aucun tarif trouvé.";
        } catch (\PDOException $e) {
            return "Erreur de suppression : " . $e->getMessage();
        }
    }

  
    public function update($id, $montant, $type) {
        try {
            $db = Flight::db();
            $stmt = $db->prepare("UPDATE tarif_ecolage SET montant = :montant, type = :type WHERE id_tarif = :id");
            $stmt->execute([':montant' => $montant, ':type' => $type, ':id' => $id]);
            return $stmt->rowCount() > 0 ? "Mise à jour réussie." : "Aucune modification effectuée.";
        } catch (\PDOException $e) {
            return "Erreur de mise à jour : " . $e->getMessage();
        }
    }

   
    public function getActivePrice($id) {
        try {
            $db = Flight::db();
            $stmt = $db->prepare("SELECT montant FROM tarif_ecolage WHERE id_tarif = :id AND actif = true");
            $stmt->execute([':id' => $id]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result ? $result['montant'] : null;
        } catch (\PDOException $e) {
            return null;
        }
    }


    public function calculateDiscount($id, $discountPercentage) {
        try {
            $tarif = $this->getById($id);
            if ($tarif && isset($tarif['montant'])) {
                $discount = ($tarif['montant'] * $discountPercentage) / 100;
                return $tarif['montant'] - $discount;
            }
            return null;
        } catch (\PDOException $e) {
            return null;
        }
    }
}