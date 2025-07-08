<?php
require_once __DIR__ . '/../models/ComparaisonModel.php';
require_once __DIR__ . '/../helpers/Utils.php';



class ComparaisonController{
    public static function getSimulation(){
        $simulation = ComparaisonModel::getSimulation();
        Flight::json($simulation);
    }

    public static function getSimulationById($id){
        $simulationById = ComparaisonModel::getSimulationById($id);
        Flight::json($simulationById);
    }
}
