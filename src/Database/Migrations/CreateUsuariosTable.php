<?php

namespace Biblioteca\Database\Migrations;

use Biblioteca\Database;

class CreateUsuariosTable
{
    public static function up()
    {
        $sql = "CREATE TABLE IF NOT EXISTS usuarios (
            id_usuario BIGINT AUTO_INCREMENT PRIMARY KEY,
            nome VARCHAR(100) NOT NULL,
            email VARCHAR(100) NOT NULL UNIQUE,
            senha VARCHAR(255) NOT NULL,
            tipo_usuario ENUM('administrador', 'usuario_comum') NOT NULL,
            telefone VARCHAR(20),
            endereco TEXT
        )";

        $db = new Database();
        $db->getPdo()->exec($sql);
    }

    public static function down()
    {
        $pdo = new Database()->getPdo();
        $pdo->exec("DROP TABLE IF EXISTS usuarios");
    }
}