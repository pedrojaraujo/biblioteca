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
        $stmt = $this->pdo->query("SELECT * FROM books");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addBook($title, $author)
    {
        $stmt = $this->pdo->prepare("INSERT INTO books (title, author) VALUES (:title, :author)");
        $stmt->execute(['title' => $title, 'author' => $author]);
    }

    public function updateBook($id, $title, $author)
    {
        $stmt = $this->pdo->prepare("UPDATE books SET title = :title, author = :author WHERE id = :id");
        $stmt->execute(['id' => $id, 'title' => $title, 'author' => $author]);
    }

    public function deleteBook($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM books WHERE id = :id");
        $stmt->execute(['id' => $id]);
    }
}
