<?php
require_once __DIR__ . '/../models/TauxModel.php';
require_once __DIR__ . '/../helpers/Utils.php';



class TauxController {
  

    public static function create() {
        $data = Flight::request()->data;
        $id = TauxModel::create($data);
        Flight::json(['message' => 'Taux ajouté', 'id' => $id]);
    }
}
