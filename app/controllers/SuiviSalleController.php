<?php
namespace app\controllers;

use app\models\ClubModel;
use app\models\MaterielTypeModel;
use app\models\SuiviSalleModel;
use app\models\MaterielItemModel;
use app\models\SuperviseurModel;
use Flight;
use PDO;

class SuiviSalleController {
    private $model;
    private $materielModel;
    private $superviseurModel;
    private $clubModel;
    private $materielTypeModel;

    public function __construct() {
        $db =new PDO( 'pgsql:host=localhost;dbname=dojo' ,'postgres','password');

        $this->model = new SuiviSalleModel($db);
        $this->materielModel = new MaterielItemModel($db);
        $this->superviseurModel = new SuperviseurModel($db);
        $this->clubModel = new ClubModel($db);
        $this->materielTypeModel = new MaterielTypeModel($db);
    }

    public function index() {
        $suivis = $this->model->all();
        $materiels = $this->materielModel->all();
        $superviseurs = $this->superviseurModel->all();
        $clubs = $this->clubModel->all();
        $types = $this->materielTypeModel->all();
        Flight::render('suivi_salle/index', [
            'suivis' => $suivis,
            'materiels' => $materiels,
            'superviseurs' => $superviseurs,
            'clubs' => $clubs,
            'types' => $types
        ]);
    }

    public function store() {
        $this->model->create([
            'id_superviseur' => $_POST['id_superviseur'],
            'id_item' => $_POST['id_item'],
            'id_club' => empty($_POST['id_club']) ? null : $_POST['id_club'],
            'description' => $_POST['description'],
            'etat' => $_POST['etat']
        ]);


        Flight::redirect('/suivi-salle');
    }

    public function delete($id) {
        $this->model->delete($id);
        Flight::redirect('/suivi-salle');
    }
}
