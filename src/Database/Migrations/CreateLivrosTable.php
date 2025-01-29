<?php

namespace Biblioteca\Database\Migrations;

use Biblioteca\Database;

class CreateLivrosTable
{
    public static function up()
    {
        $pdo = (new Database())->getPdo();
        $sql = "CREATE TABLE IF NOT EXISTS livros (
            id_livro BIGINT AUTO_INCREMENT PRIMARY KEY,
            titulo VARCHAR(255) NOT NULL,
            autor VARCHAR(255) NOT NULL,
            editora VARCHAR(255) NOT NULL,
            ano_publicacao SMALLINT NOT NULL,
            genero VARCHAR(255) NOT NULL,
            sinopse TEXT NOT NULL,
            imagem VARCHAR(255) NOT NULL,
            estoque INT NOT NULL DEFAULT 1,
            palavras_chave TEXT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            deleted_at TIMESTAMP NULL DEFAULT NULL
        )";
        $pdo->exec($sql);
    }

    public static function down()
    {
        $pdo = (new Database())->getPdo();
        $pdo->exec("DROP TABLE IF EXISTS livros");
    }
}