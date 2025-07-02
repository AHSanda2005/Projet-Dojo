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
    
    public function create($data) {
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

    public function getAll() {
        $stmt = $this->db->query("SELECT * FROM {$this->table} ORDER BY annee DESC, mois DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id_ecolage = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id, $data) {
        $stmt = $this->db->prepare("
            UPDATE {$this->table}
            SET id_eleve = :id_eleve, montant = :montant, date_paiement = :date_paiement,
                mois = :mois, annee = :annee, statut = :statut
            WHERE id_ecolage = :id
        ");
        return $stmt->execute([
            ':id' => $id,
            ':id_eleve' => $data['id_eleve'],
            ':montant' => $data['montant'],
            ':date_paiement' => $data['date_paiement'],
            ':mois' => $data['mois'],
            ':annee' => $data['annee'],
            ':statut' => $data['statut']
        ]);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE id_ecolage = :id");
        return $stmt->execute([':id' => $id]);
    }

    // Avancé : Récupérer les paiements d’un élève
    public function getByEleve($id_eleve) {
        $stmt = $this->db->prepare("
            SELECT * FROM {$this->table}
            WHERE id_eleve = :id_eleve
            ORDER BY annee DESC, mois DESC
        ");
        $stmt->execute([':id_eleve' => $id_eleve]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
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

    public function getAllPaiementByEleve(int $id_eleve): array {
        $stmt = $this->db->prepare("
            SELECT id_ecolage, montant, date_paiement, mois, annee, statut
            FROM ecolage
            WHERE id_eleve = :id_eleve
            ORDER BY date_paiement DESC
        ");
        $stmt->execute([':id_eleve' => $id_eleve]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
   

    public function getEcolageByEleve($id_eleve) {
        $stmt = $this->db->prepare("
            SELECT * 
            FROM {$this->table} 
            WHERE id_eleve = :id_eleve
            ORDER BY annee DESC, mois DESC
        ");
        $stmt->execute([':id_eleve' => $id_eleve]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

     
    public function updateStatutEnPaye($idEcolage) {
        $stmt = $this->db->prepare("
            UPDATE {$this->table}
            SET statut = 'paye'
            WHERE id_ecolage = :id_ecolage
        ");
    
        return $stmt->execute([
            ':id_ecolage' => $idEcolage
        ]);
    }
    
 
    public function getDernierEcolageNonPaye($id_eleve) {
        $stmt = $this->db->prepare("
            SELECT *
            FROM {$this->table}
            WHERE id_eleve = :id_eleve
              AND statut = 'non paye'
            ORDER BY annee DESC, mois DESC
            LIMIT 1
        ");
        $stmt->execute([':id_eleve' => $id_eleve]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    

}


?>
