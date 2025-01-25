<?php

namespace Biblioteca\Controllers;

use Biblioteca\Models\Livro;
use Biblioteca\Controllers\AuthController;
use Smarty\Exception;

class LivroController
{
    private $livroModel;
    private $auth;
    private $smarty;

    public function __construct()
    {
        $this->livroModel = new Livro();
        $this->auth = new AuthController();
        $this->smarty = getSmarty();
    }

    /**
     * @throws Exception
     */
    private function requireAuth()
    {
        $decoded = $this->auth->validateToken();
        if (!$decoded) {
            http_response_code(401);
            $this->smarty->assign('error', 'Login não está ativo');
            $this->smarty->display('error.tpl');
            return false;
        }
        return true;
    }

    public function index()
    {
        if (!$this->requireAuth()) {
            return;
        }

        $livros = $this->livroModel->getAllBooks();
        $this->smarty->assign('livros', $livros);
        $this->smarty->display('livros/lista.tpl');
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
            foreach ($data as $livro) {
                $this->livroModel->addBook($livro['titulo'], $livro['autor']);
            }
            $this->jsonResponse(['message' => 'Livros adicionados com sucesso!']);
        } else {
            $this->livroModel->addBook($data['titulo'], $data['autor']);
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
            $this->smarty->assign('error', 'Dados inválidos');
            $this->smarty->display('error.tpl');
            return;
        }

        if (isset($data[0]) && is_array($data[0])) {
            foreach ($data as $livro) {
                $this->livroModel->updateBook($livro['id'], $livro['titulo'], $livro['autor']);
            }
            $this->smarty->assign('message', 'Livros atualizados com sucesso!');
        } else {
            $this->livroModel->updateBook($data['id'], $data['titulo'], $data['autor']);
            $this->smarty->assign('message', 'Livro atualizado com sucesso!');
        }

        $this->smarty->display('success.tpl');
    }

    public function deleteBook()
    {
        if (!$this->requireAuth()) {
            return;
        }

        $data = json_decode(file_get_contents('php://input'), true);

        if (!$this->validateBookData($data, true)) {
            $this->smarty->assign('error', 'Dados inválidos');
            $this->smarty->display('error.tpl');
            return;
        }

        if (isset($data[0]) && is_array($data[0])) {
            foreach ($data as $book) {
                $this->livroModel->deleteBook($book['id']);
            }
            $this->smarty->assign('message', 'Livros deletados com sucesso!');
        } else {
            $this->livroModel->deleteBook($data['id']);
            $this->jsonResponse(['message' => 'Livro deletado com sucesso!']);
        }

        $this->smarty->display('success.tpl');
    }

    private function validateBookData($data, $isDelete = false)
    {
        if (is_array($data[0])) {
            foreach ($data as $livro) {
                if ($isDelete) {
                    if (empty($livro['id'])) {
                        return false;
                    }
                } else {
                    if (empty($livro['titulo']) || empty($livro['autor'])) {
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
                if (empty($data['titulo']) || empty($data['autor'])) {
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
