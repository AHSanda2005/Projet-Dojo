<?php
namespace app\models\AbonnementModel;

use PDO;
use Flight;

class AbonnementModel {
   
    public function getAll() {
        try {
            $db = Flight::db();
            $stmt = $db->query("SELECT * FROM abonnement");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            return [];
        }
    }
    public function getById($id) {
        try {
            $db = Flight::db();
            $stmt = $db->prepare("SELECT * FROM abonnement WHERE id = :id");
            $stmt->execute([':id' => $id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            return null;
        }
    }
    public function create($data) {
        try {
            $db = Flight::db();
            $stmt = $db->prepare("INSERT INTO abonnement (id_club, jour, mois, actif) VALUES (?, ?, ?, ?)");
            $stmt->execute([$data['id_club'], $data['jour'], $data['mois'], $data['actif']]);
            return "Insertion réussie !";
        } catch (\PDOException $e) {
            return "Erreur : " . $e->getMessage();
        }
    }
     public  function update($id, $data) {
        try {
             $db = Flight::db();
            $stmt = $db->prepare("UPDATE abonnement SET id_club=?, jour=?, mois=?, actif=? WHERE id_abonnement = ?");
             $stmt->execute([$data['id_club'], $data['jour'], $data['mois'], $data['actif'], $id]);
             return "Mise à jour réussie !";
        } catch (\PDOException $e) {   
            return "Erreur de mise à jour : " . $e->getMessage();
        } 
        
    }
    public function delete($id) {
        try {
            $db = Flight::db();
            $stmt = $db->prepare("DELETE FROM abonnement WHERE id_abonnement = ?");
            $stmt->execute([$id]);
            return $stmt->rowCount() > 0 ? "Suppression réussie." : "Aucun abonnement trouvé.";
        } catch (\PDOException $e) {
            return "Erreur de suppression : " . $e->getMessage();
        }   
    }
    
    public function renouveler($id, $nom, $prix, $duree) {
        try {
            $db = Flight::db();
            $stmt = $db->prepare("UPDATE abonnement SET mois = mois + 1 WHERE id_abonnement = ? AND actif = true");
            $stmt->execute([$id]);
            return "Mise à jour réussie !";
        } catch (\PDOException $e) {
            return "Erreur de mise à jour : " . $e->getMessage();
        }
    }
    public function annuler($id) {
        try {
            $db = Flight::db();
            $stmt = $db->prepare("UPDATE abonnement SET actif = false WHERE id_abonnement = ?");
            $stmt->execute([$id]);
            return "Abonnement annulé avec succès.";
        } catch (\PDOException $e) {
            return "Erreur lors de l'annulation : " . $e->getMessage();
        }
    }
    public static function getExpirationsDans7Jours() {
        try {
            $db = Flight::db();
            $stmt = $db->prepare("SELECT * FROM abonnement WHERE actif = true AND mois <= 1");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        }  catch (\PDOException $e) {
            return "Erreur lors de la récupération des abonnements : " . $e->getMessage();
        }
    }
}

?>