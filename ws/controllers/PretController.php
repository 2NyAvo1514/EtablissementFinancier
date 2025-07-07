<?php
require_once __DIR__ . '/../models/PretModel.php';
class PretController{
    public static function goToPret() {
        Flight::redirect('../test.php');
    }

    public static function getTypesPret() {
        $typesPret = PretModel::getAll();
        Flight::json($typesPret);
    }

    /*public static function executePret() {
        // $data = Flight::request()->data ;
        // $client = PretModel::getClient("$data->nom",$data->numId) ;
        // $solde = PretModel::getSolde() ;
        // if(!empty($client) && $solde > $data->montant){
            // PretModel::insererPret($client->id,$data);
            // PretModel::insererHistorique();

            Flight::json(['message'=>'Pret effectu&eacute; !']);
            
        // }else{
        //     Flight::json(['message'=>'Une erreur est survenue ...',var_dump($data)]);
        // }
        // if (!$client) {
        //     Flight::json(['error' => 'Client introuvable.'], 404);
        //     return;
        // }

        // if ($montant <= 0 || $montant > $solde) {
        //     Flight::json(['error' => 'Montant invalide ou solde insuffisant.'], 400);
        //     return;
        // }
        // Flight::json(['message' => 'Prêt effectué avec succès !']);
    }*/
    public static function executePret() {
        $data = Flight::request()->data;

        $nom = $data->nom ?? null;
        $numId = $data->numId ?? null;
        $montant = (float)($data->montant ?? 0);
        $duree = (int)($data->duree ?? 0);

        if (!$nom || !$numId || $montant <= 0 || $duree <= 0) {
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

        $payload = (object)[
            'typePret' => $data->typePret,
            'montant' => $montant,
            'id' => $client['id'],
            'datePret' => $data->datePret,
            'duree' => $duree
        ];

        PretModel::insererPret($payload);
        Flight::json(['message' => 'Prêt effectué avec succès']);
    }
    
}