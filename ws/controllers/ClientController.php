<?php
require_once __DIR__ . '/../models/ClientModel.php';
require_once __DIR__ . '/../helpers/Utils.php';



class ClientController {
    public static function getAll() {
        $clients = ClientModel::getAll();
        Flight::json($clients);
    }

    public static function getById($id) {
        $etudiant = Etudiant::getById($id);
        Flight::json($etudiant);
    }

    public static function create() {
        $data = Flight::request()->data;
        $id = Etudiant::create($data);
        $dateFormatted = Utils::formatDate('2025-01-01');
        Flight::json(['message' => 'Étudiant ajouté', 'id' => $id]);
    }

    public static function update($id) {
        $data = Flight::request()->data;
        Etudiant::update($id, $data);
        Flight::json(['message' => 'Étudiant modifié']);
    }

    public static function delete($id) {
        Etudiant::delete($id);
        Flight::json(['message' => 'Étudiant supprimé']);
    }
}
