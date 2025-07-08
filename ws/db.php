<?php
function getDB() {
    $host = 'localhost';
    $dbname = 'banque';
    $username = 'root';
    $password = '';

    //  'host' => '172.80.237.54',
		//  'dbname' => 'db_s2_ETU003160',
		//  'user' => 'ETU003160',
		//  'password' => 'RdqUSZBu

    try {
        return new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
    } catch (PDOException $e) {
        die(json_encode(['error' => $e->getMessage()]));
    }
}
