<?php

$host = 'db';
$database = 'as1';
$user = 'student';
$password = 'student';

// Connecting to the database
try {
    $pdo = new PDO("mysql:host=$host;dbname=$database;", $user, $password);
    return $pdo;
} catch (PDOException $exception) {
    echo "Failed to connect to database with exception " . $exception->getMessage();
}
