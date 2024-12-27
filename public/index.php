<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

use Biblioteca\Router\Router;
use Biblioteca\Controllers\BookController;
use Biblioteca\Controllers\AuthController;

$router = new Router();

$router->add('/login', [new AuthController(), 'login'], 'POST');
$router->add('/', [new BookController(), 'index']);
$router->add('/add-book', [new BookController(), 'addBook'], 'POST');
$router->add('/update-book', [new BookController(), 'updateBook'], 'PUT');
$router->add('/delete-book', [new BookController(), 'deleteBook'], 'DELETE');

$uri = $_SERVER['PATH_INFO'] ?? '/';
$method = $_SERVER['REQUEST_METHOD'];

$router->dispatch($uri, $method);
