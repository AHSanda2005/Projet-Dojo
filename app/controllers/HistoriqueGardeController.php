<?php
namespace app\controllers;

use app\models\HistoriqueGardeModel;
use Flight;
use PDO;

class HistoriqueGardeController {
    private $model;

    public function __construct() {
        $db = new PDO('pgsql:host=localhost;dbname=dojo', 'postgres', 'password');
        $this->model = new HistoriqueGardeModel($db);
    }

    public function index() {
        $data = $this->model->all();
        Flight::render('historique/index', ['historiques' => $data]);
    }

    public function createForm() {
        Flight::render('historique/create');
    }

    public function create() {
        $data = Flight::request()->data->getData();
        $this->model->create($data);
        Flight::redirect('/historique-garde');
    }

    public function editForm($id) {
        $record = $this->model->find($id);
        Flight::render('historique/edit', ['historique' => $record]);
    }

    public function update($id) {
        $data = Flight::request()->data->getData();
        $this->model->update($id, $data);
        Flight::redirect('/historique-garde');
    }

    public function delete($id) {
        $this->model->delete($id);
        Flight::redirect('/historique-garde');
    }
}