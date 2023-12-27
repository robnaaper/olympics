<?php

require 'vendor/autoload.php';
require 'core/DatabaseSingleton.php';


use core\DatabaseSingleton;

$pdo = (DatabaseSingleton::getInstance())->getPDO();

$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$sql = "CREATE INDEX idx_weight ON sportsmen(weight)";

try {
    $pdo->exec($sql);
    echo "Migration successful: Added index on 'weight' column in the 'sportsmen' table.\n";
} catch (PDOException $e) {
    echo "Error during migration: " . $e->getMessage() . "\n";
}
