<?php

namespace Biblioteca\Database\Migrations;

use Biblioteca\Database;

class CreateUsuariosTable
{
    public static function up()
    {
        $pdo = (new Database())->getPdo();
        $sql = "CREATE TABLE IF NOT EXISTS usuarios (
            id_usuario BIGINT AUTO_INCREMENT PRIMARY KEY,
            nome VARCHAR(255) NOT NULL,
            email VARCHAR(255) NOT NULL UNIQUE,
            senha VARCHAR(255) NOT NULL,
            tipo_usuario ENUM('administrador','bibliotecario','usuario_comum') NOT NULL,
            telefone VARCHAR(255) NULL,
            endereco VARCHAR(255) NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            deleted_at TIMESTAMP NULL DEFAULT NULL
        )";
        $pdo->exec($sql);
    }

    public static function down()
    {
        $pdo = (new Database())->getPdo();
        $pdo->exec("DROP TABLE IF EXISTS usuarios");
    }
}