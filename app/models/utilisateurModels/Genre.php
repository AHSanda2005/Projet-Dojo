<?php

namespace app\models\utilisateurModels;

use app\models\utilisateurModels\Database;
use PDO;
use PDOException;
use Flight;
use Exception;

class Genre {
    private $db;
    private $id;
    private $label;

    public function __construct($id = null, $label = null) {
        $config = Flight::get('config');
        $database = new Database($config['database']);
        $this->db = $database->getConnection();
        
        $this->id = $id;
        $this->label = $label;
    }

    // Getters
    public function getId() {
        return $this->id;
    }

    public function getLabel() {
        return $this->label;
    }

    // Setters
    public function setLabel($label) {
        $this->label = $label;
    }

    // Méthodes de persistence
    public function save() {
        if ($this->id) {
            return $this->update();
        } else {
            return $this->create();
        }
    }

    private function create() {
        try {
            $stmt = $this->db->prepare("SELECT COUNT(*) FROM genre WHERE LOWER(label) = LOWER(:label)");
            $stmt->bindParam(':label', $this->label);
            $stmt->execute();
            
            if ($stmt->fetchColumn() > 0) {
                throw new Exception("Un genre avec ce nom existe déjà");
            }

            $stmt = $this->db->prepare("INSERT INTO genre (label) VALUES (:label) RETURNING id_genre");
            $stmt->bindParam(':label', $this->label);
            $stmt->execute();
            
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->id = $result['id_genre'];
            
            return true;
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la création du genre : " . $e->getMessage());
        }
    }

    private function update() {
        try {
            $stmt = $this->db->prepare("SELECT COUNT(*) FROM genre WHERE LOWER(label) = LOWER(:label) AND id_genre != :id");
            $stmt->bindParam(':label', $this->label);
            $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
            $stmt->execute();
            
            if ($stmt->fetchColumn() > 0) {
                throw new Exception("Un autre genre avec ce nom existe déjà");
            }

            $stmt = $this->db->prepare("UPDATE genre SET label = :label WHERE id_genre = :id");
            $stmt->bindParam(':label', $this->label);
            $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
            
            return $stmt->execute();
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la mise à jour du genre : " . $e->getMessage());
        }
    }

    public function delete() {
        try {
            $tables = ['superviseur', 'prof', 'eleve'];
            foreach ($tables as $table) {
                $stmt = $this->db->prepare("SELECT COUNT(*) FROM $table WHERE id_genre = :id");
                $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
                $stmt->execute();
                
                if ($stmt->fetchColumn() > 0) {
                    throw new Exception("Impossible de supprimer ce genre car il est utilisé dans la table $table");
                }
            }

            $stmt = $this->db->prepare("DELETE FROM genre WHERE id_genre = :id");
            $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
            
            return $stmt->execute();
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la suppression du genre : " . $e->getMessage());
        }
    }

    public static function getAll() {
        try {
            $config = Flight::get('config');
            $database = new Database($config['database']);
            $db = $database->getConnection();

            $stmt = $db->prepare("SELECT * FROM genre ORDER BY id_genre ASC");
            $stmt->execute();
            
            $genres = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $genres[] = new Genre($row['id_genre'], $row['label']);
            }
            
            return $genres;
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la récupération des genres : " . $e->getMessage());
        }
    }

    public static function getById($id) {
        try {
            $config = Flight::get('config');
            $database = new Database($config['database']);
            $db = $database->getConnection();

            $stmt = $db->prepare("SELECT * FROM genre WHERE id_genre = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($row) {
                return new Genre($row['id_genre'], $row['label']);
            }
            
            return null;
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la récupération du genre : " . $e->getMessage());
        }
    }

    public static function countAll() {
        try {
            $config = Flight::get('config');
            $database = new Database($config['database']);
            $db = $database->getConnection();

            $stmt = $db->prepare("SELECT COUNT(*) FROM genre");
            $stmt->execute();
            return $stmt->fetchColumn();
        } catch (PDOException $e) {
            throw new Exception("Erreur lors du comptage des genres : " . $e->getMessage());
        }
    }

    public static function search($searchTerm) {
        try {
            $config = Flight::get('config');
            $database = new Database($config['database']);
            $db = $database->getConnection();

            $stmt = $db->prepare("SELECT * FROM genre WHERE label ILIKE :search ORDER BY label ASC");
            $search = '%' . $searchTerm . '%';
            $stmt->bindParam(':search', $search);
            $stmt->execute();
            
            $genres = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $genres[] = new Genre($row['id_genre'], $row['label']);
            }
            
            return $genres;
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la recherche des genres : " . $e->getMessage());
        }
    }
}