<?php

namespace app\controllers;

use app\models\ReservationModel;
use Flight;

class ReservationController {

    public function __construct() {
    }

    
    public function searchForm() {
        Flight::render('reservation/search');
    }


    public function search() {
        $data = Flight::request()->data->getData();
        $model = new \app\models\ReservationModel(Flight::db());
        $results = $model->searchReservation($data);

        // On renvoie à la même vue avec le résultat inclus
        Flight::render('reservation/search', [
            'reservations' => $results,
            'old' => $data
        ]);
    }



}

?>
