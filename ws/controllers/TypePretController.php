<?php
require_once __DIR__ . '/../models/TypePretModel.php';
require_once __DIR__ . '/../helpers/Utils.php';



class TypePretController {
    public static function getAll() {
        $typeprets = TypePretModel::getAll();
        Flight::json($typeprets);
    }

}
