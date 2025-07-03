<?php

namespace app\models\utilisateurModels;

use PDO;
use PDOException;
use Exception;
use Flight;

class Superviseur extends BaseUser
{

    private $id_superviseur;

    public function __construct()
    {
        parent::__construct();
    }

    public function getIdSuperviseur(): int
    {
        return $this->id_superviseur;
    }


    public function create(): bool
    {
        try {
            $stmt = $this->db->prepare("
                INSERT INTO superviseur 
                (nom, prenom, date_naissance, adresse, contact, id_genre) 
                VALUES (:nom, :prenom, :date_naissance, :adresse, :contact, :id_genre)
                RETURNING id_superviseur
            ");

            $stmt->bindParam(':nom', $this->nom);
            $stmt->bindParam(':prenom', $this->prenom);
            $stmt->bindParam(':date_naissance', $this->dateNaissance);
            $stmt->bindParam(':adresse', $this->adresse);
            $stmt->bindParam(':contact', $this->contact);
            $stmt->bindParam(':id_genre', $this->idgenre, PDO::PARAM_INT);

            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->id_superviseur = $result['id_superviseur'];

            return true;
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la création du superviseur: " . $e->getMessage());
        }
    }


    public function update(): bool
    {
        try {
            $stmt = $this->db->prepare("
                UPDATE superviseur SET
                nom = :nom,
                prenom = :prenom,
                date_naissance = :date_naissance,
                adresse = :adresse,
                contact = :contact,
                id_genre = :id_genre
                WHERE id_superviseur = :id_superviseur
            ");

            $stmt->bindParam(':nom', $this->nom);
            $stmt->bindParam(':prenom', $this->prenom);
            $stmt->bindParam(':date_naissance', $this->dateNaissance);
            $stmt->bindParam(':adresse', $this->adresse);
            $stmt->bindParam(':contact', $this->contact);
            $stmt->bindParam(':id_genre', $this->idgenre, PDO::PARAM_INT);
            $stmt->bindParam(':id_superviseur', $this->id_superviseur, PDO::PARAM_INT);

            return $stmt->execute();
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la mise à jour du superviseur: " . $e->getMessage());
        }
    }


    public function delete(): bool
    {
        try {
            // Vérifier si le superviseur est utilisé dans d'autres tables
            $tables = ['historique_garde', 'suivi_salle'];
            foreach ($tables as $table) {
                $stmt = $this->db->prepare("SELECT COUNT(*) FROM $table WHERE id_superviseur = :id");
                $stmt->bindParam(':id', $this->id_superviseur, PDO::PARAM_INT);
                $stmt->execute();
                
                if ($stmt->fetchColumn() > 0) {
                    throw new Exception("Impossible de supprimer, le superviseur est utilisé dans la table $table");
                }
            }

            $stmt = $this->db->prepare("DELETE FROM superviseur WHERE id_superviseur = :id");
            $stmt->bindParam(':id', $this->id_superviseur, PDO::PARAM_INT);
            
            return $stmt->execute();
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la suppression du superviseur: " . $e->getMessage());
        }
    }


    public static function getById(int $id): ?Superviseur
    {
        try {
            $config = Flight::get('config');
            $database = new Database($config['database']);
            $db = $database->getConnection();

            $stmt = $db->prepare("
                SELECT s.*, g.label as genre_label 
                FROM superviseur s
                LEFT JOIN genre g ON s.id_genre = g.id_genre
                WHERE s.id_superviseur = :id
            ");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            $data = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($data) {
                $superviseur = new Superviseur();
                $superviseur->id_superviseur = $data['id_superviseur'];
                $superviseur->nom = $data['nom'];
                $superviseur->prenom = $data['prenom'];
                $superviseur->dateNaissance = $data['date_naissance'];
                $superviseur->adresse = $data['adresse'];
                $superviseur->contact = $data['contact'];
                $superviseur->idgenre = $data['id_genre'];
                
                return $superviseur;
            }

            return null;
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la récupération du superviseur: " . $e->getMessage());
        }
    }


    public static function getAll(): array
    {
        try {
            $config = Flight::get('config');
            $database = new Database($config['database']);
            $db = $database->getConnection();

            $stmt = $db->prepare("
                SELECT s.*, g.label as genre_label 
                FROM superviseur s
                LEFT JOIN genre g ON s.id_genre = g.id_genre
                ORDER BY s.nom, s.prenom
            ");
            $stmt->execute();

            $superviseurs = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $superviseur = new Superviseur();
                $superviseur->id_superviseur = $row['id_superviseur'];
                $superviseur->nom = $row['nom'];
                $superviseur->prenom = $row['prenom'];
                $superviseur->dateNaissance = $row['date_naissance'];
                $superviseur->adresse = $row['adresse'];
                $superviseur->contact = $row['contact'];
                $superviseur->idgenre = $row['id_genre'];
                
                $superviseurs[] = $superviseur;
            }

            return $superviseurs;
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la récupération des superviseurs: " . $e->getMessage());
        }
    }


    public static function search(string $term): array
    {
        try {
            $config = Flight::get('config');
            $database = new Database($config['database']);
            $db = $database->getConnection();

            $stmt = $db->prepare("
                SELECT s.*, g.label as genre_label 
                FROM superviseur s
                LEFT JOIN genre g ON s.id_genre = g.id_genre
                WHERE s.nom ILIKE :term OR s.prenom ILIKE :term
                ORDER BY s.nom, s.prenom
            ");
            $searchTerm = '%' . $term . '%';
            $stmt->bindParam(':term', $searchTerm);
            $stmt->execute();

            $superviseurs = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $superviseur = new Superviseur();
                $superviseur->id_superviseur = $row['id_superviseur'];
                $superviseur->nom = $row['nom'];
                $superviseur->prenom = $row['prenom'];
                $superviseur->dateNaissance = $row['date_naissance'];
                $superviseur->adresse = $row['adresse'];
                $superviseur->contact = $row['contact'];
                $superviseur->idgenre = $row['id_genre'];
                
                $superviseurs[] = $superviseur;
            }

            return $superviseurs;
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la recherche des superviseurs: " . $e->getMessage());
        }
    }


    public static function countAll(): int
    {
        try {
            $config = Flight::get('config');
            $database = new Database($config['database']);
            $db = $database->getConnection();

            $stmt = $db->prepare("SELECT COUNT(*) FROM superviseur");
            $stmt->execute();
            return (int)$stmt->fetchColumn();
        } catch (PDOException $e) {
            throw new Exception("Erreur lors du comptage des superviseurs: " . $e->getMessage());
        }
    }
}