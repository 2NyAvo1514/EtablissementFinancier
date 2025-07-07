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
Flight::route('POST /taux', ['TauxController', 'create']);

Flight::route('POST /fond', ['FondController', 'create']);

Flight::route('POST /assurance', ['AssuranceController', 'create']);

Flight::route('POST /remboursements', ['RemboursementController', 'create']);

Flight::route('GET /listPret', ['ValidationController', 'getAllInvalid']);
Flight::route('GET /validation/@idPret/@dateValidation', ['ValidationController', 'valider']);
Flight::route('GET /rejet/@idPret/@dateValidation', ['ValidationController', 'rejetter']);
Flight::route('GET /listValide', ['ValidationController', 'getAllValide']);
Flight::route('GET /genererPDF/@idPret', ['ValidationController', 'genererPDF']);




