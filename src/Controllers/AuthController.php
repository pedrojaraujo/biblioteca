<?php

namespace Biblioteca\Controllers;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Biblioteca\Database;
use PDO;

class AuthController
{
    private $secretKey;
    private $smarty;

    public function __construct()
    {
        $this->smarty = getSmarty();
        $this->secretKey = $_ENV['JWT_SECRET_KEY'];
        if (!$this->secretKey) {
            throw new \Exception('Chave secreta JWT não definida. Verifique o arquivo .env.');
        }
    }

    public function showLoginPage()
    {
        $this->smarty->display('auth/login.tpl');
    }

    public function login()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // Obter o corpo da requisição JSON
        $input = file_get_contents('php://input');
        $data = json_decode($input, true);

        $email = $data['email'] ?? null;
        $senha = $data['senha'] ?? null;

        if (!$email || !$senha) {
            http_response_code(400);
            echo json_encode(['error' => 'Credenciais incompletas']);
            return;
        }

        $db = new Database();
        $pdo = $db->getPdo();
        $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario && password_verify($senha, $usuario['senha'])) {
            $payload = [
                'iss' => 'http://localhost:8000',
                'aud' => 'http://localhost:8000',
                'iat' => time(),
                'exp' => time() + (60 * 60),
                'user' => $email,
                'role' => $usuario['tipo_usuario']
            ];

            $jwt = JWT::encode($payload, $this->secretKey, 'HS256');

            // Armazenar o token na sessão
            $_SESSION['jwt_token'] = $jwt;
            error_log('JWT Token: ' . $_SESSION['jwt_token']);

            http_response_code(200);
            echo json_encode(['token' => $jwt]);
        } else {
            http_response_code(401);
            echo json_encode(['error' => 'Credenciais inválidas']);
        }
    }

    public function logout()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // Destruir a sessão
        session_destroy();

        // Redirecionar para a página de login
        $this->smarty->display('auth/login.tpl');
        exit;
    }

    public function validateToken()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['jwt_token'])) {
            http_response_code(401);
            echo json_encode(['error' => 'Token inválido ou ausente']);
            exit;
        }

        $token = $_SESSION['jwt_token'];

        try {
            $decoded = JWT::decode($token, new Key($this->secretKey, 'HS256'));
            return $decoded;
        } catch (\Exception $e) {
            http_response_code(401);
            echo json_encode(['error' => 'Falha ao validar token: ' . $e->getMessage()]);
            exit;
        }
    }

    private function setError($message)
    {
        $this->smarty->assign('error', $message);
        $this->smarty->display('error.tpl');
    }
}
