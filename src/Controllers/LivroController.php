<?php

namespace Biblioteca\Controllers;

use Biblioteca\Models\Livro;
use Biblioteca\Controllers\AuthController;
use DateTime;
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
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['jwt_token'])) {
            // Log para debug
            error_log("JWT Token não encontrado na sessão");
            return false;
        }

        try {
            $decoded = $this->auth->validateToken();
            if (!$decoded) {
                error_log("Token inválido");
                return false;
            }
            error_log("Token validado com sucesso: " . print_r($decoded, true));
            return true;
        } catch (\Exception $e) {
            error_log("Erro na validação do token: " . $e->getMessage());
            return false;
        }
    }

    private
    function validateBookData($data, $isDelete = false): bool
    {
        if (is_array($data)) {
            if (isset($data[0]) && is_array($data[0])) {
                foreach ($data as $livro) {
                    if ($isDelete) {
                        if (empty($livro['id_livro'])) {
                            return false;
                        }
                    } else {
                        if (empty($livro['titulo']) || empty($livro['autor']) || empty($livro['editora']) ||
                            empty($livro['genero']) || empty($livro['sinopse']) || empty($livro['imagem']) ||
                            !isset($livro['estoque'])) {
                            return false;
                        }
                    }
                }
            } else {
                if ($isDelete) {
                    if (empty($data['id_livro'])) {
                        return false;
                    }
                } else {
                    if (empty($data['titulo']) || empty($data['autor']) || empty($data['editora']) ||
                        empty($data['genero']) || empty($data['sinopse']) || empty($data['imagem']) ||
                        !isset($data['estoque'])) {
                        return false;
                    }
                }
            }
        } else {
            return false;
        }
        return true;
    }


    private
    function jsonResponse(array $data, int $statusCode = 200)
    {
        // Configurar o código de status HTTP
        http_response_code($statusCode);

        // Configurar o cabeçalho para JSON com charset UTF-8
        header('Content-Type: application/json; charset=utf-8');

        // Retornar o JSON formatado
        echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

        // Finalizar a execução
        exit;
    }

    private function redirect(string $url)
    {
        header('Location: ' . $url);
        exit;
    }

    private
    function extracted($data, $isDelete): bool
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

    public function index()
    {
        error_log("\n=== Início do método index() ===");
        
        if (!$this->requireAuth()) {
            error_log("Autenticação falhou - redirecionando para login");
            header('Location: /login');
            exit;
        }

        try {
            $decoded = $this->auth->validateToken();
            error_log("Token decodificado: " . print_r($decoded, true));
            
            $tipo_usuario = $decoded->role;
            $id_usuario = $decoded->id_usuario;

            error_log("Usuário autenticado - Tipo: $tipo_usuario, ID: $id_usuario");
            error_log("Tentando carregar template: livros/lista.tpl");

            $livros = $this->livroModel->getAllBooks();
            error_log("Livros carregados: " . count($livros));
            
            // Debug dos dados
            error_log("Dados para o template:");
            error_log("tipo_usuario: " . $tipo_usuario);
            error_log("id_usuario: " . $id_usuario);
            error_log("livros: " . print_r($livros, true));

            $this->smarty->assign('tipo_usuario', $tipo_usuario);
            $this->smarty->assign('livros', $livros);
            $this->smarty->assign('id_usuario', $id_usuario);

            // Verificar se o template existe
            $templatePath = $this->smarty->getTemplateDir()[0] . 'livros/lista.tpl';
            error_log("Verificando se o template existe em: " . $templatePath);
            if (!file_exists($templatePath)) {
                error_log("ERRO: Template não encontrado em: " . $templatePath);
                throw new \Exception("Template não encontrado: livros/lista.tpl");
            } else {
                error_log("Template encontrado. Conteúdo:");
                error_log(file_get_contents($templatePath));
            }

            error_log("Template encontrado, tentando exibir...");
            $this->smarty->display('livros/lista.tpl');
            error_log("Template carregado com sucesso");
        } catch (\Exception $e) {
            error_log("Erro ao carregar página de livros: " . $e->getMessage());
            error_log("Stack trace: " . $e->getTraceAsString());
            throw $e;
        }
    }

    public function viewBook($id)
    {
        if (!$this->requireAuth()) {
            header('Location: /login');
            exit;
        }

        $livro = $this->livroModel->getBookById($id);
        if (!$livro) {
            $this->redirect('/livros');
            return;
        }

        $this->smarty->assign('livro', $livro);
        $this->smarty->display('livros/view.tpl');
    }

    public function createBook()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $_POST;
            if (!$this->validateBookData($data)) {
                $this->jsonResponse(['success' => false, 'message' => 'Dados inválidos']);
                return;
            }
            $this->livroModel->addBook(
                $data['titulo'], $data['autor'], $data['editora'], $data['ano_publicacao'],
                $data['genero'], $data['sinopse'], $data['imagem'], $data['estoque'], $data['palavras_chave']
            );
            $this->jsonResponse(['success' => true, 'message' => 'Livro criado com sucesso!']);
        }
    }

    public function editBook($id)
    {
        if (!$this->requireAuth()) {
            header('Location: /login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $livro = $this->livroModel->getBookById($id);
            if (!$livro) {
                $this->smarty->assign('error', 'Livro não encontrado');
                $this->smarty->display('error.tpl');
                return;
            }
            $this->smarty->assign('livro', $livro);
            $this->smarty->display('livros/editar.tpl');
        } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $_POST;

            // Log data to a file for debugging
            file_put_contents(__DIR__ . '/../log/error.log', print_r($data, true), FILE_APPEND);

            if (!$this->validateBookData($data)) {
                $this->smarty->assign('error', 'Dados inválidos');
                $livro = $this->livroModel->getBookById($id);
                $this->smarty->assign('livro', $livro);
                $this->smarty->display('livros/editar.tpl');
                return;
            }
            $this->livroModel->updateBook(
                $id, $data['titulo'], $data['autor'], $data['editora'], $data['ano_publicacao'],
                $data['genero'], $data['sinopse'], $data['imagem'], $data['estoque'], $data['palavras_chave']
            );
            $this->smarty->assign('message', 'Livro atualizado com sucesso!');
            $livro = $this->livroModel->getBookById($id);
            $this->smarty->assign('livro', $livro);
            $this->smarty->display('livros/editar.tpl');
        }
    }

    public function deleteBook()
    {
        if (!$this->requireAuth()) {
            return;
        }

        $data = json_decode(file_get_contents('php://input'), true);

        if (isset($data['id_livro'])) {
            $this->livroModel->deleteBook($data['id_livro']);
            $this->jsonResponse(['success' => true, 'message' => 'Livro deletado com sucesso!']);
        } else {
            $this->jsonResponse(['success' => false, 'message' => 'ID do livro não fornecido']);
        }
    }

    public function borrowLivro($id)
    {
        // Garantir autenticação
        if (!$this->requireAuth()) {
            $this->jsonResponse(['success' => false, 'message' => 'Usuário não autenticado.'], 401);
        }

        // Buscar o livro pelo ID
        $livro = $this->livroModel->getBookById($id);

        if ($livro) {
            // Validar token e obter o ID do usuário
            $decoded = $this->auth->validateToken();
            if (!isset($decoded->id_usuario)) {
                $decoded->id_usuario = $this->auth->getUserIdByEmail($decoded->usuario);
            }

            $id_usuario = $decoded->id_usuario;

            // Calcular data de devolução prevista
            $data_devolucao_prevista = (new DateTime('+30 days'))->format('Y-m-d');

            // Reservar o livro
            $this->livroModel->reserveBook($id, $id_usuario, $data_devolucao_prevista);

            // Responder com sucesso
            $this->jsonResponse(['success' => true, 'message' => 'Livro reservado com sucesso!']);
        } else {
            // Livro não encontrado
            $this->jsonResponse(['success' => false, 'message' => 'Livro não encontrado.'], 404);
        }
    }

    public function confirmReservations()
    {
        if (!$this->requireAuth()) {
            header('Location: /login');
            exit;
        }

        $data = json_decode(file_get_contents('php://input'), true);
        $decoded = $this->auth->validateToken();
        $id_usuario = $decoded->id;

        // Processar reservas
        foreach ($data['reservas'] as $reserva) {
            $this->livroModel->reserveBook($reserva['id'], $id_usuario, $reserva['data_reserva']);
        }

        $this->jsonResponse(['success' => true, 'message' => 'Reservas confirmadas com sucesso!']);
    }

    public function getUserReservations()
    {
        if (!$this->requireAuth()) {
            header('Location: /login');
            exit;
        }

        $decoded = $this->auth->validateToken();
        $id_usuario = $decoded->id_usuario;

        $reservas = $this->livroModel->getReservationsByUserId($id_usuario);
        $this->jsonResponse(['success' => true, 'reservas' => $reservas]);
    }

    public function showCart()
    {
        if (!$this->requireAuth()) {
            header('Location: /login');
            exit;
        }

        $maxDate = (new DateTime('+30 days'))->format('Y-m-d');
        $this->smarty->assign('maxDate', $maxDate);

        $this->smarty->display('livros/carrinho.tpl');
    }

    public function deleteReservation()
    {
        if (!$this->requireAuth()) {
            $this->jsonResponse(['success' => false, 'message' => 'Usuário não autenticado.'], 401);
            return;
        }

        $data = json_decode(file_get_contents('php://input'), true);

        if (isset($data['id'])) {
            $this->livroModel->deleteReservation($data['id']);
            $this->jsonResponse(['success' => true, 'message' => 'Reserva deletada com sucesso!']);
        } else {
            $this->jsonResponse(['success' => false, 'message' => 'ID da reserva não fornecido']);
        }
    }

}