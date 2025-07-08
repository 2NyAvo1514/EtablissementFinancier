<?php

require_once __DIR__ . '/../db.php';

class SimulationModel{
    public static function newSimulation($data){
        $db = getDB();
        $stmt = $db->prepare("INSERT INTO banque_Simulation (idTypeClient,idTypePret,montant,nbrMois) VALUES (?,?,?,?)");
        $stmt->execute([$data->typeClient, $data->typePret, $data->montant, $data->duree]);
        return $db->lastInsertId();
    }
}