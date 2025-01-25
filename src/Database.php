<?php

namespace Biblioteca;

use PDO;
use PDOException;

class Database
{
    private $pdo;

    public function __construct()
    {
        $config = require __DIR__ . '/config/database.php';
        $db = $config['db'];

        try {
            $this->pdo = new PDO(
                "mysql:host={$db['host']};dbname={$db['dbname']}",
                $db['user'],
                $db['pass']
            );
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Erro na conexão com o banco de dados: " . $e->getMessage());
        }
    }

    public function getPdo()
    {
        return $this->pdo;
    }
}
