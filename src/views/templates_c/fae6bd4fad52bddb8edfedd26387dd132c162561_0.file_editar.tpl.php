<?php
/* Smarty version 5.4.3, created on 2025-01-29 14:49:36
  from 'file:livros/editar.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.4.3',
  'unifunc' => 'content_679a4000b163c3_29199581',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'fae6bd4fad52bddb8edfedd26387dd132c162561' => 
    array (
      0 => 'livros/editar.tpl',
      1 => 1738148131,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_679a4000b163c3_29199581 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = '/var/www/html/src/views/templates/livros';
?><!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Livro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h1 class="h3 mb-0">Editar Livro</h1>
            </div>
            <div class="card-body">
                <?php if ((true && ($_smarty_tpl->hasVariable('message') && null !== ($_smarty_tpl->getValue('message') ?? null)))) {?>
                    <div class="alert alert-success" role="alert">
                        <?php echo $_smarty_tpl->getValue('message');?>

                    </div>
                <?php }?>
                <form method="post" action="/edit-livro/<?php echo $_smarty_tpl->getValue('livro')['id_livro'];?>
">
                    <input type="hidden" name="id_livro" value="<?php echo $_smarty_tpl->getValue('livro')['id_livro'];?>
">
                    <div class="mb-3">
                        <label for="titulo" class="form-label">Título</label>
                        <input type="text" class="form-control" id="titulo" name="titulo" value="<?php echo $_smarty_tpl->getValue('livro')['titulo'];?>
"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="autor" class="form-label">Autor</label>
                        <input type="text" class="form-control" id="autor" name="autor" value="<?php echo $_smarty_tpl->getValue('livro')['autor'];?>
" required>
                    </div>
                    <div class="mb-3">
                        <label for="editora" class="form-label">Editora</label>
                        <input type="text" class="form-control" id="editora" name="editora" value="<?php echo $_smarty_tpl->getValue('livro')['editora'];?>
"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="ano_publicacao" class="form-label">Ano de Publicação</label>
                        <input type="number" class="form-control" id="ano_publicacao" name="ano_publicacao"
                            value="<?php echo $_smarty_tpl->getValue('livro')['ano_publicacao'];?>
">
                    </div>
                    <div class="mb-3">
                        <label for="genero" class="form-label">Gênero</label>
                        <input type="text" class="form-control" id="genero" name="genero" value="<?php echo $_smarty_tpl->getValue('livro')['genero'];?>
"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="sinopse" class="form-label">Sinopse</label>
                        <textarea class="form-control" id="sinopse" name="sinopse" required><?php echo $_smarty_tpl->getValue('livro')['sinopse'];?>
</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="imagem" class="form-label">Imagem</label>
                        <input type="text" class="form-control" id="imagem" name="imagem" value="<?php echo $_smarty_tpl->getValue('livro')['imagem'];?>
"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="estoque" class="form-label">Estoque</label>
                        <input type="number" class="form-control" id="estoque" name="estoque" value="<?php echo $_smarty_tpl->getValue('livro')['estoque'];?>
"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="palavras_chave" class="form-label">Palavras-chave</label>
                        <textarea class="form-control" id="palavras_chave"
                            name="palavras_chave"><?php echo $_smarty_tpl->getValue('livro')['palavras_chave'];?>
</textarea>
                    </div>
                    <div class="d-flex justify-content-between">
                        <button type="submit" class="btn btn-primary">Salvar</button>
                        <button type="button" class="btn btn-secondary"
                            onclick="window.location.href='/livros'">Voltar</button>
                    </div>
                </form>
            </div>
        </div>
        <footer class="text-center mt-5">
            <p>&copy; 2025 Desenvolvido por Pedro Joaquim Araujo. Licenciado sob a MIT License. Todos os direitos
                reservados.</p>
        </footer>
    </div>
    <?php echo '<script'; ?>
 src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"><?php echo '</script'; ?>
>
</body>

</html><?php }
}
