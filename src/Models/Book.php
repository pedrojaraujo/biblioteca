<?php

namespace Biblioteca\Models;

use Biblioteca\Database;
use PDO;

class Book
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = (new Database())->getPdo();
    }

    public function getAllBooks()
    {
        $stmt = $this->pdo->query("SELECT * FROM livros");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addBook($titulo, $autor)
    {
        $stmt = $this->pdo->prepare("INSERT INTO livros (titulo, autor) VALUES (:titulo, :autor)");
        $stmt->execute(['titulo' => $titulo, 'autor' => $autor]);
    }

    public function updateBook($id, $titulo, $autor)
    {
        $stmt = $this->pdo->prepare("UPDATE livros SET titulo = :titulo, autor = :autor WHERE id = :id");
        $stmt->execute(['id' => $id, 'titulo' => $titulo, 'autor' => $autor]);
    }

    public function deleteBook($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM livros WHERE id = :id");
        $stmt->execute(['id' => $id]);
    }
}
