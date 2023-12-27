<?php

use core\DatabaseSingleton;

require 'vendor/autoload.php';
require_once 'core/DatabaseSingleton.php';

try {
    $conn = (DatabaseSingleton::getInstance())->getPDO();

    $sqlQuery =
        "CREATE TABLE sportsmen (
            id SERIAL PRIMARY KEY,
            wins_count INTEGER NOT NULL,
            full_name VARCHAR(255) NOT NULL,
            dob DATE NOT NULL ,
            country VARCHAR(255) NOT NULL 
        );
        CREATE TABLE sports (
            id SERIAL PRIMARY KEY,
            unit VARCHAR(255) NOT NULL ,
            title VARCHAR(255) NOT NULL ,
            world_record VARCHAR(255) NOT NULL ,
            olympic_record VARCHAR(255) NOT NULL 
        );
        CREATE TABLE results (
            id SERIAL PRIMARY KEY,
            sportsman_id INTEGER REFERENCES sportsmen(id),
            sport_id INTEGER REFERENCES sports(id),
            title VARCHAR(255) NOT NULL ,
            result VARCHAR(255) NOT NULL ,
            place INTEGER NOT NULL ,
            location VARCHAR(255) NOT NULL ,
            date DATE NOT NULL 
        );";

    $conn->exec($sqlQuery);

    echo "Tables created successfully\n";
}
catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
finally {
    $conn = null;
}