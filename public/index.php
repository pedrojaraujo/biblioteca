<?php
// Configuração de CORS (Global)
header('Access-Control-Allow-Origin: http://localhost:3000');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
header('Access-Control-Allow-Credentials: true');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}

require_once __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

use Biblioteca\Router\Router;
use Biblioteca\Controllers\BookController;
use Biblioteca\Controllers\AuthController;

$router = new Router();

$router->add('/login', [new AuthController(), 'login'], 'POST');
$router->add('/books', [new BookController(), 'index']);
$router->add('/add-book', [new BookController(), 'addBook'], 'POST');
$router->add('/update-book', [new BookController(), 'updateBook'], 'PUT');
$router->add('/delete-book', [new BookController(), 'deleteBook'], 'DELETE');

$uri = $_SERVER['PATH_INFO'] ?? '/';
$method = $_SERVER['REQUEST_METHOD'];

$router->dispatch($uri, $method);
