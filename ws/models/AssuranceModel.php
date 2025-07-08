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

    public static function getLastAssurance()
    {
        $db = getDB();
        $stmt = $db->query("SELECT * FROM (SELECT * , ROW_NUMBER() OVER(PARTITION BY idTypeClient, idTypePret ORDER BY dateAssurance DESC)AS rn FROM banque_Assurance) sub WHERE rn = 1;");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
