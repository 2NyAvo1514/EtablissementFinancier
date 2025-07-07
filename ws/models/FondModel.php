<?php
require_once __DIR__ . '/../db.php';

class FondModel
{

    public static function create($data)
    {
        $db = getDB();
        $stmt = $db->prepare("INSERT INTO banque_Fond (solde) VALUES (?)");
        $stmt->execute([$data->solde]);
        return $db->lastInsertId();
    }
}
