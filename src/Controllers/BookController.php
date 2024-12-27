<?php

namespace Biblioteca\Controllers;

use Biblioteca\Models\Book;

class BookController
{
    private $bookModel;

    public function __construct()
    {
        $this->bookModel = new Book();
    }

    public function index()
    {
        $books = $this->bookModel->getAllBooks();
        echo json_encode($books);
    }

    public function addBook()
    {
        $data = json_decode(file_get_contents('php://input'), true);

        if (isset($data[0]) && is_array($data[0])) {

            foreach ($data as $book) {
                $this->bookModel->addBook($book['title'], $book['author']);
            }
            echo json_encode(['message' => 'Livros adicionados com sucesso!']);
        } else {

            $this->bookModel->addBook($data['title'], $data['author']);
            echo json_encode(['message' => 'Livro adicionado com sucesso!']);
        }
    }

    public function updateBook()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $this->bookModel->updateBook($data['id'], $data['title'], $data['author']);
        echo json_encode(['message' => 'Livro atualizado com sucesso!']);
    }

    public function deleteBook()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $this->bookModel->deleteBook($data['id']);
        echo json_encode(['message' => 'Livro deletado com sucesso!']);
    }
}
