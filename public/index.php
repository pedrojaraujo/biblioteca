<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Pedrojaraujo\Biblioteca\Core\Router;
use Dotenv\Dotenv;

$dotenvPath = __DIR__ . '/../../../';
var_dump($dotenvPath); // Verificar o caminho
$dotenv = Dotenv::createImmutable($dotenvPath);
$dotenv->load();

// Verificar se as variáveis de ambiente foram carregadas corretamente
var_dump(getenv('DB_HOST'));
var_dump(getenv('DB_NAME'));
var_dump(getenv('DB_USER'));
var_dump(getenv('DB_PASS'));

$config = require __DIR__ . '/../config/config.php';;


try {
    $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['dbname'];
    $pdo = new PDO($dsn, $config['db']['user'], $config['db']['pass']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Erro na conexão com o banco de dados: ' . $e->getMessage();
}

$router = new Router();

$router->get('/livros', 'LivroController@index');
$router->post('/livros', 'LivroController@store');
$router->get('/livros/{id}', 'LivroController@show');
$router->put('/livros/{id}', 'LivroController@update');
$router->delete('/livros/{id}', 'LivroController@destroy');

$router->dispatch();
