<?php
require_once __DIR__ . '/../db.php';

class TauxModel
{

    public static function create($data)
    {
        $db = getDB();
        $stmt = $db->prepare("INSERT INTO banque_Taux (idTypeClient,idTypePret,valeur,dateTaux) VALUES (?, ?, ?, ?)");
        $stmt->execute([$data->idTypeClient, $data->idTypePret, $data->valeur, $data->dateTaux]);
        return $db->lastInsertId();
    }
}
