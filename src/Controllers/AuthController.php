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
        $email = $_POST['email'] ?? null;
        $senha = $_POST['senha'] ?? null;

        var_dump($_POST);


        if (!$email || !$senha) {
            $this->smarty->assign('error', 'Credenciais incompletas');
            $this->showLoginPage();
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
                'role' => $usuario['tipo_usuario'] // Corrigido para 'tipo_usuario'
            ];

            $jwt = JWT::encode($payload, $this->secretKey, 'HS256');
            // Redirecionar ou exibir sucesso
            $this->smarty->assign('login', 'Login bem-sucedido!');
            $this->smarty->assign('token', $jwt);
            $this->smarty->display('livros/lista.html');
            exit;
        } else {
            $this->smarty->assign('error', 'Credenciais inválidas');
            $this->showLoginPage();
        }
    }

    public function validateToken()
    {
        $authHeader = $_SERVER['HTTP_AUTHORIZATION'] ?? '';
        [$bearer, $token] = explode(' ', $authHeader) + [null, null];

        if ($bearer !== 'Bearer' || empty($token)) {
            $this->setError('Token inválido ou ausente');
            return false;
        }

        try {
            $decoded = JWT::decode($token, new Key($this->secretKey, 'HS256'));
            return $decoded;
        } catch (\Exception $e) {
            $this->setError('Falha ao validar token: ' . $e->getMessage());
            return false;
        }
    }

    private function setError($message)
    {
        $this->smarty->assign('error', $message);
        $this->smarty->display('error.tpl');
    }
}
