<?php
require_once __DIR__ . '/../db.php';

class RemboursementModel
{


    public static function create($data)
    {
        $db = getDB();
        $stmt = $db->prepare("INSERT INTO banque_HistoriqueMouvementSolde (idClient,montant, dateMouvement,idTypeMouvementSolde) VALUES (?, ?, ?, 2)");
        $stmt->execute([$data->idClient, $data->montant, $data->dateRemboursement]);
        return $db->lastInsertId();
    }

}
