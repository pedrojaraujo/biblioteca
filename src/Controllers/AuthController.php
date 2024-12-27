<?php

namespace Biblioteca\Controllers;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Biblioteca\Database;
use PDO;

class AuthController
{
    private $secretKey = "MINHA_CHAVE_SECRETA";

    public function login()
    {

        $data = json_decode(file_get_contents('php://input'), true);
        $username = $data['user'] ?? null;
        $password = $data['pass'] ?? null;


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
            header('Content-Type: application/json');
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
        [$bearer, $token] = explode(' ', $authHeader);

        if ($bearer !== 'Bearer' || empty($token)) {
            return false;
        }

        try {
            $decoded = JWT::decode($token, new Key($this->secretKey, 'HS256'));
            return $decoded;
        } catch (\Exception $e) {
            http_response_code(401);
            echo json_encode(['error' => 'Token inválido ou expirado']);
            return false;
        }
    }
}
