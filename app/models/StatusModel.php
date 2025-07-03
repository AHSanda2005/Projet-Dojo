<?php

namespace app\models;

use PDO;
use Flight;

class StatusModel
{
    protected $db;
    protected $table = 'status';

    public function __construct($db) {
        $this->db = $db;
    }
    
    private array $valeursEnum = ['demande', 'confirme', 'payee', 'annule'];

    public function insert(int $id_reservation, string $valeur): string
    {
        if (!in_array($valeur, $this->valeursEnum)) {
            return "Erreur : valeur de statut invalide.";
        }

        try {
            $stmt = $this->db->prepare(
                "INSERT INTO status (id_reservation, valeur)
                 VALUES (:id_reservation, :valeur)"
            );
            $stmt->execute([
                ':id_reservation' => $id_reservation,
                ':valeur'         => $valeur
            ]);
            return "Insertion réussie !";
        } catch (\PDOException $e) {
            return "Erreur d’insertion : " . $e->getMessage();
        }
    }

    public function getAll(): array
    {
        try {
            $stmt = $this->db->query("SELECT * FROM status");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            return [];
        }
    }

    public function getById(int $id_status): ?array
    {
        try {
            $stmt = $this->db->prepare(
                "SELECT * FROM status WHERE id_status = :id_status"
            );
            $stmt->execute([':id_status' => $id_status]);
            return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
        } catch (\PDOException $e) {
            return null;
        }
    }

    public function getByIdReservation(int $id_reservation): ?array
    {
        try {
            $stmt = $this->db->prepare(
                "SELECT * FROM status WHERE id_reservation = :id_reservation"
            );
            $stmt->execute([':id_reservation' => $id_reservation]);
            return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
        } catch (\PDOException $e) {
            return null;
        }
    }

    public function delete(int $id_status): string
    {
        try {
            $stmt = $this->db->prepare(
                "DELETE FROM status WHERE id_status = :id_status"
            );
            $stmt->execute([':id_status' => $id_status]);

            return $stmt->rowCount() > 0
                ? "Suppression réussie."
                : "Aucun statut trouvé.";
        } catch (\PDOException $e) {
            return "Erreur de suppression : " . $e->getMessage();
        }
    }

    public function update(int $id_status, int $id_reservation, string $valeur): string
    {
        if (!in_array($valeur, $this->valeursEnum)) {
            return "Erreur : valeur de statut invalide.";
        }

        try {
            $stmt = $this->db->prepare(
                "UPDATE status
                   SET id_reservation = :id_reservation,
                       valeur         = :valeur
                 WHERE id_status      = :id_status"
            );
            $stmt->execute([
                ':id_reservation' => $id_reservation,
                ':valeur'         => $valeur,
                ':id_status'      => $id_status
            ]);

            return $stmt->rowCount() > 0
                ? "Mise à jour réussie."
                : "Aucune modification effectuée.";
        } catch (\PDOException $e) {
            return "Erreur de mise à jour : " . $e->getMessage();
        }
    }
    public function updateByReservation(int $id_reservation, string $valeur): string
    {
        if (!in_array($valeur, $this->valeursEnum, true)) {
            return "Erreur : valeur de statut invalide.";
        }

        try {
            $stmt = $this->db->prepare(
                "UPDATE status
                    SET valeur = :valeur
                  WHERE id_reservation = :id_reservation"
            );
            $stmt->execute([
                ':valeur'         => $valeur,
                ':id_reservation' => $id_reservation
            ]);

            return $stmt->rowCount() > 0
                ? "Statut mis à jour en « {$valeur} »."
                : "Aucun enregistrement trouvé pour cette réservation.";
        } catch (\PDOException $e) {
            return "Erreur de mise à jour : " . $e->getMessage();
        }
    }
}