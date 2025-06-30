<?php
class AbonnementModel {
    public $id, $id_eleve, $type, $date_debut, $date_fin, $status;

    public function isActive() {
        return $this->status === 'actif';
    }

    public function daysRemaining() {
        return (new DateTime($this->date_fin))->diff(new DateTime())->days;
    }

    public function canRenew() {
        return $this->status === 'actif' && $this->daysRemaining() <= 7;
    }

    
}

?>