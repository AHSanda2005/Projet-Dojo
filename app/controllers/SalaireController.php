<?php

namespace app\controllers;

use app\models\SalaireModel;
use Flight;

class SalaireController {
    public function listPersonnel() {
        $salaire = new SalaireModel(Flight::db());
        $pers = $salaire->getAllPersonnel();
        Flight::render('salaire',['personnels' => $pers]);
    }
}
