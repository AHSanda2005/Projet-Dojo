<?php

namespace app\models\utilisateurModels;

use app\models\utilisateurModels\Database;
use PDO;
use PDOException;
use Flight;
use Exception;


class BaseUser
{

    protected $nom;
    protected $prenom;
    protected $dateNaissance;
    protected $adresse;
    protected $contact;
    protected $idgenre;
    protected $db;
    public function __construct()
    {
        $config = Flight::get('config');
        $database = new Database($config['database']);
        $this->db = $database->getConnection();
    }

    // Getters
    public function getNom(): string
    {
        return $this->nom;
    }

    public function getPrenom(): string
    {
        return $this->prenom;
    }

    public function getDateNaissance(): string
    {
        return $this->dateNaissance;
    }

    public function getAdresse(): string
    {
        return $this->adresse;
    }

    public function getContact(): string
    {
        return $this->contact;
    }

    public function getIdGenre(): int
    {
        return $this->idgenre;
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

    public function setDateNaissance(string $dateNaissance): void
    {
        $this->dateNaissance = $dateNaissance;
    }

    public function setAdresse(string $adresse): void
    {
        $this->adresse = $adresse;
    }

    public function setContact(string $contact): void
    {
        $this->contact = $contact;
    }

    public function setIdGenre(int $idgenre): void
    {
        $this->idgenre = $idgenre;
    }
}