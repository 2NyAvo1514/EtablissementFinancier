<?php
require_once __DIR__ . '/../controllers/ClientController.php';
require_once __DIR__ . '/../controllers/TypeClientController.php';


Flight::route('GET /clients', ['ClientController', 'getAll']);
Flight::route('GET /clients/@id', ['ClientController', 'getById']);
Flight::route('POST /clients', ['ClientController', 'create']);
Flight::route('PUT /clients/@id', ['ClientController', 'update']);
Flight::route('DELETE /clients/@id', ['ClientController', 'delete']);
Flight::route('GET /clients', ['TypeClientController', 'getAll']);
Flight::route('GET /clients/@id', ['TypeClientController', 'getById']);
Flight::route('DELETE /clients/@id', ['TypeClientController', 'delete']);

Flight::route('GET /typeClients', ['TypeClientController', 'getAll']);
