<?php

namespace app\models;

use PDO;
use Flight;

class EcolageModel {
    private $db;
    private $table = 'ecolage';

    public function __construct($db) {
        $this->db = $db;
    }

    // deplacer dans model tarif
    public function getTarif(bool $adult): ?float {
        $stmt = $this->db->prepare("
            SELECT montant 
            FROM tarif_ecolage 
            WHERE adult = :adult
            LIMIT 1
        ");
        $stmt->execute([':adult' => $adult ? 'true' : 'false']);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
        return $result ? (float)$result['montant'] : null;
    }

    // deplacer dans model eleve
    public function find($id) {
        $stmt = $this->db->prepare("
            SELECT e.*, g.label as genre 
            FROM eleve e
            JOIN genre g ON e.id_genre = g.id_genre
            WHERE e.id_eleve = :id
        ");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAllPaiement(int $id_eleve): array {
        $stmt = $this->db->prepare("
            SELECT id_ecolage, montant, date_paiement, mois, annee, statut
            FROM ecolage
            WHERE id_eleve = :id_eleve
            ORDER BY date_paiement DESC
        ");
        $stmt->execute([':id_eleve' => $id_eleve]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
   

    public function insert($data) {
        $stmt = $this->db->prepare("
            INSERT INTO {$this->table} 
            (id_eleve, montant, date_paiement, mois, annee, statut) 
            VALUES (:id_eleve, :montant, :date_paiement, :mois, :annee, :statut)
        ");
        
        return $stmt->execute([
            ':id_eleve' => $data['id_eleve'],
            ':montant' => $data['montant'],
            ':date_paiement' => date('Y-m-d H:i:s'), // Date courante
            ':mois' => $data['mois'],
            ':annee' => $data['annee'],
            ':statut' => 'paye'
        ]);
    }

     
    // public function updateStatutEnPaye($idEcolage) {
    //     $stmt = $this->db->prepare("
    //         UPDATE {$this->table}
    //         SET statut = 'paye'
    //         WHERE id_ecolage = :id_ecolage
    //     ");
    
    //     return $stmt->execute([
    //         ':id_ecolage' => $idEcolage
    //     ]);
    // }
    
 
    // public function getDernierEcolageNonPaye($id_eleve) {
    //     $sql = "SELECT mois, annee 
    //             FROM ecolage 
    //             WHERE id_eleve = :id_eleve AND statut = 'non paye'
    //             ORDER BY annee, mois
    //             LIMIT 1";
    //     $stmt = $this->db->prepare($sql);
    //     $stmt->execute(['id_eleve' => $id_eleve]);
    //     return $stmt->fetch(PDO::FETCH_ASSOC) ?: ['mois' => date('n'), 'annee' => date('Y')];
    // }

}


?>
