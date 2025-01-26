<!DOCTYPE html>
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
            {if isset($message)}
                <div class="alert alert-success" role="alert">
                    {$message}
                </div>
            {/if}
            <form method="post" action="/edit-livro/{$livro.id_livro}">
                <input type="hidden" name="id_livro" value="{$livro.id_livro}">
                <div class="mb-3">
                    <label for="titulo" class="form-label">Título</label>
                    <input type="text" class="form-control" id="titulo" name="titulo" value="{$livro.titulo}" required>
                </div>
                <div class="mb-3">
                    <label for="autor" class="form-label">Autor</label>
                    <input type="text" class="form-control" id="autor" name="autor" value="{$livro.autor}" required>
                </div>
                <div class="mb-3">
                    <label for="editora" class="form-label">Editora</label>
                    <input type="text" class="form-control" id="editora" name="editora" value="{$livro.editora}" required>
                </div>
                <div class="mb-3">
                    <label for="ano_publicacao" class="form-label">Ano de Publicação</label>
                    <input type="number" class="form-control" id="ano_publicacao" name="ano_publicacao" value="{$livro.ano_publicacao}">
                </div>
                <div class="mb-3">
                    <label for="genero" class="form-label">Gênero</label>
                    <input type="text" class="form-control" id="genero" name="genero" value="{$livro.genero}" required>
                </div>
                <div class="mb-3">
                    <label for="sinopse" class="form-label">Sinopse</label>
                    <textarea class="form-control" id="sinopse" name="sinopse" required>{$livro.sinopse}</textarea>
                </div>
                <div class="mb-3">
                    <label for="imagem" class="form-label">Imagem</label>
                    <input type="text" class="form-control" id="imagem" name="imagem" value="{$livro.imagem}" required>
                </div>
                <div class="mb-3">
                    <label for="estoque" class="form-label">Estoque</label>
                    <input type="number" class="form-control" id="estoque" name="estoque" value="{$livro.estoque}" required>
                </div>
                <div class="mb-3">
                    <label for="palavras_chave" class="form-label">Palavras-chave</label>
                    <textarea class="form-control" id="palavras_chave" name="palavras_chave">{$livro.palavras_chave}</textarea>
                </div>
                <div class="d-flex justify-content-between">
                    <button type="submit" class="btn btn-primary">Salvar</button>
                    <button type="button" class="btn btn-secondary" onclick="window.location.href='/livros'">Voltar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>