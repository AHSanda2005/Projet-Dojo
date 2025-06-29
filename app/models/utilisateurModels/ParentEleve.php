<?php

namespace app\models\utilisateurModels;

use PDO;
use PDOException;
use Exception;
use Flight;

class ParentEleve
{
    private $db;

    public function __construct()
    {
        $config = Flight::get('config');
        $database = new Database($config['database']);
        $this->db = $database->getConnection();
    }

    public static function getAllRelations(): array
    {
        try {
            $config = Flight::get('config');
            $database = new Database($config['database']);
            $db = $database->getConnection();
            
            $stmt = $db->prepare("
                SELECT pe.id, p.id_parent, p.nom as parent_nom, p.prenom as parent_prenom, 
                       e.id_eleve, e.nom as eleve_nom, e.prenom as eleve_prenom
                FROM parent_eleve pe
                JOIN parent p ON pe.id_parent = p.id_parent
                JOIN eleve e ON pe.id_eleve = e.id_eleve
                ORDER BY e.nom, e.prenom, p.nom, p.prenom
            ");
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la récupération des relations parent-élève: " . $e->getMessage());
        }
    }

    public static function searchRelations(string $term): array
    {
        try {
            $config = Flight::get('config');
            $database = new Database($config['database']);
            $db = $database->getConnection();
            
            $stmt = $db->prepare("
                SELECT pe.id, p.id_parent, p.nom as parent_nom, p.prenom as parent_prenom, 
                       e.id_eleve, e.nom as eleve_nom, e.prenom as eleve_prenom
                FROM parent_eleve pe
                JOIN parent p ON pe.id_parent = p.id_parent
                JOIN eleve e ON pe.id_eleve = e.id_eleve
                WHERE p.nom ILIKE :term OR p.prenom ILIKE :term OR e.nom ILIKE :term OR e.prenom ILIKE :term
                ORDER BY e.nom, e.prenom, p.nom, p.prenom
            ");
            $searchTerm = '%' . $term . '%';
            $stmt->bindParam(':term', $searchTerm);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la recherche des relations parent-élève: " . $e->getMessage());
        }
    }

    public static function getParentsForEleve(int $id_eleve): array
    {
        try {
            $config = Flight::get('config');
            $database = new Database($config['database']);
            $db = $database->getConnection();
            
            $stmt = $db->prepare("
                SELECT p.id_parent, p.nom, p.prenom
                FROM parent_eleve pe
                JOIN parent p ON pe.id_parent = p.id_parent
                WHERE pe.id_eleve = :id_eleve
            ");
            $stmt->bindParam(':id_eleve', $id_eleve, PDO::PARAM_INT);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la récupération des parents de l'élève: " . $e->getMessage());
        }
    }

    public static function relationExists(int $id_parent, int $id_eleve): bool
    {
        try {
            $config = Flight::get('config');
            $database = new Database($config['database']);
            $db = $database->getConnection();
            
            $stmt = $db->prepare("
                SELECT COUNT(*) 
                FROM parent_eleve 
                WHERE id_parent = :id_parent AND id_eleve = :id_eleve
            ");
            $stmt->bindParam(':id_parent', $id_parent, PDO::PARAM_INT);
            $stmt->bindParam(':id_eleve', $id_eleve, PDO::PARAM_INT);
            $stmt->execute();
            
            return $stmt->fetchColumn() > 0;
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la vérification de la relation: " . $e->getMessage());
        }
    }

    public static function createRelation(int $id_parent, int $id_eleve): bool
    {
        try {
            $config = Flight::get('config');
            $database = new Database($config['database']);
            $db = $database->getConnection();
            
            $stmt = $db->prepare("
                INSERT INTO parent_eleve (id_parent, id_eleve)
                VALUES (:id_parent, :id_eleve)
            ");
            $stmt->bindParam(':id_parent', $id_parent, PDO::PARAM_INT);
            $stmt->bindParam(':id_eleve', $id_eleve, PDO::PARAM_INT);
            
            return $stmt->execute();
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la création de la relation: " . $e->getMessage());
        }
    }

    public static function deleteRelation(int $id): bool
    {
        try {
            $config = Flight::get('config');
            $database = new Database($config['database']);
            $db = $database->getConnection();
            
            $stmt = $db->prepare("
                DELETE FROM parent_eleve 
                WHERE id = :id
            ");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            
            return $stmt->execute();
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la suppression de la relation: " . $e->getMessage());
        }
    }
}