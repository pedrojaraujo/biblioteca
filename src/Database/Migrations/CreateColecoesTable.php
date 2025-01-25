<?php

namespace Biblioteca\Database\Migrations;

use Biblioteca\Database;

class CreateColecoesTable
{
    public static function up()
    {
        $pdo = (new Database())->getPdo();
        $sql = "CREATE TABLE IF NOT EXISTS colecoes (
            id_colecao BIGINT AUTO_INCREMENT PRIMARY KEY,
            nome VARCHAR(255) NOT NULL,
            descricao TEXT NOT NULL,
            visibilidade ENUM('publico','privado') NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            deleted_at TIMESTAMP NULL DEFAULT NULL
        )";
        $pdo->exec($sql);
    }

    public static function down()
    {
        $pdo = (new Database())->getPdo();
        $pdo->exec('DROP TABLE IF EXISTS colecoes');
    }
}