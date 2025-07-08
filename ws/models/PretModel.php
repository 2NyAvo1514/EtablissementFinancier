<?php
require_once __DIR__ . '/../db.php';

class PretModel {
    public static function getAll(){
        $db = getDB();
        $stmt = $db->query("SELECT * FROM banque_typepret");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getClient($nom, $numId) {
        $db   = getDB();
        $stmt = $db->prepare(
            "SELECT * FROM banque_Client WHERE nom = ? AND numeroIdentification = ? LIMIT 1"
        );
        $stmt->execute([$nom, $numId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function getSolde() {
        $db = getDB();
        $stmt = $db->query("SELECT * FROM banque_Fond");
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function insererPret($data) {
        $db = getDB();
        $stmt = $db->prepare("INSERT INTO banque_Pret (idTypePret,montant,idClient,datePret,nbrMois,descriptionPret) VALUES (?,?,?,?,?,?)");
        $stmt->execute([$data->typePret, $data->montant, $data->id, $data->datePret, $data->duree,$data->descri]);
        return $db->lastInsertId();
    }

    public static function getPretByData($dt) {
        $db = getDB();
        $stmt = $db->prepare("SELECT * FROM banque_Pret WHERE idTypePret = ? AND montant = ? AND idClient = ? AND datePret = ? AND nbrMois = ? LIMIT 1");
        $stmt->execute([$dt->typePret,$dt->montant,$dt->id,$dt->datePret,$dt->duree]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function insererHistoriquePret($data) {
        $db = getDB();
        $stmt = $db->prepare("INSERT INTO banque_HistoriquePret (idPret,statutValidation,dateValidation) VALUES (?,?,?)");
        $stmt->execute([$data->idPret, $data->statut, $data->date]);
        return $db->lastInsertId();
    }

}