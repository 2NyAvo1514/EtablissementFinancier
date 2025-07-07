<?php
require_once __DIR__ . '/../db.php';

class TypeClientModel
{
    public static function getAll()
    {
        $db = getDB();
        $stmt = $db->query("SELECT * FROM banque_TypeClient");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getById($id)
    {
        $db = getDB();
        $stmt = $db->prepare("SELECT * FROM banque_TypeClient WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function delete($id)
    {
        $db = getDB();
        $stmt = $db->prepare("DELETE FROM banque_TypeClient WHERE id = ?");
        $stmt->execute([$id]);
    }
}
