<?php

namespace Biblioteca\Database\Migrations;

use Biblioteca\Database;

class CreateLivrosColecoesTable
{
    public static function up()
    {
        $pdo = (new Database())->getPdo();
        $sql = "CREATE TABLE IF NOT EXISTS livros_colecoes (
            id_livro BIGINT NOT NULL,
            id_colecao BIGINT NOT NULL,
            PRIMARY KEY (id_livro, id_colecao),
            FOREIGN KEY (id_livro) REFERENCES livros(id_livro),
            FOREIGN KEY (id_colecao) REFERENCES colecoes(id_colecao)
        )";
        $pdo->exec($sql);
    }

    public static function down()
    {
        $pdo = (new Database())->getPdo();
        $pdo->exec('DROP TABLE IF EXISTS livros_colecoes');
    }
}