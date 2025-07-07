<?php
require_once __DIR__ . '/../db.php';
require_once(__DIR__ . '/../libs/fpdf.php');

class ValidationModel
{
    public static function getAllValide(){
        $db = getDB();
        $stmt = $db->query("
            SELECT 
            hp.id AS idHistorique,
            hp.idPret,
            hp.statutValidation,
            hp.dateValidation,
            c.id AS idClient,
            c.nom AS nomClient,
            c.mail,
            c.dateNaissance,
            tc.typeClient,
            p.montant,
            p.descriptionPret,
            p.datePret
        FROM banque_HistoriquePret hp
        JOIN (
            SELECT idPret, MAX(dateValidation) AS latestValidation
            FROM banque_HistoriquePret
            GROUP BY idPret
            HAVING COUNT(*) = 2 AND SUM(statutValidation) = 1
        ) AS latest ON hp.idPret = latest.idPret AND hp.dateValidation = latest.latestValidation
        JOIN banque_Pret p ON hp.idPret = p.id
        JOIN banque_Client c ON p.idClient = c.id
        JOIN banque_TypeClient tc ON c.idTypeClient = tc.id
        WHERE hp.statutValidation = 1
        ORDER BY p.datePret ASC;
        
    
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getAllInvalid(){
        $db = getDB();
        $stmt = $db->query("
            SELECT 
            hp.id AS idHistorique,
            hp.idPret,
            hp.statutValidation,
            hp.dateValidation,
            c.id AS idClient,
            c.nom AS nomClient,
            c.mail,
            c.dateNaissance,
            tc.typeClient,
            p.montant,
            p.descriptionPret,
            p.datePret
        FROM banque_HistoriquePret hp
        JOIN (
            SELECT idPret
            FROM banque_HistoriquePret
            GROUP BY idPret
            HAVING COUNT(*) = 1
        ) AS once_only ON hp.idPret = once_only.idPret
        JOIN banque_Pret p ON hp.idPret = p.id
        JOIN banque_Client c ON p.idClient = c.id
        JOIN banque_TypeClient tc ON c.idTypeClient = tc.id
        WHERE hp.statutValidation = 0
        ORDER BY p.datePret ASC;
    
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // public static function valider($idPret, $dateValidation) {
    //     $db = getDB();
    
    //     // 1. Récupérer les infos du prêt (montant, durée, etc.)
    //     $stmtPret = $db->prepare("
    //         SELECT p.id, p.nbrMois, p.montant
    //         FROM banque_Pret p
    //         WHERE p.id = ?
    //     ");

    //     $stmtPret->execute([$idPret]);
    //     $pret = $stmtPret->fetch(PDO::FETCH_ASSOC);
    
    //     if (!$pret) {
    //         throw new Exception("Prêt introuvable avec l'ID donné.");
    //     }
    
    //     $nbrMois = $pret['nbrMois'];
    //     $montant = $pret['montant'];
    
    //     if ($nbrMois <= 0) {
    //         throw new Exception("Le nombre de mois doit être supérieur à 0.");
    //     }
    
    //     // 2. Récupérer le taux applicable (le plus récent selon typeClient et typePret)
    //     $tauxPourcent = self::getTaux($idPret); 
    //     $taux = $tauxPourcent / 100;
    
    //     $assurancePourcent = self::getAssurance($idPret);
    //     $assurance = $assurancePourcent /100 ;

    //     // 3. Insérer dans banque_HistoriquePret
    //     $stmt = $db->prepare("
    //         INSERT INTO banque_HistoriquePret (idPret, statutValidation, dateValidation) 
    //         VALUES (?, 1, ?)
    //     ");
    //     $stmt->execute([$idPret, $dateValidation]);
    
    //     // 4. Calcul du montant mensuel avec taux
    //     $montantMensuel = round(($montant + ($montant * $taux) + ($montant * $assurance)) / $nbrMois, 2);
    
    //     // 5. Générer les lignes dans banque_Prevision
    //     $date = new DateTime($dateValidation);
    
    //     $stmtPrev = $db->prepare("
    //         INSERT INTO banque_Prevision (idPret, mois, annee, montantFinal)
    //         VALUES (?, ?, ?, ?)
    //     ");
    
    //     for ($i = 0; $i < $nbrMois; $i++) {
    //         $mois = (int) $date->format('n');  // mois de 1 à 12
    //         $annee = (int) $date->format('Y');
    
    //         $stmtPrev->execute([$idPret, $mois, $annee, $montantMensuel]);
    
    //         $date->modify('+1 month'); 
    //     }
    
    //     return $db->lastInsertId(); 
    // }

    public static function valider($idPret, $dateValidation) {
        $db = getDB();
    
        $stmtPret = $db->prepare("
            SELECT p.id, p.nbrMois, p.montant, c.idTypeClient, p.idTypePret
            FROM banque_Pret p
            JOIN banque_Client c ON p.idClient = c.id
            WHERE p.id = ?
        ");
        $stmtPret->execute([$idPret]);
        $pret = $stmtPret->fetch(PDO::FETCH_ASSOC);
    
        if (!$pret) {
            throw new Exception("Prêt introuvable avec l'ID donné.");
        }
    
        $nbrMois = $pret['nbrMois'];
        $montant = $pret['montant'];
    
        if ($nbrMois <= 0) {
            throw new Exception("Le nombre de mois doit être supérieur à 0.");
        }
    
        $tauxPourcent = self::getTaux($idPret);
        $taux = $tauxPourcent / 100;
    
        $assurancePourcent = self::getAssurance($idPret);
        $assurance = $assurancePourcent / 100;
    
        // Insertion historique
        $stmt = $db->prepare("
            INSERT INTO banque_HistoriquePret (idPret, statutValidation, dateValidation) 
            VALUES (?, 1, ?)
        ");
        $stmt->execute([$idPret, $dateValidation]);
        $idHistorique = $db->lastInsertId();
    
        $montantMensuel = round(($montant + ($montant * $taux) + ($montant * $assurance)) / $nbrMois, 2);
    
        $delai = self::getDelais($idPret);
        $date = new DateTime($dateValidation);
        if ($delai > 0) {
            $date->modify("+{$delai} month");
        }
    
        $stmtPrev = $db->prepare("
            INSERT INTO banque_Prevision (idPret, mois, annee, montantFinal)
            VALUES (?, ?, ?, ?)
        ");
    
        for ($i = 0; $i < $nbrMois; $i++) {
            $mois = (int)$date->format('n');
            $annee = (int)$date->format('Y');
        
            $res = $stmtPrev->execute([$idPret, $mois, $annee, $montantMensuel]);
            if (!$res) {
                $errorInfo = $stmtPrev->errorInfo();
                error_log("❌ Erreur insertion Prevision : " . implode(" | ", $errorInfo));
            } else {
                error_log("✅ Insertion Prévision : $mois-$annee = $montantMensuel");
            }
        
            $date->modify('+1 month');
        }
        
    
        return $idHistorique;
    }
    
    
    
    private static function getTaux($idPret) {
        $db = getDB();
    
        $stmt = $db->prepare("
            SELECT t.valeur AS taux
            FROM banque_Pret p
            JOIN banque_Client c ON p.idClient = c.id
            JOIN banque_TypePret tp ON p.idTypePret = tp.id
            JOIN banque_TypeClient tc ON c.idTypeClient = tc.id
            JOIN banque_Taux t ON t.idTypePret = tp.id AND t.idTypeClient = tc.id
            WHERE p.id = ?
            ORDER BY t.dateTaux DESC
            LIMIT 1
        ");
        $stmt->execute([$idPret]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if (!$result) {
            throw new Exception("Taux introuvable pour le prêt ID $idPret.");
        }
    
        return $result['taux']; // ex: 10 => 10%
    }

    private static function getAssurance($idPret) {
        $db = getDB();
    
        $stmt = $db->prepare("
            SELECT a.valeur AS assurance
            FROM banque_Pret p
            JOIN banque_Client c ON p.idClient = c.id
            JOIN banque_TypePret tp ON p.idTypePret = tp.id
            JOIN banque_TypeClient tc ON c.idTypeClient = tc.id
            JOIN banque_Assurance a ON a.idTypePret = tp.id AND a.idTypeClient = tc.id
            WHERE p.id = ?
            ORDER BY a.dateAssurance DESC
            LIMIT 1
        ");
        $stmt->execute([$idPret]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if (!$result) {
            throw new Exception("Assurance introuvable pour le prêt ID $idPret.");
        }
    
        return $result['assurance']; // ex: 10 => 10%
    }

    private static function getDelais($idPret) {
        $db = getDB();
    
        $stmt = $db->prepare("
            SELECT d.duree AS duree
            FROM banque_Pret p
            JOIN banque_Client c ON p.idClient = c.id
            JOIN banque_TypePret tp ON p.idTypePret = tp.id
            JOIN banque_TypeClient tc ON c.idTypeClient = tc.id
            JOIN banque_Delais d ON d.idTypePret = tp.id AND d.idTypeClient = tc.id
            WHERE p.id = ?
            ORDER BY d.duree DESC
            LIMIT 1
        ");
        $stmt->execute([$idPret]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if (!$result) {
            throw new Exception("Delais introuvable pour le prêt ID $idPret.");
        }
    
        return  (int)$result['duree']; 
    }
    
    public static function rejetter($idPret, $dateValidation) {
        $db = getDB();
    
        $stmt = $db->prepare("
            INSERT INTO banque_HistoriquePret (idPret, statutValidation, dateValidation) 
            VALUES (?, 0, ?)
        ");
        $stmt->execute([$idPret, $dateValidation]);

        return [
            "message" => "Prêt rejeté avec succès",
            "idHistorique" => $db->lastInsertId()
        ];
    }
    
    public static function genererPDF($idPret) {
        $db = getDB();
    
        // 1. Infos du prêt et du client
        $stmt = $db->prepare("
            SELECT c.nom AS nomClient, c.mail, c.dateNaissance,
                   p.montant, p.descriptionPret, p.datePret, p.nbrMois
            FROM banque_Pret p
            JOIN banque_Client c ON p.idClient = c.id
            WHERE p.id = ?
        ");
        $stmt->execute([$idPret]);
        $pret = $stmt->fetch(PDO::FETCH_ASSOC);
    
        // 2. Prévisions de paiement
        $stmt2 = $db->prepare("
            SELECT mois, annee, montantFinal
            FROM banque_Prevision
            WHERE idPret = ?
            ORDER BY annee, mois
        ");
        $stmt2->execute([$idPret]);
        $previsions = $stmt2->fetchAll(PDO::FETCH_ASSOC);
    
        // 3. Initialisation du PDF
        $pdf = new FPDF();
        $pdf->AddPage();
    
        // 4. En-tête
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(0, 10, utf8_decode('Résumé du Prêt'), 0, 1, 'C');
    
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(0, 10, utf8_decode('Nom du client : ' . $pret['nomClient']), 0, 1);
        $pdf->Cell(0, 10, utf8_decode('Email : ' . $pret['mail']), 0, 1);
        $pdf->Cell(0, 10, utf8_decode('Date de naissance : ' . $pret['dateNaissance']), 0, 1);
        $pdf->Ln(5);
    
        // 5. Infos du prêt
        $pdf->Cell(0, 10, utf8_decode('Montant du prêt : ' . number_format($pret['montant'], 2) . ' Ar'), 0, 1);
        $pdf->MultiCell(0, 10, utf8_decode('Description : ' . $pret['descriptionPret']));
        $pdf->Cell(0, 10, utf8_decode('Date du prêt : ' . $pret['datePret']), 0, 1);
        $pdf->Cell(0, 10, utf8_decode('Durée (mois) : ' . $pret['nbrMois']), 0, 1);
        $pdf->Ln(10);
    
        // 6. Tableau des prévisions
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(60, 10, 'Mois', 1);
        $pdf->Cell(40, 10, utf8_decode('Année'), 1);
        $pdf->Cell(60, 10, 'Montant Mensuel', 1);
        $pdf->Ln();
    
        $pdf->SetFont('Arial', '', 12);
        $moisNoms = [
            1 => 'Janvier', 2 => 'Février', 3 => 'Mars', 4 => 'Avril',
            5 => 'Mai', 6 => 'Juin', 7 => 'Juillet', 8 => 'Août',
            9 => 'Septembre', 10 => 'Octobre', 11 => 'Novembre', 12 => 'Décembre'
        ];

        $total = 0;

        foreach ($previsions as $prev) {
            $moisNom = $moisNoms[(int)$prev['mois']] ?? $prev['mois'];
            
            // Évite MultiCell ici, car elle casse le tableau
            $pdf->Cell(60, 10, utf8_decode($moisNom), 1);
            $pdf->Cell(40, 10, $prev['annee'], 1);
            $pdf->Cell(60, 10, number_format($prev['montantFinal'], 2) . ' Ar', 1);
            $pdf->Ln();

            $total += $prev['montantFinal'];
        }
    
        // 7. Total général
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(100, 10, utf8_decode('Total à rembourser'), 1);
        $pdf->Cell(60, 10, number_format($total, 2) . ' Ar', 1);
        $pdf->Ln();
    
        // 8. Sortie PDF
        $pdf->Output('I', 'resume_pret_' . $idPret . '.pdf');
        exit;
    }
    
}
