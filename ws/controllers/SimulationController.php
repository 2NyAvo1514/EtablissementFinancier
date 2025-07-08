<?php 
require_once __DIR__ . '/../models/SimulationModel.php';

class SimulationController{
    public static function createSimulation(){
        $data = Flight::request()->data;
        $sim = SimulationModel::newSimulation($data);
        Flight::json(['message'=>'Simulation enregistré']);
    }
}