<?php

namespace App\Core;

use PDO;
use PDOException;

class Database
{
    private $pdo;

    public function __construct()
    {
        $config = require __DIR__ . '/../../config/config.php';
        $dsn = "mysql:host={$config['db_host']};dbname={$config['db_name']}";
        
        try {
            $this->pdo = new PDO($dsn, $config['db_user'], $config['db_pass']);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die('Database connection failed: ' . $e->getMessage());
        }
    }

    public function getPdo()
    {
        return $this->pdo;
    }
}