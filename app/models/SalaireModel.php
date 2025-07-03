<?php

namespace app\models;

use Flight;
use PDO;

class SalaireModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getAllProf() {
        $sql = "SELECT *, 'Prof' AS profession FROM prof";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }
    
    public function getAllSuperviseur() {
        $sql = "SELECT *, 'Superviseur' AS profession FROM superviseur";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }
    
    public function getAllPersonnel() {
        $profs = $this->getAllProf();
        $superviseurs = $this->getAllSuperviseur();
        
        return array_merge($profs, $superviseurs);
    }

    public function insertSalaire($data) {
        $sql = "INSERT INTO paiement_salaire(id_personnel,type_personnel,montant,mois_paye,date_paiement) VALUES(?,?,?,?,NOW())";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$data[''],$data[''],$data[''],$data['']]);
    }

}
