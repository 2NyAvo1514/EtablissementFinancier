<?php
require_once __DIR__ . '/../models/AssuranceModel.php';
require_once __DIR__ . '/../helpers/Utils.php';



class AssuranceController {
  

    public static function create() {
        $data = Flight::request()->data;
        $id = AssuranceModel::create($data);
        Flight::json(['message' => 'Taux ajouté', 'id' => $id]);
    }
}
