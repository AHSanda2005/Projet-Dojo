<?php

namespace app\models;

use PDO;
use Flight;

class PaiementModel {
    protected $db;
    protected $table = 'paiement';

    public function __construct($db) {
        $this->db = $db;
    }

    //Create
    public function create($data) {
        $stmt = $this->db->prepare("
            INSERT INTO {$this->table} (id_groupe, montant, date_paiement)
            VALUES (:id_groupe, :montant, :date_paiement)
        ");
        return $stmt->execute([
            ':id_groupe' => $data['id_groupe'],
            ':montant' => $data['montant'],
            ':date_paiement' => date('Y-m-d H:i:s') // Date courante
        ]);
    }

    //Read - All
    public function getAll() {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} ORDER BY date_paiement DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    //Read - By ID
    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id_payement = :id LIMIT 1");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    //Update
    public function update($id, $data) {
        $stmt = $this->db->prepare("
            UPDATE {$this->table}
            SET id_groupe = :id_groupe,
                montant = :montant,
                date_paiement = :date_paiement
            WHERE id_payement = :id
        ");
        return $stmt->execute([
            ':id' => $id,
            ':id_groupe' => $data['id_groupe'],
            ':montant' => $data['montant'],
            ':date_paiement' => $data['date_paiement']
        ]);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE id_payement = :id");
        return $stmt->execute([':id' => $id]);
    }

    public function getAllByGroupe($id_groupe) {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id_groupe = :id_groupe ORDER BY date_paiement DESC");
        $stmt->execute([':id_groupe' => $id_groupe]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

?>
