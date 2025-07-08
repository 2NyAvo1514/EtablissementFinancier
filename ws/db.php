<?php
function getDB() {
    $host = 'localhost';
    $dbname = 'banque';
    $username = 'root';
    $password = '';

    // $host = '172.60.0.17';
    // $host = 'localhost';
    // $dbname = 'db_s2_ETU003160';
    // $username = 'ETU003160';
    // $password = 'RdqUSZBu';


    try {
        return new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
    } catch (PDOException $e) {
        die(json_encode(['error' => $e->getMessage()]));
    }
}
