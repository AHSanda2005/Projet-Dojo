<?php

namespace app\controllers;

use Flight;

class Controller {

    public function __construct() {
    }

    public function acceuil() {
        Flight::render('acceuil');
    }

    public function login() {
        Flight::render('template/auth/login');

    }
    public function signin() {
        Flight::render('template/auth/signin');

    }

    public function demographie() {
        Flight::render('statistique/demographie');
    }

    public function abonnement() {
        Flight::render('statistique/abonnement');
    }

    public function presence() {
        Flight::render('suivi/presence');
    }

    public function personnel() {
        Flight::render('suivi/personnel');
    }

    public function club() {
        Flight::render('suivi/club');
    }

    public function tarif() {
        Flight::render('gestion/tarif');
    }

    public function edt() {
        Flight::render('gestion/edt');
    }

}
