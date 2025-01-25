<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Livros</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css"
          rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Lista de Livros</h1>
        <a href="/logout" class="btn btn-danger">Sair</a>
    </div>
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
            <th>Ações</th>
        </tr>
        </thead>
  <tbody>
        {foreach $livros as $livro}
            <tr>
                <td>{$livro.id_livro}</td>
                <td>{$livro.titulo}</td>
                <td>{$livro.autor}</td>
                <td>{$livro.editora}</td>
                <td>{$livro.ano_publicacao}</td>
                <td>{$livro.genero}</td>
                <td>{$livro.estoque}</td>
                <td>
                      {if $tipo_usuario == 'administrador'}
                        <a href="/edit-livro/{$livro.id_livro}" class="btn btn-warning btn-sm mb-1"><i title="Editar" class="bi bi-pencil-fill"></i></a>
                        <a href="/delete-livro/{$livro.id_livro}" class="btn btn-danger btn-sm mb-1"><i title="Excluir" class="bi bi-trash-fill"></i></a>
                    {else}
                        <a href="/borrow-livro/{$livro.id_livro}" class="btn btn-primary btn-sm mb-1"><i title="Reservar" class="bi bi-plus-circle-fill"></i></i></a>
                        <a href="/view-livro/{$livro.id_livro}" class="btn btn-info btn-sm mb-1"><i title="Ver mais" class="bi bi-search"></i></a>
                    {/if}
                </td>
            </tr>
        {/foreach}
        </tbody>
    </table>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>