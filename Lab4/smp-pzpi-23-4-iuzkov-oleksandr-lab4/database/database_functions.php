<?php

function createConnection(): PDO {
    $databaseFile = __DIR__ . '/store_database.db';
    $connection = new PDO("sqlite:$databaseFile");
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $connection;
}

function fetchProducts(PDO $connection): array {
    $query = $connection->query("SELECT * FROM products ORDER BY id ASC");
    return $query->fetchAll(PDO::FETCH_ASSOC);
}
