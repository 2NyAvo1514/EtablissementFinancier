<?php
require_once __DIR__ . '/../db.php';

class ComparaisonModel
{
    public static function getSimulation()
    {
        $db = getDB();
        $stmt = $db->query("
            SELECT 
            s.id as idSimulation,
            tp.typePret,
            tp.id AS idTypePret,
            s.montant,
            tc.typeClient,
            tc.id AS idTypeClient,
            s.nbrMois
        FROM banque_Simulation s
        JOIN banque_TypeClient tc ON s.idTypeClient = tc.id
        JOIN banque_TypePret tp ON s.idTypePret = tp.id
        ORDER BY s.id DESC
        LIMIT 2;
    
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getSimulationById($id) {
        $db = getDB();
        $stmt = $db->prepare("SELECT * FROM banque_Simulation WHERE id = ?");
        $stmt->execute([$id]);
    
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

}
