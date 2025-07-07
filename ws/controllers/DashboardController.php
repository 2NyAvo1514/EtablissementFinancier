<?php
require_once __DIR__ . '/../models/DashboardModel.php';


class DashboardController
{
    public static function getInteretPrevisionInter($mois, $annee)
    {
        $interet = DashboardModel::calculInteretPrevision($mois, $annee);
        Flight::json($interet);
    }

    public static function getInteretRealisationInter($mois, $annee)
    {
        $interet = DashboardModel::calculInteretRealisation($mois, $annee);
        Flight::json($interet);
    }

    public static function getInteretsInterval()
    {
        $q = Flight::request()->query;
        $start = new DateTime($q['ad'] . '-' . $q['md'] . '-01');
        $end = new DateTime($q['af'] . '-' . $q['mf'] . '-01');
        $end->modify('last day of this month');
        $result = [];

        for ($d = clone $start; $d <= $end; $d->modify('+1 month')) {
            $m = (int) $d->format('n');
            $y = (int) $d->format('Y');
            $pret = DashboardModel::getSommeMontantPret($m, $y);
            $final = DashboardModel::getSommeMontantFinal($m, $y);
            $interet = DashboardModel::calculInteretPrevision($m, $y);

            $result[] = [
                'mois' => $m,
                'annee' => $y,
                'interet' => $interet,
                'pret' => $pret,
                'final' => $final
            ];
        }

        Flight::json($result);
    }

        public static function getInteretsRealisationInterval()
    {
        $q = Flight::request()->query;
        $start = new DateTime($q['ad'] . '-' . $q['md'] . '-01');
        $end = new DateTime($q['af'] . '-' . $q['mf'] . '-01');
        $end->modify('last day of this month');
        $result = [];

        for ($d = clone $start; $d <= $end; $d->modify('+1 month')) {
            $m = (int) $d->format('n');
            $y = (int) $d->format('Y');
            $pret = DashboardModel::getSommeMontantPret($m, $y);
            $final = DashboardModel::getSommeMontantRealise($m, $y);
            $interet = DashboardModel::calculInteretPrevision($m, $y);

            $result[] = [
                'mois' => $m,
                'annee' => $y,
                'interet' => $interet,
                'pret' => $pret,
                'final' => $final
            ];
        }

        Flight::json($result);
    }
}
