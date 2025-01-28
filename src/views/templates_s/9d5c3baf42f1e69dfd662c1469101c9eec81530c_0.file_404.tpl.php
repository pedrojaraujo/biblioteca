<?php
/* Smarty version 5.4.3, created on 2025-01-26 20:33:42
  from 'file:errors/404.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.4.3',
  'unifunc' => 'content_67969c260c2401_82662933',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '9d5c3baf42f1e69dfd662c1469101c9eec81530c' => 
    array (
      0 => 'errors/404.tpl',
      1 => 1737923295,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_67969c260c2401_82662933 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = '/home/pedrojaraujo/Área de trabalho/projetos/biblioteca/src/views/templates/errors';
?><!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Page Not Found</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h1 class="display-4">404 - Página não encontrada</h1>
        <p class="lead">A página que você está procurando não existe ou não está acessível.</p>
        <a href="/" class="btn btn-primary">Voltar para login</a>
        <footer class="text-center mt-5">
            <p>&copy; 2025 Desenvolvido por Pedro Joaquim Araujo. Licenciado sob a MIT License. Todos os direitos
                reservados.</p>
        </footer>
    </div>
</body><?php }
}
