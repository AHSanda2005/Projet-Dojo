<?php
namespace app\models\modelsCours;
use PDO;

class ReservationModel {
    private $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function getActivitesClubs($mois, $annee) {
        $resultats = [];

        // --- 1. Abonnements actifs pour chaque jour du mois ---
        $sqlAbonnement = "
            SELECT 
                a.jour,
                a.id_club,
                c.nom_responsable AS club_nom,
                c.discipline,
                'abonnement' AS type
            FROM abonnement a
            JOIN club_groupe c ON c.id = a.id_club
            WHERE a.mois = :mois AND a.annee = :annee AND a.actif = true
        ";
        $stmt1 = $this->pdo->prepare($sqlAbonnement);
        $stmt1->execute([':mois' => $mois, ':annee' => $annee]);
        $abonnements = $stmt1->fetchAll(\PDO::FETCH_ASSOC);

        foreach ($abonnements as $a) {
            // pour chaque jour du mois qui correspond au jour d’abonnement
            for ($i = 1; $i <= 31; $i++) {
                if (!checkdate($mois, $i, $annee)) continue;
                $date = new \DateTime("$annee-$mois-$i");
                if ($date->format('w') == $a['jour']) { // 0 = dimanche, 1 = lundi, etc.
                    $jour = intval($date->format('j'));
                    $resultats[$jour][] = $a;
                }
            }
        }

        // --- 2. Réservations confirmées ---
        $sqlResa = "
            SELECT 
                r.date_reserve,
                r.heure_debut,
                r.heure_fin,
                c.nom_responsable AS club_nom,
                c.discipline,
                'reservation' AS type
            FROM reservation r
            JOIN club_groupe c ON r.id_club = c.id
            WHERE 
                r.valeur = 'confirme' AND
                EXTRACT(MONTH FROM r.date_reserve) = :mois AND
                EXTRACT(YEAR FROM r.date_reserve) = :annee
        ";
        $stmt2 = $this->pdo->prepare($sqlResa);
        $stmt2->execute([':mois' => $mois, ':annee' => $annee]);
        $reservations = $stmt2->fetchAll(\PDO::FETCH_ASSOC);

        foreach ($reservations as $r) {
            $jour = intval(date('j', strtotime($r['date_reserve'])));
            $resultats[$jour][] = $r;
        }

        return $resultats;
    }

}
