<?php
require_once __DIR__ . '/../db.php';

class TypePretModel
{
    public static function getAll()
    {
        $db = getDB();
        $stmt = $db->query("SELECT * FROM banque_TypePret");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}
