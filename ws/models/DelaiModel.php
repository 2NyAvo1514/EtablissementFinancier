<?php
require_once __DIR__ . '/../db.php';

class DelaiModel
{

    public static function create($data)
    {
        $db = getDB();
        $stmt = $db->prepare("INSERT INTO banque_Delais (idTypeClient,idTypePret,duree,dateDelais) VALUES (?, ?, ?, ?)");
        $stmt->execute([$data->idTypeClient, $data->idTypePret, $data->duree, $data->dateDelai]);
        return $db->lastInsertId();
    }

    public static function getLastDelai()
    {
        $db = getDB();
        $stmt = $db->query("SELECT * FROM (SELECT * , ROW_NUMBER() OVER(PARTITION BY idTypeClient, idTypePret ORDER BY dateDelais DESC)AS rn FROM banque_Delais) sub WHERE rn = 1;");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
