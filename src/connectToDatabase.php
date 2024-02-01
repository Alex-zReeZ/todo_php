<?php

// Vérifie si la fonction existe déjà
if (!function_exists('connectToDatabase')) {
    function connectToDatabase() : PDO
    {
        $dsn = "sqlite:myDb.db";

        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];
        $pdo = new PDO($dsn, null, null, $options);

        return $pdo;
    }
}

$pdo = connectToDatabase();

$errorMessage1 = '';

$query = $pdo->prepare("SELECT * FROM todo");
$query->execute();

/* get content of database */
$row = $query->fetchAll(PDO::FETCH_ASSOC);
