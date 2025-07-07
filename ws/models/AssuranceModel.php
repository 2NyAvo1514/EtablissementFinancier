<?php
require_once __DIR__ . '/../db.php';

class AssuranceModel
{

    public static function create($data)
    {
        $db = getDB();
        $stmt = $db->prepare("INSERT INTO banque_Assurance (idTypeClient,idTypePret,valeur,dateAssurance) VALUES (?, ?, ?, ?)");
        $stmt->execute([$data->idTypeClient, $data->idTypePret, $data->valeur, $data->dateAssurance]);
        return $db->lastInsertId();
    }
}
