<?php

namespace Biblioteca\Database\Migrations;

use Biblioteca\Database;

class CreateEmprestimosTable
{
    public static function up(): void
    {
        $pdo = (new Database())->getPdo();
        $sql = "CREATE TABLE IF NOT EXISTS emprestimos (
            id_emprestimo BIGINT AUTO_INCREMENT PRIMARY KEY,
            id_livro BIGINT NOT NULL,
            id_usuario BIGINT NOT NULL,
            data_emprestimo TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            data_devolucao_prevista TIMESTAMP NOT NULL,
            data_devolucao_real TIMESTAMP NULL DEFAULT NULL,
            status ENUM('ativo','atrasado','finalizado') NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            deleted_at TIMESTAMP NULL DEFAULT NULL,
            FOREIGN KEY (id_livro) REFERENCES livros(id_livro),
            FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario)
        )";
        $pdo->exec($sql);
    }

    public static function down()
    {
        $pdo = (new Database())->getPdo();
        $pdo->exec("DROP TABLE IF EXISTS emprestimos");
    }
}