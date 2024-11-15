<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Pedrojaraujo\Biblioteca\Core\Router;
use Dotenv\Dotenv


// Carrega as variáveis de ambiente
$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

//Carrega rotas
$router = new Router();

//Definindo rotas

$router->get('/livros', 'LivroController@index');
$router->post('/livros', 'LivroController@store');
$router->get('/livros/{id}', 'LivroController@show');
$router->put('/livros/{id}', 'LivroController@update');
$router->delete('/livros/{id}', 'LivroController@destroy');

//Executa a rota correspondente

$router->dispatch();




