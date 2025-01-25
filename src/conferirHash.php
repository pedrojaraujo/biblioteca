<?php
$senha = ''; // Senha inserida no formulário
$hash = ''; // Hash do banco

if (password_verify($senha, $hash)) {
    echo "Senha válida!";
} else {
    echo "Senha inválida!";
}
