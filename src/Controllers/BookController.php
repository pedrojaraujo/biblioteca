<?php

namespace Biblioteca\Controllers;

use Biblioteca\Models\Book;
use Biblioteca\Controllers\AuthController;

class BookController
{
    private $bookModel;
    private $auth;

    public function __construct()
    {
        $this->bookModel = new Book();
        $this->auth = new AuthController();
    }

    private function requireAuth()
    {
        $decoded = $this->auth->validateToken();
        if (!$decoded) {
            http_response_code(401);
            $this->jsonResponse(['error' => 'Login não está ativo']);
            return false;
        }
        return true;
    }

    public function index()
    {
        if (!$this->requireAuth()) {
            return;
        }

        $books = $this->bookModel->getAllBooks();
        $this->jsonResponse($books);
    }

    public function addBook()
    {
        if (!$this->requireAuth()) {
            return;
        }

        $data = json_decode(file_get_contents('php://input'), true);

        if (!$this->validateBookData($data)) {
            $this->jsonResponse(['error' => 'Dados inválidos']);
            return;
        }

        if (isset($data[0]) && is_array($data[0])) {
            foreach ($data as $book) {
                $this->bookModel->addBook($book['title'], $book['author']);
            }
            $this->jsonResponse(['message' => 'Livros adicionados com sucesso!']);
        } else {
            $this->bookModel->addBook($data['title'], $data['author']);
            $this->jsonResponse(['message' => 'Livro adicionado com sucesso!']);
        }
    }

    public function updateBook()
    {
        if (!$this->requireAuth()) {
            return;
        }

        $data = json_decode(file_get_contents('php://input'), true);

        if (!$this->validateBookData($data)) {
            $this->jsonResponse(['error' => 'Dados inválidos']);
            return;
        }

        if (isset($data[0]) && is_array($data[0])) {
            foreach ($data as $book) {
                $this->bookModel->updateBook($book['id'], $book['title'], $book['author']);
            }
            $this->jsonResponse(['message' => 'Livros atualizados com sucesso!']);
        } else {
            $this->bookModel->updateBook($data['id'], $data['title'], $data['author']);
            $this->jsonResponse(['message' => 'Livro atualizado com sucesso!']);
        }
    }

    public function deleteBook()
    {
        if (!$this->requireAuth()) {
            return;
        }

        $data = json_decode(file_get_contents('php://input'), true);

        if (!$this->validateBookData($data, true)) {
            $this->jsonResponse(['error' => 'Dados inválidos']);
            return;
        }

        if (isset($data[0]) && is_array($data[0])) {
            foreach ($data as $book) {
                $this->bookModel->deleteBook($book['id']);
            }
            $this->jsonResponse(['message' => 'Livros deletados com sucesso!']);
        } else {
            $this->bookModel->deleteBook($data['id']);
            $this->jsonResponse(['message' => 'Livro deletado com sucesso!']);
        }
    }

    private function validateBookData($data, $isDelete = false)
    {
        if (is_array($data[0])) {
            foreach ($data as $book) {
                if ($isDelete) {
                    if (empty($book['id'])) {
                        return false;
                    }
                } else {
                    if (empty($book['title']) || empty($book['author'])) {
                        return false;
                    }
                }
            }
        } else {
            if ($isDelete) {
                if (empty($data['id'])) {
                    return false;
                }
            } else {
                if (empty($data['title']) || empty($data['author'])) {
                    return false;
                }
            }
        }
        return true;
    }

    private function jsonResponse($data)
    {
        header('Content-Type: application/json');
        echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }
}
