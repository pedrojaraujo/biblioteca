<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../src/config/smarty.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

// Roteamento básico
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

// Configuração de CORS
if ($method === 'OPTIONS') {
    header('Access-Control-Allow-Origin: http://localhost:3000');
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type, Authorization');
    header('Access-Control-Allow-Credentials: true');
    http_response_code(204);
    exit;
}

try {
    // Rotas da API
    if ($uri === '/login' && $method === 'POST') {
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: http://localhost:3000');
        header('Access-Control-Allow-Methods: POST');
        header('Access-Control-Allow-Headers: Content-Type');
        header('Access-Control-Allow-Credentials: true');

        $controller = new Biblioteca\Controllers\AuthController();
        $controller->login();
        exit;
    }

    // Rotas de página (HTML)
    require_once __DIR__ . '/../src/Router/web.php';

} catch (\Smarty\Exception $e) {
} catch (Exception $e) {
    if (str_starts_with($uri, '/api/')) {
        // Se for uma rota da API, retorna erro em JSON
        header('Content-Type: application/json');
        http_response_code(500);
        echo json_encode(['error' => $e->getMessage()]);
    } else {
        // Se for uma rota de página, mostra o modelo de erro
        $smarty = getSmarty();
        $smarty->assign('error', $e->getMessage());
        $smarty->display('errors/404.tpl');
    }
}