<!-- filepath: /home/pedrojaraujo/Área de trabalho/projetos/biblioteca/src/views/templates/livros/lista.tpl -->
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Livros</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
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
            </tr>
        {/foreach}
        </tbody>
    </table>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script defer>
    function checkLogin() {
        const token = localStorage.getItem('jwt_token');
        if (!token) {
            window.location.href = '/';
        }
    }

    // Chame `checkLogin()` em páginas protegidas
    checkLogin();
</script>
</body>
</html>