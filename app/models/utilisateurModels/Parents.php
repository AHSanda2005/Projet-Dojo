<?php

namespace app\models\utilisateurModels;

use PDO;
use PDOException;
use Exception;
use Flight;

class Parents
{
    private $id_parent;
    private $nom;
    private $prenom;
    private $contact;
    private $adresse;
    private $db;

    public function __construct()
    {
        $config = Flight::get('config');
        $database = new Database($config['database']);
        $this->db = $database->getConnection();
    }

    // Getters
    public function getIdParent(): int
    {
        return $this->id_parent;
    }

    public function getNom(): string
    {
        return $this->nom;
    }

    public function getPrenom(): string
    {
        return $this->prenom;
    }

    public function getContact(): string
    {
        return $this->contact;
    }

    public function getAdresse(): string
    {
        return $this->adresse;
    }

    // Setters
    public function setNom(string $nom): void
    {
        $this->nom = $nom;
    }

    public function setPrenom(string $prenom): void
    {
        $this->prenom = $prenom;
    }

    public function setContact(string $contact): void
    {
        $this->contact = $contact;
    }

    public function setAdresse(string $adresse): void
    {
        $this->adresse = $adresse;
    }

    public function create(): bool
    {
        try {
            $stmt = $this->db->prepare("
                INSERT INTO parent 
                (nom, prenom, contact, adresse) 
                VALUES (:nom, :prenom, :contact, :adresse)
                RETURNING id_parent
            ");

            $stmt->bindParam(':nom', $this->nom);
            $stmt->bindParam(':prenom', $this->prenom);
            $stmt->bindParam(':contact', $this->contact);
            $stmt->bindParam(':adresse', $this->adresse);

            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->id_parent = $result['id_parent'];

            return true;
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la création du parent: " . $e->getMessage());
        }
    }

    public function update(): bool
    {
        try {
            $stmt = $this->db->prepare("
                UPDATE parent SET
                nom = :nom,
                prenom = :prenom,
                contact = :contact,
                adresse = :adresse
                WHERE id_parent = :id_parent
            ");

            $stmt->bindParam(':nom', $this->nom);
            $stmt->bindParam(':prenom', $this->prenom);
            $stmt->bindParam(':contact', $this->contact);
            $stmt->bindParam(':adresse', $this->adresse);
            $stmt->bindParam(':id_parent', $this->id_parent, PDO::PARAM_INT);

            return $stmt->execute();
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la mise à jour du parent: " . $e->getMessage());
        }
    }

    public function delete(): bool
    {
        try {
            // Vérifier si le parent est utilisé dans la table parent_eleve
            $stmt = $this->db->prepare("SELECT COUNT(*) FROM parent_eleve WHERE id_parent = :id");
            $stmt->bindParam(':id', $this->id_parent, PDO::PARAM_INT);
            $stmt->execute();

            if ($stmt->fetchColumn() > 0) {
                throw new Exception("Impossible de supprimer, le parent est lié à un ou plusieurs élèves");
            }

            $stmt = $this->db->prepare("DELETE FROM parent WHERE id_parent = :id");
            $stmt->bindParam(':id', $this->id_parent, PDO::PARAM_INT);

            return $stmt->execute();
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la suppression du parent: " . $e->getMessage());
        }
    }

    public static function getById(int $id): ?Parents
    {
        try {
            $config = Flight::get('config');
            $database = new Database($config['database']);
            $db = $database->getConnection();

            $stmt = $db->prepare("
                SELECT * FROM parent
                WHERE id_parent = :id
            ");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            $data = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($data) {
                $parent = new Parents();
                $parent->id_parent = $data['id_parent'];
                $parent->nom = $data['nom'];
                $parent->prenom = $data['prenom'];
                $parent->contact = $data['contact'];
                $parent->adresse = $data['adresse'];

                return $parent;
            }

            return null;
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la récupération du parent: " . $e->getMessage());
        }
    }

    public static function getAll(): array
    {
        try {
            $config = Flight::get('config');
            $database = new Database($config['database']);
            $db = $database->getConnection();

            $stmt = $db->prepare("
                SELECT * FROM parent
                ORDER BY nom, prenom
            ");
            $stmt->execute();

            $parents = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $parent = new Parents();
                $parent->id_parent = $row['id_parent'];
                $parent->nom = $row['nom'];
                $parent->prenom = $row['prenom'];
                $parent->contact = $row['contact'];
                $parent->adresse = $row['adresse'];

                $parents[] = $parent;
            }

            return $parents;
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la récupération des parents: " . $e->getMessage());
        }
    }

    public static function search(string $term): array
    {
        try {
            $config = Flight::get('config');
            $database = new Database($config['database']);
            $db = $database->getConnection();

            $stmt = $db->prepare("
                SELECT * FROM parent
                WHERE nom ILIKE :term OR prenom ILIKE :term
                ORDER BY nom, prenom
            ");
            $searchTerm = '%' . $term . '%';
            $stmt->bindParam(':term', $searchTerm);
            $stmt->execute();

            $parents = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $parent = new Parents();
                $parent->id_parent = $row['id_parent'];
                $parent->nom = $row['nom'];
                $parent->prenom = $row['prenom'];
                $parent->contact = $row['contact'];
                $parent->adresse = $row['adresse'];

                $parents[] = $parent;
            }

            return $parents;
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la recherche des parents: " . $e->getMessage());
        }
    }

    public static function countAll(): int
    {
        try {
            $config = Flight::get('config');
            $database = new Database($config['database']);
            $db = $database->getConnection();

            $stmt = $db->prepare("SELECT COUNT(*) FROM parent");
            $stmt->execute();
            return (int) $stmt->fetchColumn();
        } catch (PDOException $e) {
            throw new Exception("Erreur lors du comptage des parents: " . $e->getMessage());
        }
    }
}