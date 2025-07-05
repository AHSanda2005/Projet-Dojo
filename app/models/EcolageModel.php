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

    public function resteEcolageApayer($id_eleve, $mois, $annee, $tarif_total) {
        $stmt = $this->db->prepare("
            SELECT COALESCE(SUM(montant), 0) AS total_paye
            FROM {$this->table}
            WHERE id_eleve = :id_eleve
              AND mois = :mois
              AND annee = :annee
        ");
    
        $stmt->execute([
            ':id_eleve' => $id_eleve,
            ':mois' => $mois,
            ':annee' => $annee
        ]);
    
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $total_paye = (float)$row['total_paye'];
        
        $reste = $tarif_total - $total_paye;
        return $reste > 0 ? round($reste, 2) : 0.0;
    }

    public function getDernierMoisPaye($id_eleve) {
        $stmt = $this->db->prepare("
            SELECT mois, annee
            FROM {$this->table}
            WHERE id_eleve = :id_eleve AND statut = 'paye'
            ORDER BY annee DESC, mois DESC
            LIMIT 1
        ");
        $stmt->execute([':id_eleve' => $id_eleve]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getProchainMoisA_Payer($id_eleve) {
        $dernier = $this->getDernierMoisPaye($id_eleve);
    
        if ($dernier && isset($dernier['mois']) && isset($dernier['annee'])) {
            $mois = (int)$dernier['mois'];
            $annee = (int)$dernier['annee'];
    
            if ($mois < 12) {
                return ['mois' => $mois + 1, 'annee' => $annee];
            } else {
                return ['mois' => 1, 'annee' => $annee + 1];
            }
        } else {
            // Aucun paiement trouvé, utiliser date_inscription
            $stmt = $this->db->prepare("SELECT date_inscription FROM eleve WHERE id_eleve = :id");
            $stmt->execute([':id' => $id_eleve]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
            if ($row && isset($row['date_inscription'])) {
                $date = new \DateTime($row['date_inscription']);
                return [
                    'mois' => (int)$date->format('m'),
                    'annee' => (int)$date->format('Y')
                ];
            } else {
                // Par sécurité : par défaut janvier année actuelle
                $now = new \DateTime();
                return ['mois' => 1, 'annee' => (int)$now->format('Y')];
            }
        }
    }
    

    public function checkSiEcolagePayeAvec($id_eleve, $mois, $annee, $tarif_total, $montant) {
        // Récupérer le montant déjà payé
        $stmt = $this->db->prepare("
            SELECT COALESCE(SUM(montant), 0) AS total_paye
            FROM {$this->table}
            WHERE id_eleve = :id_eleve
              AND mois = :mois
              AND annee = :annee
        ");
    
        $stmt->execute([
            ':id_eleve' => $id_eleve,
            ':mois' => $mois,
            ':annee' => $annee
        ]);
    
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $total_paye = (float)$row['total_paye'];
    
        // Addition du montant en cours
        $somme = $total_paye + $montant;
    
        // Vérifie si on atteint exactement le tarif
        return abs($somme - $tarif_total) < 0.01; // tolérance d'arrondi
    }

    public function create($data) {
        $isAdult = true;
        $tarif = $this->getTarif($isAdult);
    
        // 1. Insérer d'abord avec statut temporaire
        $stmt = $this->db->prepare("
            INSERT INTO {$this->table} 
            (id_eleve, montant, date_paiement, mois, annee, statut) 
            VALUES (:id_eleve, :montant, :date_paiement, :mois, :annee, 'non paye')
        ");
        $stmt->execute([
            ':id_eleve' => $data['id_eleve'],
            ':montant' => $data['montant'],
            ':date_paiement' => date('Y-m-d H:i:s'),
            ':mois' => $data['mois'],
            ':annee' => $data['annee']
        ]);
    
        // 2. Vérifier si le paiement est maintenant complet
        $stmt2 = $this->db->prepare("
            SELECT COALESCE(SUM(montant), 0) AS total_paye
            FROM {$this->table}
            WHERE id_eleve = :id_eleve
              AND mois = :mois
              AND annee = :annee
        ");
        $stmt2->execute([
            ':id_eleve' => $data['id_eleve'],
            ':mois' => $data['mois'],
            ':annee' => $data['annee']
        ]);
        $row = $stmt2->fetch(PDO::FETCH_ASSOC);
        $somme = (float)$row['total_paye'];
    
        // 3. Si paiement complet => update toutes les lignes du mois à "paye"
        if (abs($somme - $tarif) < 0.01) {
            $stmt3 = $this->db->prepare("
                UPDATE {$this->table}
                SET statut = 'paye'
                WHERE id_eleve = :id_eleve
                  AND mois = :mois
                  AND annee = :annee
            ");
            $stmt3->execute([
                ':id_eleve' => $data['id_eleve'],
                ':mois' => $data['mois'],
                ':annee' => $data['annee']
            ]);
        }
    
        return true;
    }
    

    public function isEcolagePaye($id_eleve, $mois, $annee) {
        $stmt = $this->db->prepare("
            SELECT COUNT(*) AS nb
            FROM {$this->table}
            WHERE id_eleve = :id_eleve
              AND mois = :mois
              AND annee = :annee
              AND statut = 'paye'
        ");
    
        $stmt->execute([
            ':id_eleve' => $id_eleve,
            ':mois' => $mois,
            ':annee' => $annee
        ]);
    
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row && $row['nb'] > 0;
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
