<?php
require_once __DIR__ . '/../models/FondModel.php';
require_once __DIR__ . '/../helpers/Utils.php';



class FondController {
  

    public static function create() {
        $data = Flight::request()->data;
        $id = FondModel::create($data);
        Flight::json(['message' => 'Fond ajouté', 'id' => $id]);
    }
}
