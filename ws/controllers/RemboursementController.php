<?php
require_once __DIR__ . '/../models/RemboursementModel.php';
require_once __DIR__ . '/../helpers/Utils.php';



class RemboursementController
{
 

    public static function create()
    {
        $data = Flight::request()->data;
        $id = RemboursementModel::create($data);
        $dateFormatted = Utils::formatDate('2025-01-01');
        Flight::json(['message' => 'Client ajouté', 'id' => $id]);
    }


}
