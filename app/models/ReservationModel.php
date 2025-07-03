<?php
namespace app\models;

use PDO;
use Flight;

class ReservationModel {
    protected $db;
    protected $table = 'reservation';

    public function __construct($db) {
        $this->db = $db;
    }

    public function searchReservation($data) {
        $sql = "
            SELECT 
                r.*, 
                c.nom_responsable, 
                c.contact,
                s.valeur AS statut_reservation
            FROM reservation r
            JOIN club_groupe c ON r.id_club = c.id
            LEFT JOIN status s ON s.id_reservation = r.id_reservation
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

    public function nbrHeureByReservation($id_reservation) {
        $stmt = $this->db->prepare("
            SELECT EXTRACT(EPOCH FROM (heure_fin - heure_debut)) / 3600 AS heures
            FROM reservation
            WHERE id_reservation = :id
        ");
        $stmt->execute([':id' => $id_reservation]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        // Arrondi à 2 décimales (ex. 1h30 => 1.5)
        return isset($result['heures']) ? round($result['heures'], 2) : 0;
    }

    public function getMontantA_Payer($id_reservation) {
        // 1. Calcul du nombre d'heures de réservation
        $nbr_heures = $this->nbrHeureByReservation($id_reservation);

        // 2. Récupération du tarif horaire (id_tarif = 1 ici par défaut)
        $tarifModel = new \app\models\TarifClubModel($this->db);
        $tarif = $tarifModel->getById(1); // Id fixe, ou adapter dynamiquement

        if ($tarif && isset($tarif['montant_par_heure'])) {
            return round($nbr_heures * $tarif['montant_par_heure'], 2);
        }

        return 0; // Si problème ou tarif manquant
    }




}

?>
