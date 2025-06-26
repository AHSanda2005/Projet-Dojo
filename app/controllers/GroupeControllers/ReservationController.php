<?php

namespace app\controllers\GroupeControllers;

use app\models\GroupeModels\ReservationModel;
use Flight;

class ReservationController {

    public function InsertReservation() {
        $id_club = Flight::request()->data->id_club;
        $date_reservation = Flight::request()->data->date_reservation;
        $date_reserve = Flight::request()->data->date_reserve;
        $heure_debut = Flight::request()->data->heure_debut;
        $heure_fin = Flight::request()->data->heure_fin;

        $model = new ReservationModel();
        $message = $model->insert($id_club, $date_reservation, $date_reserve, $heure_debut, $heure_fin);

        Flight::render('reservation_form', ['message' => $message]);
    }

    public function GetAllReservations() {
        $model = new ReservationModel();
        $reservations = $model->getAll();

        Flight::render('reservation_list', ['reservations' => $reservations]);
    }

    public function GetReservationById($id) {
        $model = new ReservationModel();
        $reservation = $model->getById($id);

        Flight::render('reservation_detail', ['reservation' => $reservation]);
    }

    public function UpdateReservation($id) {
        $id_club = Flight::request()->data->id_club;
        $date_reservation = Flight::request()->data->date_reservation;
        $date_reserve = Flight::request()->data->date_reserve;
        $heure_debut = Flight::request()->data->heure_debut;
        $heure_fin = Flight::request()->data->heure_fin;

        $model = new ReservationModel();
        $message = $model->update($id, $id_club, $date_reservation, $date_reserve, $heure_debut, $heure_fin);

        $reservation = $model->getById($id);
        Flight::render('reservation_detail', ['reservation' => $reservation, 'message' => $message]);
    }

    public function DeleteReservation($id) {
        $model = new ReservationModel();
        $message = $model->delete($id);

        $reservations = $model->getAll();
        Flight::render('reservation_list', ['reservations' => $reservations, 'message' => $message]);
    }
}
