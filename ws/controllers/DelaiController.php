<?php
require_once __DIR__ . '/../models/DelaiModel.php';
require_once __DIR__ . '/../helpers/Utils.php';



class DelaiController {
  

    public static function create() {
        $data = Flight::request()->data;
        $id = DelaiModel::create($data);
        Flight::json(['message' => 'Delai ajouté', 'id' => $id]);
    }

    public static function getLastDelai()
    {
        $taux = DelaiModel::getLastDelai();
        Flight::json($taux);
    }
}
