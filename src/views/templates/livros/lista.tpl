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
        {if $tipo_usuario == 'administrador'}
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createBookModal">
                <i class="bi bi-file-earmark-plus-fill"></i>
            </button>
        {/if}
        {if $tipo_usuario == 'usuario_comum'}
            <a href="/carrinho" class="btn btn-success"><i class="bi bi-bag-fill"></i></a>
        {/if}
        <a href="/logout" class="btn btn-danger">Sair <i class="bi bi-box-arrow-right"></i></a>
    </div>
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h2 class="h2 mb-0 py-3 text-center">Livros Disponíveis</h2>
        </div>
        <div class="card-body p-0">
            <table class="table table-striped mb-0">
                <thead class="bg-primary text-white">
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
                                <a href="/edit-livro/{$livro.id_livro}" class="btn btn-warning btn-sm mb-1">
                                    <i title="Editar" class="bi bi-pencil-fill"></i>
                                </a>
                                <a href="#" class="btn btn-danger btn-sm mb-1 btn-delete-book"
                                   data-book-id="{$livro.id_livro}">
                                    <i title="Excluir" class="bi bi-trash-fill"></i>
                                </a>
                            {else}
                                <a
                                        href="/borrow-livro/{$livro.id_livro}?id_usuario={$id_usuario}"
                                        class="buttonBorrow btn btn-primary btn-sm mb-1"
                                        data-book-id="{$livro.id_livro}"
                                        data-id-usuario="{$id_usuario}">
                                    <i title="Reservar" class="bi bi-plus-circle-fill"></i>
                                </a>
                                <a href="/view-livro/{$livro.id_livro}" class="btn btn-info btn-sm mb-1">
                                    <i title="Ver mais" class="verMais bi bi-search"></i>
                                </a>
                            {/if}
                        </td>
                    </tr>
                {/foreach}
                </tbody>
            </table>
        </div>
    </div>
    <div class="modal fade" id="createBookModal" tabindex="-1" aria-labelledby="createBookModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createBookModalLabel">Criar Livro</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="createBookForm">
                        <div class="mb-3">
                            <label for="titulo" class="form-label">Título</label>
                            <input type="text" class="form-control" id="titulo" name="titulo" required>
                        </div>
                        <div class="mb-3">
                            <label for="autor" class="form-label">Autor</label>
                            <input type="text" class="form-control" id="autor" name="autor" required>
                        </div>
                        <div class="mb-3">
                            <label for="editora" class="form-label">Editora</label>
                            <input type="text" class="form-control" id="editora" name="editora" required>
                        </div>
                        <div class="mb-3">
                            <label for="ano_publicacao" class="form-label">Ano de Publicação</label>
                            <input type="number" class="form-control" id="ano_publicacao" name="ano_publicacao">
                        </div>
                        <div class="mb-3">
                            <label for="genero" class="form-label">Gênero</label>
                            <input type="text" class="form-control" id="genero" name="genero" required>
                        </div>
                        <div class="mb-3">
                            <label for="sinopse" class="form-label">Sinopse</label>
                            <textarea class="form-control" id="sinopse" name="sinopse" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="imagem" class="form-label">Imagem</label>
                            <input type="text" class="form-control" id="imagem" name="imagem" required>
                        </div>
                        <div class="mb-3">
                            <label for="estoque" class="form-label">Estoque</label>
                            <input type="number" class="form-control" id="estoque" name="estoque" value="1" required>
                        </div>
                        <div class="mb-3">
                            <label for="palavras_chave" class="form-label">Palavras-chave</label>
                            <textarea class="form-control" id="palavras_chave" name="palavras_chave"></textarea>
                        </div>
                        <button id="createBookButton" type="submit" class="btn btn-primary">Salvar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="deleteBookModal" tabindex="-1" aria-labelledby="deleteBookModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteBookModalLabel">Excluir Livro</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Tem certeza de que deseja excluir este livro?</p>
                    <form id="deleteBookForm">
                        <input type="hidden" id="deleteBookId" name="id_livro">
                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Não</button>
                            <button type="submit" class="btn btn-danger">Sim</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div id="borrowModal" class="modal fade" tabindex="-1" aria-labelledby="borrowModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="borrowModalLabel">Status da Reserva</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Status message will be inserted here -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
{literal}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Handle create book form submission
            document.getElementById('createBookForm').addEventListener('submit', function (event) {
                event.preventDefault();
                const formData = new FormData(this);
                fetch('/create-livro', {
                    method: 'POST',
                    body: formData
                }).then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                }).then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert('Erro ao criar livro: ' + data.message);
                    }
                }).catch(error => {
                    console.error('Erro:', error);
                    alert('Erro ao criar livro');
                });
            });

            // Handle delete book button click
            document.querySelectorAll('.btn-delete-book').forEach(button => {
                button.addEventListener('click', function () {
                    document.getElementById('deleteBookId').value = this.dataset.bookId;
                    const deleteBookModal = new bootstrap.Modal(document.getElementById('deleteBookModal'));
                    deleteBookModal.show();
                });
            });

            // Handle delete book form submission
            document.getElementById('deleteBookForm').addEventListener('submit', function (event) {
                event.preventDefault();
                const bookId = document.getElementById('deleteBookId').value;
                fetch('/delete-livro', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({id_livro: bookId})
                }).then(response => response.json()).then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert('Erro ao excluir livro: ' + data.message);
                    }
                });
            });

            // Handle add to cart button click
            document.querySelectorAll('.btn-add-to-cart').forEach(button => {
                button.addEventListener('click', function () {
                    const bookId = this.dataset.bookId;
                    const bookTitle = this.dataset.bookTitle;
                    const bookAuthor = this.dataset.bookAuthor;

                    let cart = JSON.parse(localStorage.getItem('cart')) || [];
                    cart.push({id: bookId, titulo: bookTitle, autor: bookAuthor});
                    localStorage.setItem('cart', JSON.stringify(cart));

                    alert('Livro adicionado ao carrinho!');
                });
            });

            // Handle borrow book button click
            const borrowButtons = document.querySelectorAll('.buttonBorrow');
            let currentBookId = null;
            let currentUserId = null;

            if (borrowButtons) {
                borrowButtons.forEach(button => {
                    button.addEventListener('click', function (event) {
                        event.preventDefault();
                        currentBookId = this.getAttribute('data-book-id');
                        currentUserId = this.getAttribute('data-id-usuario');
                        fetch(`/borrow-livro/${currentBookId}`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({id_usuario: currentUserId})
                        })
                            .then(response => {
                                if (!response.ok) {
                                    throw new Error('Network response was not ok');
                                }
                                return response.json();
                            })
                            .then(data => {
                                const modalBody = document.querySelector('#borrowModal .modal-body');
                                if (data.success) {
                                    modalBody.textContent = 'Livro reservado com sucesso!';
                                } else {
                                    modalBody.textContent = 'Erro ao reservar o livro.';
                                }
                                const borrowModalElement = document.getElementById('borrowModal');
                                const borrowModal = new bootstrap.Modal(borrowModalElement);
                                borrowModal.show();
                            })
                            .catch(error => {
                                console.error('Erro:', error);
                                const modalBody = document.querySelector('#borrowModal .modal-body');
                                modalBody.textContent = 'Ocorreu um erro ao processar a requisição.';
                                const borrowModalElement = document.getElementById('borrowModal');
                                const borrowModal = new bootstrap.Modal(borrowModalElement);
                                borrowModal.show();
                            });
                    });
                });
            }
        });
    </script>
{/literal}
</body>
</html>