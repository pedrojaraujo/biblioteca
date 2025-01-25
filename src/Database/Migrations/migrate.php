<?php

require 'vendor/autoload.php';

use Biblioteca\Database\Migrations\CreateColecoesTable;
use Biblioteca\Database\Migrations\CreateEmprestimosTable;
use Biblioteca\Database\Migrations\CreateLivrosColecoesTable;
use Biblioteca\Database\Migrations\CreateLivrosTable;
use Biblioteca\Database\Migrations\CreateUsuariosTable;

CreateUsuariosTable::up();
CreateLivrosTable::up();
CreateColecoesTable::up();
CreateLivrosColecoesTable::up();
CreateEmprestimosTable::up();

echo "Migrations executadas com sucesso!";