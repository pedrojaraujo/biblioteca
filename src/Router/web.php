<?php

use Biblioteca\Router\Router;
use Biblioteca\Controllers\LivroController;
use Biblioteca\Controllers\AuthController;

$router = new Router();

$router->add('/', [new AuthController(), 'showLoginPage']);
$router->add('/login', [new AuthController(), 'login'], 'POST');
$router->add('/livros', [new LivroController(), 'index']);
$router->add('/add-livro', [new LivroController(), 'addBook'], 'POST');
$router->add('/update-livro', [new LivroController(), 'updateBook'], 'PUT');
$router->add('/delete-livro', [new LivroController(), 'deleteBook'], 'DELETE');

$uri = $_SERVER['PATH_INFO'] ?? '/';
$method = $_SERVER['REQUEST_METHOD'];

$router->dispatch($uri, $method);