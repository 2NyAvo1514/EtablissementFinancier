<?php
require_once __DIR__ . '/../models/ValidationModel.php';
require_once __DIR__ . '/../helpers/Utils.php';



class ValidationController {
    public static function getAllValide() {
        $valide = ValidationModel::getAllValide();
        Flight::json($valide);
    }

    public static function getAllInvalid() {
        $invalide = ValidationModel::getAllInvalid();
        Flight::json($invalide);
    }

    public static function valider($idPret, $dateValidation) {
        $data = ValidationModel::valider($idPret, $dateValidation);
        Flight::json($data);
    }

    public static function rejetter($idPret, $dateValidation) {
        $data = ValidationModel::rejetter($idPret, $dateValidation);
        Flight::json($data);
    }

    public static function genererPDF($idPret){
        $pdf = ValidationModel::genererPDF($idPret);
        Flight::json($pdf);
    }

    // public static function getById($id) {
    //     $etudiant = Etudiant::getById($id);
    //     Flight::json($etudiant);
    // }


    // public static function update($id) {
    //     $data = Flight::request()->data;
    //     Etudiant::update($id, $data);
    //     Flight::json(['message' => 'Étudiant modifié']);
    // }

    // public static function delete($id) {
    //     Etudiant::delete($id);
    //     Flight::json(['message' => 'Étudiant supprimé']);
    // }
}
