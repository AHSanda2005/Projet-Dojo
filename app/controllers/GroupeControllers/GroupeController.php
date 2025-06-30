<?php

namespace app\controllers\GroupeControllers;

use app\models\GroupeModels\GroupeModel;
use Flight;

class GroupeController {

    public function InsertGroupe() {
        $nom_responsable = Flight::request()->data->nom_responsable;
        $contact = Flight::request()->data->contact;
        $nombre = Flight::request()->data->nombre;

        $model = new GroupeModel();

        $message = $model->insert($nom_responsable, $contact, $nombre);

        Flight::render('InsertGroupe', [
            'status' => $data,
            'message' => $message
        ]);
    }
}
