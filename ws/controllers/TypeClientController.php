<?php
require_once __DIR__ . '/../models/TypeClientModel.php';
require_once __DIR__ . '/../helpers/Utils.php';



class TypeClientController {
    public static function getAll() {
        $typeclients = TypeClientModel::getAll();
        Flight::json($typeclients);
    }

    public static function getById($id) {
        $typeclient = TypeClientModel::getById($id);
        Flight::json($typeclient);
    }


    public static function delete($id) {
        TypeClientModel::delete($id);
        Flight::json(['message' => 'TypeClient supprimé']);
    }
}
