<?php
require_once __DIR__ . '/../models/PretModel.php';

class PretController {

    public static function goToPret() {
        Flight::redirect('../test.php');
    }

    public static function getTypesPret() {
        $typesPret = PretModel::getAll();
        Flight::json($typesPret);
    }

    public static function executePret() {
        $data = Flight::request()->data;

        $nom = $data->nom ?? null;
        $numId = $data->numId ?? null;
        $montant = (float)($data->montant ?? 0);
        $duree = (int)($data->duree ?? 0);
        $typePret = $data->typePret ?? null;
        $datePret = $data->datePret ?? null;
        $descri = $data->descri ?? null;

        if (!$nom || !$numId || !$typePret || !$datePret || $montant <= 0 || $duree <= 0) {
            Flight::json(['error' => 'Champs invalides'], 400);
            return;
        }

        $client = PretModel::getClient($nom, $numId);
        if (!$client) {
            Flight::json(['error' => 'Client introuvable'], 404);
            return;
        }

        $soldeData = PretModel::getSolde();
        $solde = (float)($soldeData['solde'] ?? 0);

        if ($montant > $solde) {
            Flight::json(['error' => 'Solde insuffisant'], 400);
            return;
        }

        // Création du payload prêt
        $payload = (object)[
            'typePret' => $typePret,
            'montant' => $montant,
            'id' => $client['id'],
            'datePret' => $datePret,
            'duree' => $duree,
            'descri' => $descri
        ];

        // Insertion du prêt
        $idPret = PretModel::insererPret($payload);

        // Vérification et récupération du prêt inséré
        $pretCree = PretModel::getPretByData($payload);
        if (!$pretCree) {
            Flight::json(['error' => 'Prêt non retrouvé après insertion'], 500);
            return;
        }

        // Insertion de l'historique du prêt
        $donnees = (object)[
            'idPret' => $idPret,
            'statut' => 0,
            'date' => $datePret
        ];
        PretModel::insererHistoriquePret($donnees);

        Flight::json(['message' => 'Prêt effectué avec succès']);
    }
}
