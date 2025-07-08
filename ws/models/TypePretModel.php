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

      public static function getById($id)
    {
        $db = getDB();
        $stmt = $db->prepare("SELECT * FROM banque_TypePret WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

}
