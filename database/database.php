<?php
namespace database;

define('__ROOT__', dirname(dirname(__FILE__)));
require_once(__ROOT__ . '/db/config.php');

use PDO;
use PDOException;

class Database {
    private $conn;

    public function __construct() {
        $this->connect();
    }

    protected function connect() {
        $config = DATABASE;

        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // Nastavujú sa možnosti PDO:
        ];

        try {
            $this->conn = new PDO(
                'mysql:host=' . $config['HOST'] .
                ';dbname=' . $config['DBNAME'] .
                ';port=' . $config['PORT'],
                $config['USER_NAME'],
                $config['PASSWORD'],
                $options
            );
        } catch (PDOException $e) {
            die("Chyba pripojenia: " . $e->getMessage());
        }
    }

    public function getConnection() {
        return $this->conn;
    }
}
