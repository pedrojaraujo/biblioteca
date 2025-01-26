<?php

namespace Biblioteca\Models;

use Biblioteca\Database;
use PDO;

class Livro
{
    private $pdo;


    public function __construct()
    {
        $this->pdo = (new Database())->getPdo();
    }

    public static function find($id)
    {
        $pdo = (new Database())->getPdo();
        $stmt = $pdo->prepare("SELECT * FROM livros WHERE id_livro = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAllBooks()
    {
        $stmt = $this->pdo->query("SELECT * FROM livros");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getBookById($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM livros WHERE id_livro = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function addBook($titulo, $autor, $editora, $ano_publicacao, $genero, $sinopse, $imagem, $estoque, $palavras_chave)
    {
        $stmt = $this->pdo->prepare("
        INSERT INTO livros (titulo, autor, editora, ano_publicacao, genero, sinopse, imagem, estoque, palavras_chave)
        VALUES (:titulo, :autor, :editora, :ano_publicacao, :genero, :sinopse, :imagem, :estoque, :palavras_chave)
    ");
        $stmt->execute([
            'titulo' => $titulo,
            'autor' => $autor,
            'editora' => $editora,
            'ano_publicacao' => $ano_publicacao,
            'genero' => $genero,
            'sinopse' => $sinopse,
            'imagem' => $imagem,
            'estoque' => $estoque,
            'palavras_chave' => $palavras_chave
        ]);
    }

    public function updateBook($id, $titulo, $autor, $editora, $ano_publicacao, $genero, $sinopse, $imagem, $estoque, $palavras_chave)
    {
        $stmt = $this->pdo->prepare("
        UPDATE livros
        SET titulo = :titulo, autor = :autor, editora = :editora, ano_publicacao = :ano_publicacao,
            genero = :genero, sinopse = :sinopse, imagem = :imagem, estoque = :estoque, palavras_chave = :palavras_chave
        WHERE id_livro = :id
    ");
        $stmt->execute([
            'id' => $id,
            'titulo' => $titulo,
            'autor' => $autor,
            'editora' => $editora,
            'ano_publicacao' => $ano_publicacao,
            'genero' => $genero,
            'sinopse' => $sinopse,
            'imagem' => $imagem,
            'estoque' => $estoque,
            'palavras_chave' => $palavras_chave
        ]);
    }

    public function reserveBook($id_livro, $id_usuario, $data_devolucao_prevista)
    {
        $stmt = $this->pdo->prepare("
        INSERT INTO emprestimos (id_livro, id_usuario, data_devolucao_prevista, status)
        VALUES (:id_livro, :id_usuario, :data_devolucao_prevista, 'ativo')
    ");
        $stmt->execute([
            'id_livro' => $id_livro,
            'id_usuario' => $id_usuario,
            'data_devolucao_prevista' => $data_devolucao_prevista
        ]);
    }

    public function getReservationsByUserId($id_usuario)
    {
        $query = "SELECT e.id_emprestimo, l.titulo, l.autor, e.data_devolucao_prevista 
              FROM emprestimos e
              JOIN livros l ON e.id_livro = l.id_livro
              WHERE e.id_usuario = :id_usuario";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id_usuario', $id_usuario);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteBook($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM livros WHERE id_livro = :id_livro");
        $stmt->execute(['id_livro' => $id]);
    }

    public function deleteReservation($id)
    {
        $query = "DELETE FROM emprestimos WHERE id_emprestimo = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }
}