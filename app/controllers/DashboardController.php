<?php
class DashboardController {
    private $db;

    public function __construct() {
        $this->db = new PDO('pgsql:host=localhost;dbname=dojo', 'postgres', 'password');
    }

    public function index() {
        $stats = [];

        $stats['total_materiels'] = $this->db->query("SELECT COUNT(*) FROM materiel_item")->fetchColumn();
        $stats['materiels_en_salle'] = $this->db->query("SELECT COUNT(*) FROM suivi_salle")->fetchColumn();
        $stats['types'] = $this->db->query("SELECT COUNT(*) FROM materiel_type")->fetchColumn();

        $stats['stock_disponible'] = $this->db->query("
            SELECT COALESCE(SUM(CASE WHEN type_mouvement = 'I' THEN quantite ELSE -quantite END), 0)
            FROM stock_materiel
        ")->fetchColumn();

        $stats['endommagés'] = $this->db->query("SELECT COUNT(*) FROM suivi_salle WHERE etat = 'endommage'")->fetchColumn();
        $stats['factures'] = $this->db->query("SELECT COUNT(*) FROM facture_materiel")->fetchColumn();
        $stats['payees'] = $this->db->query("SELECT COUNT(*) FROM facture_materiel WHERE est_paye = true")->fetchColumn();
        $stats['non_payees'] = $this->db->query("SELECT COUNT(*) FROM facture_materiel WHERE est_paye = false")->fetchColumn();

        $stats['montant_total'] = $this->db->query("SELECT COALESCE(SUM(montant), 0) FROM facture_materiel")->fetchColumn();

        $stats['pertes'] = $this->db->query("
            SELECT COALESCE(SUM(mt.prix), 0)
            FROM suivi_salle ss
            JOIN materiel_item mi ON ss.id_item = mi.id_item
            JOIN materiel_type mt ON mi.id_type = mt.id_type
            WHERE ss.etat = 'endommage'
        ")->fetchColumn();

        Flight::render('dashboard_materiel/index', ['stats' => $stats]);
    }
}
