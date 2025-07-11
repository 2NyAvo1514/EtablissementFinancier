<?php
require_once __DIR__ . '/../db.php';

class ClientModel
{
    public static function getAll()
    {
        $db = getDB();
        $stmt = $db->query("SELECT * FROM banque_Client");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getById($id)
    {
        $db = getDB();
        $stmt = $db->prepare("SELECT * FROM banque_Client WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function create($data)
    {
        $db = getDB();
        $stmt = $db->prepare("INSERT INTO banque_Client (nom, mail, mdp, dateNaissance,idTypeClient) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$data->nom, $data->mail, $data->mdp, $data->dateNaissance, $data->idTypeClient]);
        return $db->lastInsertId();
    }

    public static function update($id, $data)
    {
        $db = getDB();
        $stmt = $db->prepare("UPDATE banque_Client SET nom = ?, mail = ?, mdp = ?, dateNaissance = ?,idTypeClient = ? WHERE id = ?");
        $stmt->execute([$data->nom, $data->mail, $data->mdp, $data->dateNaissance, $data->idTypeClient, $id]);
    }

    public static function delete($id)
    {
        $db = getDB();
        $stmt = $db->prepare("DELETE FROM banque_Client WHERE id = ?");
        $stmt->execute([$id]);
    }
}
