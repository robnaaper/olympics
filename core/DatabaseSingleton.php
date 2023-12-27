<?php
namespace core;

use PDO;
use PDOException;

require 'vendor/autoload.php';

class DatabaseSingleton {
    private static $instance;
    private $pdo;
    private function __construct() {

        $host = 'localhost';
        $port = '5432';
        $username = '';
        $password = '';
        $dbname = 'olympics';

        try {
            $this->pdo = new PDO("pgsql:host=$host;port=$port;dbname=$dbname;user=$username;password=$password");
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new DatabaseSingleton();
        }

        return self::$instance;
    }
    public function getPDO() {
        return $this->pdo;
    }
}