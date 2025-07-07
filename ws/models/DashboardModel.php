<?php
require_once __DIR__ . '/../db.php';

class DashboardModel
{
    public static function getAll()
    {
        $db = getDB();
        $stmt = $db->query("SELECT * FROM banque_Prevision");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getById($id)
    {
        $db = getDB();
        $stmt = $db->prepare("SELECT * FROM banque_Prevision WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function delete($id)
    {
        $db = getDB();
        $stmt = $db->prepare("DELETE FROM banque_Prevision WHERE id = ?");
        $stmt->execute([$id]);
    }

    public static function getSommeMontantFinal($mois, $annee)
    {
        $db = getDB();
        $stmt = $db->prepare("select sum(montantFinal) AS total from banque_Prevision where mois = ? and annee= ?");
        $stmt->execute([$mois, $annee]);
        return (float) $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }

    public static function getSommeMontantRealise($mois, $annee)
    {
        $db = getDB();
        $stmt = $db->prepare("
        SELECT SUM(montant) AS total 
        FROM banque_HistoriqueMouvementSolde
        WHERE MONTH(dateMouvement) = ? 
          AND YEAR(dateMouvement) = ?
          AND statutValidation = 1
          AND idTypeMouvementSolde = 2
    ");
        $stmt->execute([$mois, $annee]);
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;
    }

    public static function getSommeMontantPret($mois, $annee)
    {
        $db = getDB();
        $stmt = $db->prepare("
        SELECT SUM(montant) AS total 
        FROM banque_Pret 
        WHERE MONTH(datePret) = ? 
          AND YEAR(datepret) = ?
    ");
        $stmt->execute([$mois, $annee]);
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;
    }

    public static function calculInteretPrevision($mois, $annee): float
    {
        $montantPret = self::getSommeMontantPret($mois, $annee);
        $montantFinal = self::getSommeMontantFinal($mois, $annee);
        return $montantFinal - $montantPret;
    }

    public static function calculInteretRealisation($mois, $annee): float
    {
        $montantPret = self::getSommeMontantPret($mois, $annee);
        $montantFinal = self::getSommeMontantRealise($mois, $annee);
        return $montantFinal - $montantPret;
    }

}
