<?php
require_once __DIR__ . '/../controllers/ValidationController.php';

Flight::route('GET /listPret', ['ValidationController', 'getAllInvalid']);
Flight::route('GET /validation/@idPret/@dateValidation', ['ValidationController', 'valider']);
Flight::route('GET /rejet/@idPret/@dateValidation', ['ValidationController', 'rejetter']);
Flight::route('GET /listValide', ['ValidationController', 'getAllValide']);
Flight::route('GET /genererPDF/@idPret', ['ValidationController', 'genererPDF']);
