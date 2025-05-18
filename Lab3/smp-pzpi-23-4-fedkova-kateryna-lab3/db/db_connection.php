<?php

function get_products() {
    $dbPath = __DIR__ . '/shop.db';
    $pdo = new PDO('sqlite:' . $dbPath);
    $statement = $pdo->query("SELECT * FROM products");
    $rows = $statement->fetchAll(PDO::FETCH_ASSOC);
    return $rows;
}
