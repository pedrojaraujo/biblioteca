<?php

use Biblioteca\Router\Router;
use Biblioteca\Controllers\LivroController;
use Biblioteca\Controllers\AuthController;

$router = new Router();

$router->add('/', [new AuthController(), 'showLoginPage']);
$router->add('/login', [new AuthController(), 'login'], 'POST');
$router->add('/logout', [new AuthController(), 'logout']);
$router->add('/livros', [new LivroController(), 'index']);
$router->add('/create-livro', [new LivroController(), 'createBook'], 'POST');
$router->add('/edit-livro/[i:id]', [new LivroController(), 'editBook'], 'GET');
$router->add('/edit-livro/[i:id]', [new LivroController(), 'editBook'], 'POST');
$router->add('/delete-livro', [new LivroController(), 'deleteBook'], 'POST');
$router->add('/carrinho', [new LivroController(), 'showCart']);
$router->add('/confirmar-reservas', [new LivroController(), 'confirmReservations'], 'POST');
$router->add('/borrow-livro/[i:id]', [new LivroController(), 'borrowLivro'], 'POST');
$router->add('/get-user-reservations', [new LivroController(), 'getUserReservations'], 'GET');
$router->add('/delete-reservation', [new LivroController(), 'deleteReservation'], 'POST');
$router->add('/view-livro/[i:id]', [new LivroController(), 'viewBook'], 'GET');

$uri = $_SERVER['PATH_INFO'] ?? '/';
$method = $_SERVER['REQUEST_METHOD'];

$router->dispatch($uri, $method);