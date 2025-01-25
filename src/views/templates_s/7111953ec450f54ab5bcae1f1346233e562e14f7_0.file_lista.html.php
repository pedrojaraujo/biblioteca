<?php
/* Smarty version 5.4.3, created on 2025-01-25 20:05:39
  from 'file:livros/lista.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.4.3',
  'unifunc' => 'content_67954413097d52_46347898',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '7111953ec450f54ab5bcae1f1346233e562e14f7' => 
    array (
      0 => 'livros/lista.tpl',
      1 => 1737835536,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_67954413097d52_46347898 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = '/home/pedrojaraujo/Área de trabalho/projetos/biblioteca/src/views/templates/livros';
?><!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Livros</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Lista de Livros</h1>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Título</th>
                    <th>Autor</th>
                    <th>Editora</th>
                    <th>Ano de Publicação</th>
                    <th>Gênero</th>
                    <th>Estoque</th>
                </tr>
            </thead>
            <tbody>
                <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('livros'), 'livro');
$foreach0DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('livro')->value) {
$foreach0DoElse = false;
?>
                <tr>
                    <td><?php echo $_smarty_tpl->getValue('livro')['id_livro'];?>
</td>
                    <td><?php echo $_smarty_tpl->getValue('livro')['titulo'];?>
</td>
                    <td><?php echo $_smarty_tpl->getValue('livro')['autor'];?>
</td>
                    <td><?php echo $_smarty_tpl->getValue('livro')['editora'];?>
</td>
                    <td><?php echo $_smarty_tpl->getValue('livro')['ano_publicacao'];?>
</td>
                    <td><?php echo $_smarty_tpl->getValue('livro')['genero'];?>
</td>
                    <td><?php echo $_smarty_tpl->getValue('livro')['estoque'];?>
</td>
                </tr>
                <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
            </tbody>
        </table>
    </div>
    <?php echo '<script'; ?>
 src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"><?php echo '</script'; ?>
>
</body>
</html><?php }
}
