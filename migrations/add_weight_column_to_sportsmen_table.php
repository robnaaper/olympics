<?php

require 'vendor/autoload.php';
require 'core/DatabaseSingleton.php';

use core\DatabaseSingleton;

$pdo = (DatabaseSingleton::getInstance())->getPDO();

$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$sql = "ALTER TABLE sportsmen ADD COLUMN weight DECIMAL(5,2) DEFAULT NULL";

try {
    $pdo->exec($sql);
    echo "Migration successful: Added 'weight' column with default NULL to the 'sportsmen' table.\n";
} catch (PDOException $e) {
    echo "Error during migration: " . $e->getMessage() . "\n";
}
