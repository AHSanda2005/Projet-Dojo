<?php

namespace app\models\GroupeModels;

use PDO;
use Flight;

class ReservationModel {

    public function insert($id_club, $date_reservation, $date_reserve, $heure_debut, $heure_fin) {
        try {
            $db = Flight::db();
            $stmt = $db->prepare("
                INSERT INTO reservation (id_club, date_reservation, date_reserve, heure_debut, heure_fin)
                VALUES (:id_club, :date_reservation, :date_reserve, :heure_debut, :heure_fin)
            ");
            $stmt->execute([
                ':id_club' => $id_club,
                ':date_reservation' => $date_reservation,
                ':date_reserve' => $date_reserve,
                ':heure_debut' => $heure_debut,
                ':heure_fin' => $heure_fin,
            ]);
            return "Réservation enregistrée avec succès.";
        } catch (\PDOException $e) {
            return "Erreur d'insertion : " . $e->getMessage();
        }
    }

    public function getAll() {
        try {
            $db = Flight::db();
            $stmt = $db->query("SELECT * FROM reservation");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            return [];
        }
    }

    public function getById($id) {
        try {
            $db = Flight::db();
            $stmt = $db->prepare("SELECT * FROM reservation WHERE id_reservation = :id");
            $stmt->execute([':id' => $id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            return null;
        }
    }

    public function update($id, $id_club, $date_reservation, $date_reserve, $heure_debut, $heure_fin) {
        try {
            $db = Flight::db();
            $stmt = $db->prepare("
                UPDATE reservation SET 
                    id_club = :id_club, 
                    date_reservation = :date_reservation, 
                    date_reserve = :date_reserve, 
                    heure_debut = :heure_debut, 
                    heure_fin = :heure_fin 
                WHERE id_reservation = :id
            ");
            $stmt->execute([
                ':id' => $id,
                ':id_club' => $id_club,
                ':date_reservation' => $date_reservation,
                ':date_reserve' => $date_reserve,
                ':heure_debut' => $heure_debut,
                ':heure_fin' => $heure_fin,
            ]);
            return "Mise à jour réussie.";
        } catch (\PDOException $e) {
            return "Erreur de mise à jour : " . $e->getMessage();
        }
    }

    public function delete($id) {
        try {
            $db = Flight::db();
            $stmt = $db->prepare("DELETE FROM reservation WHERE id_reservation = :id");
            $stmt->execute([':id' => $id]);
            return "Suppression réussie.";
        } catch (\PDOException $e) {
            return "Erreur de suppression : " . $e->getMessage();
        }
    }
}
