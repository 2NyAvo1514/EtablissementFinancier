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
          AND idTypeMouvementSolde = 2
    ");
        $stmt->execute([$mois, $annee]);
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;
    }

    public static function getSommeMontantPret($mois, $annee)
    {
        $db = getDB();
        $stmt = $db->prepare("
        SELECT SUM(p.montant) AS total
        FROM banque_Pret p
        JOIN banque_HistoriquePret h ON p.id = h.idPret
        WHERE h.statutValidation = 1
          AND MONTH(p.datePret) = :mois
          AND YEAR(p.datePret) = :annee
    ");
        $stmt->execute([
            'mois' => $mois,
            'annee' => $annee
        ]);
        $res = $stmt->fetch(PDO::FETCH_ASSOC);
        return (float) ($res['total'] ?? 0);
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
    public static function getSoldeInitial(): float
    {
        $db = getDB();
        $stmt = $db->query("SELECT solde FROM banque_Fond LIMIT 1");
        $res = $stmt->fetch(PDO::FETCH_ASSOC);
        return $res ? floatval($res['solde']) : 0.0;
    }

    public static function getCumulMontantPretJusqua($mois, $annee): float
    {
        $db = getDB();
        $stmt = $db->prepare("
        SELECT SUM(p.montant) AS total
FROM banque_Pret p
JOIN banque_HistoriquePret h ON p.id = h.idPret
WHERE h.statutValidation = 1
AND (YEAR(p.datePret) < :annee OR (YEAR(p.datePret) = 2025 AND MONTH(p.datePret) <= :mois))
    ");
        $stmt->execute([
            'mois' => $mois,
            'annee' => $annee
        ]);
        $res = $stmt->fetch(PDO::FETCH_ASSOC);
        return $res ? floatval($res['total']) : 0.0;
    }

    public static function getCumulMontantRemboursementJusqua($mois, $annee): float
    {
        $db = getDB();
        $stmt = $db->prepare("
        SELECT SUM(montant) as total
        FROM banque_historiqueMouvementSolde
        WHERE YEAR(dateMouvement) < :annee 
           OR (YEAR(dateMouvement) = :annee AND MONTH(dateMouvement) <= :mois) AND idTypeMouvementSolde = 2
    ");
        $stmt->execute([
            'mois' => $mois,
            'annee' => $annee
        ]);
        $res = $stmt->fetch(PDO::FETCH_ASSOC);
        return $res ? floatval($res['total']) : 0.0;
    }



}
