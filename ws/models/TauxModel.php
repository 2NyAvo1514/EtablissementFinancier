<?php
require_once __DIR__ . '/../db.php';

class TauxModel
{
    public static function getAllTaux(){
        $db = getDB();
        $stmt = $db->query("SELECT * FROM banque_taux");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public static function create($data)
    {
        $db = getDB();
        $stmt = $db->prepare("INSERT INTO banque_Taux (idTypeClient,idTypePret,valeur,dateTaux) VALUES (?, ?, ?, ?)");
        $stmt->execute([$data->idTypeClient, $data->idTypePret, $data->valeur, $data->dateTaux]);
        return $db->lastInsertId();
    }

    public static function getLastTaux()
    {
        $db = getDB();
        $stmt = $db->query("SELECT * FROM (SELECT * , ROW_NUMBER() OVER(PARTITION BY idTypeClient, idTypePret ORDER BY dateTaux DESC)AS rn FROM banque_Taux) sub WHERE rn = 1;");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
