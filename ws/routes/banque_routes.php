<?php
require_once __DIR__ . '/../controllers/ClientController.php';
require_once __DIR__ . '/../controllers/TypeClientController.php';
require_once __DIR__ . '/../controllers/DashboardController.php';
require_once __DIR__ . '/../controllers/TauxController.php';
require_once __DIR__ . '/../controllers/TypePretController.php';
require_once __DIR__ . '/../controllers/FondController.php';
require_once __DIR__ . '/../controllers/AssuranceController.php';
require_once __DIR__ . '/../controllers/RemboursementController.php';
require_once __DIR__ . '/../controllers/ValidationController.php';
require_once __DIR__ . '/../controllers/DelaiController.php';
require_once __DIR__ . '/../controllers/PretController.php';
require_once __DIR__ . '/../controllers/ComparaisonController.php';
require_once __DIR__ . '/../controllers/SimulationController.php';



Flight::route('GET /clients', ['ClientController', 'getAll']);
Flight::route('GET /clients/@num', ['ClientController', 'getByNum']);

Flight::route('GET /clients/@id', ['ClientController', 'getById']);
Flight::route('POST /clients', ['ClientController', 'create']);
Flight::route('PUT /clients/@id', ['ClientController', 'update']);
Flight::route('DELETE /clients/@id', ['ClientController', 'delete']);

Flight::route('GET /typeClients', ['TypeClientController', 'getAll']);
Flight::route('GET /typeClients/@id', ['TypeClientController', 'getById']);
Flight::route('DELETE /typeClients/@id', ['TypeClientController', 'delete']);

Flight::route('GET /dashboard/interets', ['DashboardController', 'getInteretsInterval']);
Flight::route('GET /dashboard/interetsRealisation', ['DashboardController', 'getInteretsRealisationInterval']);


Flight::route('GET /typePret', ['TypePretController', 'getAll']);
Flight::route('GET /typePret/@id', ['TypePretController', 'getById']);
Flight::route('POST /taux', ['TauxController', 'create']);
Flight::route('GET /lastTaux', ['TauxController', 'getLastTaux']);


Flight::route('POST /fond', ['FondController', 'create']);

Flight::route('POST /assurance', ['AssuranceController', 'create']);
Flight::route('GET /lastAssurance', ['AssuranceController', 'getLastAssurance']);


Flight::route('POST /remboursements', ['RemboursementController', 'create']);

Flight::route('GET /listPret', ['ValidationController', 'getAllInvalid']);
Flight::route('GET /validation/@idPret/@dateValidation', ['ValidationController', 'valider']);
Flight::route('GET /rejet/@idPret/@dateValidation', ['ValidationController', 'rejetter']);
Flight::route('GET /listValide', ['ValidationController', 'getAllValide']);
Flight::route('GET /genererPDF/@idPret', ['ValidationController', 'genererPDF']);


Flight::route('POST /delais', ['DelaiController', 'create']);
Flight::route('GET /lastDelais', ['DelaiController', 'getLastDelai']);

$Pctrl = new PretController();
Flight::route('GET /client',['PretController','goToPret']);
Flight::route('GET /typePret',['PretController','getTypesPret']);
Flight::route('POST /pret', ['PretController', 'executePret']);


Flight::route('GET /comparaison',['ComparaisonController','getSimulation']);
Flight::route('GET /simulations/@id', ['ComparaisonController', 'getSimulationById']);


Flight::route('POST /simulation',['SimulationController','createSimulation']) ;
Flight::route('GET /taux',['TauxController','prendreTaux']);