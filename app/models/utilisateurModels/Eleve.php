<?php

namespace app\models\utilisateurModels;

use PDO;
use PDOException;
use Exception;
use Flight;
class Eleve extends BaseUser
{

    private $id_eleve;

    public function __construct()
    {
        parent::__construct();
    }


    public function getIdEleve(): int
    {
        return $this->id_eleve;
    }

    public function create(): bool
    {
        try {
            $stmt = $this->db->prepare("
                INSERT INTO eleve 
                (nom, prenom, date_naissance, adresse, contact, id_genre) 
                VALUES (:nom, :prenom, :date_naissance, :adresse, :contact, :id_genre)
                RETURNING id_eleve
            ");

            $stmt->bindParam(':nom', $this->nom);
            $stmt->bindParam(':prenom', $this->prenom);
            $stmt->bindParam(':date_naissance', $this->dateNaissance);
            $stmt->bindParam(':adresse', $this->adresse);
            $stmt->bindParam(':contact', $this->contact);
            $stmt->bindParam(':id_genre', $this->idgenre, PDO::PARAM_INT);

            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->id_eleve = $result['id_eleve'];

            return true;
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la création de l'élève: " . $e->getMessage());
        }
    }


    public function update(): bool
    {
        try {
            $stmt = $this->db->prepare("
                UPDATE eleve SET
                nom = :nom,
                prenom = :prenom,
                date_naissance = :date_naissance,
                adresse = :adresse,
                contact = :contact,
                id_genre = :id_genre
                WHERE id_eleve = :id_eleve
            ");

            $stmt->bindParam(':nom', $this->nom);
            $stmt->bindParam(':prenom', $this->prenom);
            $stmt->bindParam(':date_naissance', $this->dateNaissance);
            $stmt->bindParam(':adresse', $this->adresse);
            $stmt->bindParam(':contact', $this->contact);
            $stmt->bindParam(':id_genre', $this->idgenre, PDO::PARAM_INT);
            $stmt->bindParam(':id_eleve', $this->id_eleve, PDO::PARAM_INT);

            return $stmt->execute();
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la mise à jour de l'élève: " . $e->getMessage());
        }
    }


    public function delete(): bool
    {
        try {
            // Vérifier si l'élève est utilisé dans d'autres tables
            $tables = ['evolution', 'ecolage', 'parent_eleve']; // Ajouter d'autres tables si nécessaire
            foreach ($tables as $table) {
                $stmt = $this->db->prepare("SELECT COUNT(*) FROM $table WHERE id_eleve = :id");
                $stmt->bindParam(':id', $this->id_eleve, PDO::PARAM_INT);
                $stmt->execute();

                if ($stmt->fetchColumn() > 0) {
                    throw new Exception("Impossible de supprimer, l'élève est utilisé dans la table $table");
                }
            }

            $stmt = $this->db->prepare("DELETE FROM eleve WHERE id_eleve = :id");
            $stmt->bindParam(':id', $this->id_eleve, PDO::PARAM_INT);

            return $stmt->execute();
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la suppression de l'élève: " . $e->getMessage());
        }
    }


    public static function getById(int $id): ?Eleve
    {
        try {
            $config = Flight::get('config');
            $database = new Database($config['database']);
            $db = $database->getConnection();

            $stmt = $db->prepare("
                SELECT e.*, g.label as genre_label 
                FROM eleve e
                LEFT JOIN genre g ON e.id_genre = g.id_genre
                WHERE e.id_eleve = :id
            ");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            $data = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($data) {
                $eleve = new Eleve();
                $eleve->id_eleve = $data['id_eleve'];
                $eleve->nom = $data['nom'];
                $eleve->prenom = $data['prenom'];
                $eleve->dateNaissance = $data['date_naissance'];
                $eleve->adresse = $data['adresse'];
                $eleve->contact = $data['contact'];
                $eleve->idgenre = $data['id_genre'];

                return $eleve;
            }

            return null;
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la récupération de l'élève: " . $e->getMessage());
        }
    }


    public static function getAll(): array
    {
        try {
            $config = Flight::get('config');
            $database = new Database($config['database']);
            $db = $database->getConnection();

            $stmt = $db->prepare("
                SELECT e.*, g.label as genre_label 
                FROM eleve e
                LEFT JOIN genre g ON e.id_genre = g.id_genre
                ORDER BY e.nom, e.prenom
            ");
            $stmt->execute();

            $eleves = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $eleve = new Eleve();
                $eleve->id_eleve = $row['id_eleve'];
                $eleve->nom = $row['nom'];
                $eleve->prenom = $row['prenom'];
                $eleve->dateNaissance = $row['date_naissance'];
                $eleve->adresse = $row['adresse'];
                $eleve->contact = $row['contact'];
                $eleve->idgenre = $row['id_genre'];

                $eleves[] = $eleve;
            }

            return $eleves;
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la récupération des élèves: " . $e->getMessage());
        }
    }


    public static function search(string $term): array
    {
        try {
            $config = Flight::get('config');
            $database = new Database($config['database']);
            $db = $database->getConnection();

            $stmt = $db->prepare("
                SELECT e.*, g.label as genre_label 
                FROM eleve e
                LEFT JOIN genre g ON e.id_genre = g.id_genre
                WHERE e.nom ILIKE :term OR e.prenom ILIKE :term
                ORDER BY e.nom, e.prenom
            ");
            $searchTerm = '%' . $term . '%';
            $stmt->bindParam(':term', $searchTerm);
            $stmt->execute();

            $eleves = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $eleve = new Eleve();
                $eleve->id_eleve = $row['id_eleve'];
                $eleve->nom = $row['nom'];
                $eleve->prenom = $row['prenom'];
                $eleve->dateNaissance = $row['date_naissance'];
                $eleve->adresse = $row['adresse'];
                $eleve->contact = $row['contact'];
                $eleve->idgenre = $row['id_genre'];

                $eleves[] = $eleve;
            }

            return $eleves;
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la recherche des élèves: " . $e->getMessage());
        }
    }

    public static function countAll(): int
    {
        try {
            $config = Flight::get('config');
            $database = new Database($config['database']);
            $db = $database->getConnection();

            $stmt = $db->prepare("SELECT COUNT(*) FROM eleve");
            $stmt->execute();
            return (int) $stmt->fetchColumn();
        } catch (PDOException $e) {
            throw new Exception("Erreur lors du comptage des élèves: " . $e->getMessage());
        }
    }
}