<?php

namespace app\models\utilisateurModels;

use PDO;
use PDOException;
use Exception;
use Flight;

class Prof extends BaseUser
{

    private $id_prof;

    public function __construct()
    {
        parent::__construct();
    }


    public function getIdProf(): int
    {
        return $this->id_prof;
    }

    public function create(): bool
    {
        try {
            $stmt = $this->db->prepare("
                INSERT INTO prof 
                (nom, prenom, date_naissance, adresse, contact, id_genre) 
                VALUES (:nom, :prenom, :date_naissance, :adresse, :contact, :id_genre)
                RETURNING id_prof
            ");

            $stmt->bindParam(':nom', $this->nom);
            $stmt->bindParam(':prenom', $this->prenom);
            $stmt->bindParam(':date_naissance', $this->dateNaissance);
            $stmt->bindParam(':adresse', $this->adresse);
            $stmt->bindParam(':contact', $this->contact);
            $stmt->bindParam(':id_genre', $this->idgenre, PDO::PARAM_INT);

            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->id_prof = $result['id_prof'];

            return true;
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la création du professeur: " . $e->getMessage());
        }
    }


    public function update(): bool
    {
        try {
            $stmt = $this->db->prepare("
                UPDATE prof SET
                nom = :nom,
                prenom = :prenom,
                date_naissance = :date_naissance,
                adresse = :adresse,
                contact = :contact,
                id_genre = :id_genre
                WHERE id_prof = :id_prof
            ");

            $stmt->bindParam(':nom', $this->nom);
            $stmt->bindParam(':prenom', $this->prenom);
            $stmt->bindParam(':date_naissance', $this->dateNaissance);
            $stmt->bindParam(':adresse', $this->adresse);
            $stmt->bindParam(':contact', $this->contact);
            $stmt->bindParam(':id_genre', $this->idgenre, PDO::PARAM_INT);
            $stmt->bindParam(':id_prof', $this->id_prof, PDO::PARAM_INT);

            return $stmt->execute();
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la mise à jour du professeur: " . $e->getMessage());
        }
    }


    public function delete(): bool
    {
        try {
            // Vérifier si le professeur est utilisé dans d'autres tables
            $tables = ['evolution']; // Ajouter d'autres tables si nécessaire
            foreach ($tables as $table) {
                $stmt = $this->db->prepare("SELECT COUNT(*) FROM $table WHERE id_prof = :id");
                $stmt->bindParam(':id', $this->id_prof, PDO::PARAM_INT);
                $stmt->execute();
                
                if ($stmt->fetchColumn() > 0) {
                    throw new Exception("Impossible de supprimer, le professeur est utilisé dans la table $table");
                }
            }

            $stmt = $this->db->prepare("DELETE FROM prof WHERE id_prof = :id");
            $stmt->bindParam(':id', $this->id_prof, PDO::PARAM_INT);
            
            return $stmt->execute();
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la suppression du professeur: " . $e->getMessage());
        }
    }


    public static function getById(int $id): ?Prof
    {
        try {
            $config = Flight::get('config');
            $database = new Database($config['database']);
            $db = $database->getConnection();

            $stmt = $db->prepare("
                SELECT p.*, g.label as genre_label 
                FROM prof p
                LEFT JOIN genre g ON p.id_genre = g.id_genre
                WHERE p.id_prof = :id
            ");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            $data = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($data) {
                $prof = new Prof();
                $prof->id_prof = $data['id_prof'];
                $prof->nom = $data['nom'];
                $prof->prenom = $data['prenom'];
                $prof->dateNaissance = $data['date_naissance'];
                $prof->adresse = $data['adresse'];
                $prof->contact = $data['contact'];
                $prof->idgenre = $data['id_genre'];
                
                return $prof;
            }

            return null;
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la récupération du professeur: " . $e->getMessage());
        }
    }

    public static function getAll(): array
    {
        try {
            $config = Flight::get('config');
            $database = new Database($config['database']);
            $db = $database->getConnection();

            $stmt = $db->prepare("
                SELECT p.*, g.label as genre_label 
                FROM prof p
                LEFT JOIN genre g ON p.id_genre = g.id_genre
                ORDER BY p.nom, p.prenom
            ");
            $stmt->execute();

            $profs = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $prof = new Prof();
                $prof->id_prof = $row['id_prof'];
                $prof->nom = $row['nom'];
                $prof->prenom = $row['prenom'];
                $prof->dateNaissance = $row['date_naissance'];
                $prof->adresse = $row['adresse'];
                $prof->contact = $row['contact'];
                $prof->idgenre = $row['id_genre'];
                
                $profs[] = $prof;
            }

            return $profs;
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la récupération des professeurs: " . $e->getMessage());
        }
    }

    public static function search(string $term): array
    {
        try {
            $config = Flight::get('config');
            $database = new Database($config['database']);
            $db = $database->getConnection();

            $stmt = $db->prepare("
                SELECT p.*, g.label as genre_label 
                FROM prof p
                LEFT JOIN genre g ON p.id_genre = g.id_genre
                WHERE p.nom ILIKE :term OR p.prenom ILIKE :term
                ORDER BY p.nom, p.prenom
            ");
            $searchTerm = '%' . $term . '%';
            $stmt->bindParam(':term', $searchTerm);
            $stmt->execute();

            $profs = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $prof = new Prof();
                $prof->id_prof = $row['id_prof'];
                $prof->nom = $row['nom'];
                $prof->prenom = $row['prenom'];
                $prof->dateNaissance = $row['date_naissance'];
                $prof->adresse = $row['adresse'];
                $prof->contact = $row['contact'];
                $prof->idgenre = $row['id_genre'];
                
                $profs[] = $prof;
            }

            return $profs;
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la recherche des professeurs: " . $e->getMessage());
        }
    }

    public static function countAll(): int
    {
        try {
            $config = Flight::get('config');
            $database = new Database($config['database']);
            $db = $database->getConnection();

            $stmt = $db->prepare("SELECT COUNT(*) FROM prof");
            $stmt->execute();
            return (int)$stmt->fetchColumn();
        } catch (PDOException $e) {
            throw new Exception("Erreur lors du comptage des professeurs: " . $e->getMessage());
        }
    }
}