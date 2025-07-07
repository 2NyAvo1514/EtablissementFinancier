<?php
require_once __DIR__ . '/../models/ClientModel.php';
require_once __DIR__ . '/../helpers/Utils.php';



class ClientController
{
    public static function getAll()
    {
        $clients = ClientModel::getAll();
        Flight::json($clients);
    }

    public static function getById($id)
    {
        $client = ClientModel::getById($id);
        Flight::json($client);
    }

    public static function getByNum($num)
    {
        $client = ClientModel::getByNum($num);
        Flight::json($client);
    }

    public static function create()
    {
        $data = Flight::request()->data;
        $id = ClientModel::create($data);
        $dateFormatted = Utils::formatDate('2025-01-01');
        Flight::json(['message' => 'Client ajouté', 'id' => $id]);
    }

    public static function update($id)
    {
        $data = Flight::request()->data;
        ClientModel::update($id, $data);
        Flight::json(['message' => 'Client modifié']);
    }

    public static function delete($id)
    {
        ClientModel::delete($id);
        Flight::json(['message' => 'Client supprimé']);
    }
}
