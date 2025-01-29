<?php

require_once __DIR__ . '/../../vendor/autoload.php';

use Biblioteca\Database;
use Biblioteca\Database\Migrations\CreateUsuariosTable;
use Biblioteca\Database\Migrations\CreateLivrosTable;
use Biblioteca\Database\Seeds\DatabaseSeeder;

try {
    // Criar conexão com o banco
    $db = new Database();
    $pdo = $db->getPdo();

    // Executar migrations
    CreateUsuariosTable::up();
    CreateLivrosTable::up();
    echo "Migrations executadas com sucesso!\n";

    // Executar seeds
    $seeder = new DatabaseSeeder($pdo);
    $seeder->run();

} catch (\PDOException $e) {
    echo "Erro no banco de dados: " . $e->getMessage() . "\n";
    exit(1);
} catch (\Exception $e) {
    echo "Erro: " . $e->getMessage() . "\n";
    exit(1);
} 