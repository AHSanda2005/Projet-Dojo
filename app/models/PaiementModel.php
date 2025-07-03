<?php
namespace app\models;
use PDO;
use Flight;
use app\models\TarifClubModel;
class PaiementModel {
    protected $db;
    protected $table = 'paiement';

    public function __construct($db) {
        $this->db = $db;
    }

    public function create($id_reservation) {
        // Récupérer le montant à payer depuis ReservationModel
        $reservationModel = new \app\models\ReservationModel($this->db);
        $montant = $reservationModel->getMontantA_Payer($id_reservation);

        // Préparer l'insertion
        $stmt = $this->db->prepare("
            INSERT INTO {$this->table} (id_reservation, montant, date_paiement)
            VALUES (:id_reservation, :montant, :date_paiement)
        ");

        return $stmt->execute([
            ':id_reservation' => $id_reservation,
            ':montant' => $montant,
            ':date_paiement' => date('Y-m-d H:i:s')
        ]);
    }


    // Create
    // public function create($data) {
    //     $stmt = $this->db->prepare("
    //         INSERT INTO {$this->table} (id_reservation, montant, date_paiement)
    //         VALUES (:id_reservation, :montant, :date_paiement)
    //     ");
    //     return $stmt->execute([
    //         ':id_reservation' => $data['id_reservation'],
    //         ':montant' => $data['montant'],
    //         ':date_paiement' => date('Y-m-d H:i:s') // Date courante
    //     ]);
    // }

    // Read - All
    public function getAll() {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} ORDER BY date_paiement DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Read - By ID
    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id_payement = :id LIMIT 1");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Update
    public function update($id, $data) {
        $stmt = $this->db->prepare("
            UPDATE {$this->table}
            SET id_reservation = :id_reservation,
                montant = :montant,
                date_paiement = :date_paiement
            WHERE id_payement = :id
        ");
        return $stmt->execute([
            ':id' => $id,
            ':id_reservation' => $data['id_reservation'],
            ':montant' => $data['montant'],
            ':date_paiement' => $data['date_paiement']
        ]);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE id_payement = :id");
        return $stmt->execute([':id' => $id]);
    }

    // Optionnel : récupérer tous les paiements par réservation
    public function getAllByReservation($id_reservation) {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id_reservation = :id_reservation ORDER BY date_paiement DESC");
        $stmt->execute([':id_reservation' => $id_reservation]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllByGroupe($id_groupe) {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id_groupe = :id_groupe ORDER BY date_paiement DESC");
        $stmt->execute([':id_groupe' => $id_groupe]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    // search reservation (nom responsable du groupe, date_reservation, heure)
    public function searchReservation($data) {
        $sql = "
            SELECT r.*, c.nom_responsable, c.contact
            FROM reservation r
            JOIN club_groupe c ON r.id_club = c.id
            WHERE 1=1
        ";

        $params = [];

        if (!empty($data['nom_responsable'])) {
            $sql .= " AND LOWER(c.nom_responsable) LIKE LOWER(:nom_responsable)";
            $params[':nom_responsable'] = '%' . $data['nom_responsable'] . '%';
        }

        if (!empty($data['date'])) {
            $sql .= " AND DATE(r.date_reserve) = :date";
            $params[':date'] = $data['date'];
        }

        if (!empty($data['heure'])) {
            $sql .= " AND r.heure_debut <= :heure AND r.heure_fin >= :heure";
            $params[':heure'] = $data['heure'];
        }

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}

?>
