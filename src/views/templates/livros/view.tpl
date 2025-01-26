<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visualizar Livro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <a href="/livros" class="btn btn-primary">Voltar</a>
            <a href="/logout" class="btn btn-danger">Sair <i class="bi bi-box-arrow-right"></i></a>
        </div>
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h2 class="h2 mb-0 py-3 text-center">Detalhes do Livro</h2>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="titulo" class="form-label">Título</label>
                    <input type="text" class="form-control" id="titulo" name="titulo" value="{$livro.titulo}" readonly>
                </div>
                <div class="mb-3">
                    <label for="autor" class="form-label">Autor</label>
                    <input type="text" class="form-control" id="autor" name="autor" value="{$livro.autor}" readonly>
                </div>
                <div class="mb-3">
                    <label for="editora" class="form-label">Editora</label>
                    <input type="text" class="form-control" id="editora" name="editora" value="{$livro.editora}"
                        readonly>
                </div>
                <div class="mb-3">
                    <label for="ano_publicacao" class="form-label">Ano de Publicação</label>
                    <input type="number" class="form-control" id="ano_publicacao" name="ano_publicacao"
                        value="{$livro.ano_publicacao}" readonly>
                </div>
                <div class="mb-3">
                    <label for="genero" class="form-label">Gênero</label>
                    <input type="text" class="form-control" id="genero" name="genero" value="{$livro.genero}" readonly>
                </div>
                <div class="mb-3">
                    <label for="sinopse" class="form-label">Sinopse</label>
                    <textarea class="form-control" id="sinopse" name="sinopse" readonly>{$livro.sinopse}</textarea>
                </div>
                <div class="mb-3">
                    <label for="imagem" class="form-label">Imagem</label>
                    <input type="text" class="form-control" id="imagem" name="imagem" value="{$livro.imagem}" readonly>
                </div>
                <div class="mb-3">
                    <label for="estoque" class="form-label">Estoque</label>
                    <input type="number" class="form-control" id="estoque" name="estoque" value="{$livro.estoque}"
                        readonly>
                </div>
                <div class="mb-3">
                    <label for="palavras_chave" class="form-label">Palavras-chave</label>
                    <textarea class="form-control" id="palavras_chave" name="palavras_chave"
                        readonly>{$livro.palavras_chave}</textarea>
                </div>
            </div>
        </div>
        <footer class="text-center mt-5">
            <p>&copy; 2025 Desenvolvido por Pedro Joaquim Araujo. Licenciado sob a MIT License. Todos os direitos
                reservados.</p>
        </footer>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>