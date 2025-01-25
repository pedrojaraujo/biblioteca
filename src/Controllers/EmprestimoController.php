<?php

namespace Biblioteca\Controllers;

use Biblioteca\Models\Emprestimo;
use Biblioteca\Controllers\AuthController;
use Smarty\Exception;

class EmprestimoController
{
    private $emprestimoModel;
    private $auth;
    private $smarty;

    public function __construct()
    {
        $this->emprestimoModel = new Emprestimo();
        $this->auth = new AuthController();
        $this->smarty = getSmarty();
    }


    private function requireAuth()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['jwt_token'])) {
            http_response_code(401);
            header('Location: /login');
            exit;
        }

        $decoded = $this->auth->validateToken();
        if (!$decoded) {
            http_response_code(401);
            header('Location: /login');
            exit;
        }
        return true;
    }

    public function createLoan()
    {
        if (!$this->requireAuth()) {
            return;
        }

        $data = json_decode(file_get_contents('php://input'), true);

        if (empty($data['livro_id']) || empty($data['usuario_id'])) {
            $this->jsonResponse(['error' => 'Dados inválidos']);
            return;
        }

        $this->emprestimoModel->createLoan($data['livro_id'], $data['usuario_id']);
        $this->jsonResponse(['message' => 'Empréstimo criado com sucesso!']);
    }

    public function returnBook()
    {
        if (!$this->requireAuth()) {
            return;
        }

        $data = json_decode(file_get_contents('php://input'), true);

        if (empty($data['emprestimo_id'])) {
            $this->jsonResponse(['error' => 'Dados inválidos']);
            return;
        }

        $this->emprestimoModel->returnBook($data['emprestimo_id']);
        $this->jsonResponse(['message' => 'Livro devolvido com sucesso!']);
    }

    public function listLoans()
    {
        if (!$this->requireAuth()) {
            return;
        }

        $loans = $this->emprestimoModel->getAllLoans();
        $this->smarty->assign('loans', $loans);
        $this->smarty->display('emprestimos/lista.tpl');
    }

    private function jsonResponse($data)
    {
        header('Content-Type: application/json');
        echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }
}