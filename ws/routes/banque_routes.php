<?php
// require_once __DIR__ . '/../controllers/EtudiantController.php';
require_once __DIR__ . '/../controllers/ClientController.php';
require_once __DIR__ . '/../controllers/PretController.php';

// Flight::route('GET /etudiants', ['EtudiantController', 'getAll']);
// Flight::route('GET /etudiants/@id', ['EtudiantController', 'getById']);
// Flight::route('POST /etudiants', ['EtudiantController', 'create']);
// Flight::route('PUT /etudiants/@id', ['EtudiantController', 'update']);
// Flight::route('DELETE /etudiants/@id', ['EtudiantController', 'delete']);
Flight::route('GET /client',['PretController','goToPret']);
Flight::route('GET /typePret',['PretController','getTypesPret']);
Flight::route('POST /pret',['PretController','executePret']);


