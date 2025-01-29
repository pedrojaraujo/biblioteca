<?php

namespace Biblioteca\Controllers;

use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Biblioteca\Database;
use JetBrains\PhpStorm\NoReturn;
use PDO;

class AuthController
{
    private mixed $secretKey;
    private \Smarty\Smarty $smarty;

    /**
     * @throws Exception
     */
    public function __construct()
    {
        $this->smarty = getSmarty();
        $this->secretKey = $_ENV['JWT_SECRET_KEY'];
        if (!$this->secretKey) {
            throw new Exception('Chave secreta JWT não definida. Verifique o arquivo .env.');
        }
    }

    /**
     * @throws \Smarty\Exception
     */
    public function showLoginPage(): void
    {
        $this->smarty->display('auth/login.tpl');
    }

    public function login(): void
    {
        $logFile = __DIR__ . '/../../logs/auth.log';
        file_put_contents($logFile, "\n=== Início do processo de login ===\n", FILE_APPEND);
        file_put_contents($logFile, "URI: " . $_SERVER['REQUEST_URI'] . "\n", FILE_APPEND);
        file_put_contents($logFile, "Método: " . $_SERVER['REQUEST_METHOD'] . "\n", FILE_APPEND);
        
        // Garantir que a resposta seja JSON
        header('Content-Type: application/json');
        
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $input = file_get_contents('php://input');
        file_put_contents($logFile, "Dados brutos recebidos: " . $input . "\n", FILE_APPEND);

        $data = json_decode($input, true);
        file_put_contents($logFile, "Dados decodificados: " . print_r($data, true) . "\n", FILE_APPEND);

        $email = $data['email'] ?? null;
        $senha = $data['senha'] ?? null;

        file_put_contents($logFile, "Tentando login com email: $email\n", FILE_APPEND);

        try {
            $db = new Database();
            $pdo = $db->getPdo();
            
            $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = :email");
            $stmt->execute(['email' => $email]);
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

            file_put_contents($logFile, "Usuário encontrado: " . ($usuario ? 'SIM' : 'NÃO') . "\n", FILE_APPEND);
            if ($usuario) {
                file_put_contents($logFile, "Dados do usuário: " . print_r($usuario, true) . "\n", FILE_APPEND);
                $senhaValida = password_verify($senha, $usuario['senha']);
                file_put_contents($logFile, "Senha válida: " . ($senhaValida ? 'SIM' : 'NÃO') . "\n", FILE_APPEND);
            }

            if ($usuario && password_verify($senha, $usuario['senha'])) {
                $payload = [
                    'iss' => 'http://localhost:8000',
                    'aud' => 'http://localhost:8000',
                    'iat' => time(),
                    'exp' => time() + (60 * 60),
                    'user' => $email,
                    'role' => $usuario['tipo_usuario'],
                    'id_usuario' => $usuario['id_usuario']
                ];

                $jwt = JWT::encode($payload, $this->secretKey, 'HS256');

                // Armazenar o token na sessão
                $_SESSION['jwt_token'] = $jwt;
                error_log("Token armazenado na sessão: " . $jwt);

                http_response_code(200);
                echo json_encode(['token' => $jwt]);
            } else {
                http_response_code(401);
                echo json_encode(['error' => 'Credenciais inválidas']);
            }
        } catch (Exception $e) {
            file_put_contents($logFile, "Erro durante o login: " . $e->getMessage() . "\n", FILE_APPEND);
            file_put_contents($logFile, "Stack trace: " . $e->getTraceAsString() . "\n", FILE_APPEND);
            http_response_code(500);
            echo json_encode(['error' => 'Erro ao processar o login']);
        }
    }

    /**
     * @throws \Smarty\Exception
     */
    #[NoReturn] public function logout(): void
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

    public function validateToken(): false|\stdClass
    {
        error_log("\n=== Validando Token ===");
        
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['jwt_token'])) {
            error_log("Token não encontrado na sessão");
            return false;
        }

        $token = $_SESSION['jwt_token'];
        error_log("Token encontrado: " . $token);

        try {
            $decoded = JWT::decode($token, new Key($this->secretKey, 'HS256'));
            error_log("Token decodificado com sucesso: " . print_r($decoded, true));
            return $decoded;
        } catch (Exception $e) {
            error_log("Erro ao decodificar token: " . $e->getMessage());
            return false;
        }
    }

    public function getUserIdByEmail($email)
    {
        // Fetch the user ID from the database using the email
        $db = new Database();
        $pdo = $db->getPdo();
        $stmt = $pdo->prepare('SELECT id_usuario FROM usuarios WHERE email = :email');
        $stmt->execute(['email' => $email]);
        $usuario = $stmt->fetch(PDO::FETCH_OBJ);
        return $usuario ? $usuario->id_usuario : null;
    }

    /**
     * @throws \Smarty\Exception
     */
    private function setError($message): void
    {
        $this->smarty->assign('error', $message);
        $this->smarty->display('error.tpl');
    }
}
