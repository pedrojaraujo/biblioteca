<?php

namespace Biblioteca\Controllers;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Biblioteca\Database;
use PDO;

class AuthController
{
    private $secretKey;

    public function __construct()
    {
        $this->secretKey = $_ENV['JWT_SECRET_KEY'];
        if (!$this->secretKey) {
            throw new \Exception('Chave secreta JWT não definida. Verifique o arquivo .env.');
        }
    }

    public function login()
    {
        header('Content-Type: application/json'); // Define o cabeçalho padrão como JSON

        $data = json_decode(file_get_contents('php://input'), true);
        $username = $data['user'] ?? null;
        $password = $data['pass'] ?? null;

        if (!$username || !$password) {
            http_response_code(400);
            echo json_encode(['error' => 'Credenciais incompletas']);
            return;
        }

        $db = new Database();
        $pdo = $db->getPdo();
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username AND password = :password");
        $stmt->execute(['username' => $username, 'password' => $password]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            $payload = [
                'iss' => 'http://localhost:8000',
                'aud' => 'http://localhost:8000',
                'iat' => time(),
                'exp' => time() + (60 * 60),
                'user' => $username,
                'role' => $user['role']
            ];

            $jwt = JWT::encode($payload, $this->secretKey, 'HS256');
            echo json_encode(['login' => 'Sucesso!', 'token' => $jwt]);
        } else {
            http_response_code(401);
            echo json_encode(['error' => 'Credenciais inválidas']);
        }
    }


    public function validateToken()
    {
        $headers = getallheaders();
        $authHeader = $headers['Authorization'] ?? '';
        [$bearer, $token] = explode(' ', $authHeader) + [null, null];

        if ($bearer !== 'Bearer' || empty($token)) {
            http_response_code(401);
            echo json_encode(['error' => 'Token inválido ou ausente']);
            return false;
        }

        try {
            $decoded = JWT::decode($token, new Key($this->secretKey, 'HS256'));
            return $decoded;
        } catch (\Exception $e) {
            http_response_code(401);
            echo json_encode(['error' => 'Falha ao validar token']);
            return false;
        }
    }
}
