<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrinho de Reservas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
<div class="container mt-5">
    <h2 class="mb-4">Carrinho de Reservas</h2>
    <div class="w-full d-flex justify-content-end">
        <a href="/livros" class="btn btn-secondary mb-3">Voltar</a>
    </div>
    <form id="reservationForm">
        <table class="table table-striped">
            <thead>
            <tr>
                <th>ID</th>
                <th>Título</th>
                <th>Autor</th>
                <th>Data Devolução</th>
                <th>Ações</th>
            </tr>
            </thead>
            <tbody id="cartItems">
            <!-- Itens do carrinho serão adicionados aqui via JavaScript -->
            </tbody>
        </table>
        <button type="submit" class="btn btn-primary">Confirmar Reservas</button>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
{literal}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            function fetchUserReservations() {
                fetch('/get-user-reservations')
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            const cartItems = document.getElementById('cartItems');
                            cartItems.innerHTML = '';
                            const today = new Date();
                            const maxDate = new Date(today.setDate(today.getDate() + 30)).toISOString()
                                .split('T')[0];
                            data.reservas.forEach(reserva => {
                                const dataReserva = reserva.data_reserva ? reserva.data_reserva :
                                    '';
                                const row = document.createElement('tr');
                                row.innerHTML = `
<td>${reserva.id_emprestimo}</td>
<td>${reserva.titulo}</td>
<td>${reserva.autor}</td>
<td><input type="date" class="form-control" name="data_devolucao_prevista" max="${maxDate}" required></td>
<td><button class="btn btn-danger btn-remove-item" data-id="${reserva.id_emprestimo}">Remover</button></td>
                        `;
                                cartItems.appendChild(row);
                            });

                            document.querySelectorAll('.btn-remove-item').forEach(button => {
                                button.addEventListener('click', function () {
                                    const row = this.closest('tr');
                                    const id = this.getAttribute('data-id');

                                    fetch('/delete-reservation', {
                                        method: 'POST',
                                        headers: {
                                            'Content-Type': 'application/json'
                                        },
                                        body: JSON.stringify({id})
                                    })
                                        .then(response => {
                                            if (!response.ok) {
                                                throw new Error(
                                                    'Network response was not ok');
                                            }
                                            return response.json();
                                        })
                                        .then(data => {
                                            if (data.success) {
                                                row.remove();
                                            } else {
                                                alert('Erro ao remover reserva: ' + data
                                                    .message);
                                            }
                                        })
                                        .catch(error => {
                                            console.error('Erro:', error);
                                            alert('Erro ao remover reserva');
                                        });
                                });
                            });
                        } else {
                            alert('Erro ao buscar reservas: ' + data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Erro:', error);
                        alert('Erro ao buscar reservas');
                    });
            }

            fetchUserReservations();

            document.getElementById('reservationForm').addEventListener('submit', function (event) {
                event.preventDefault();
                const reservas = [];
                document.querySelectorAll('#cartItems tr').forEach(row => {
                    const id = row.querySelector('.btn-remove-item').dataset.id;
                    const data_devolucao_prevista = row.querySelector(
                        'input[name="data_devolucao_prevista"]').value;
                    reservas.push({id, data_devolucao_prevista});
                });

                ffetch('/get-user-reservations')
                    .then(response => {
                        if (!response.ok) {
                            return response
                                .text(); // Pega o conteúdo como texto se a resposta não for OK
                        }
                        return response.json(); // Caso contrário, tenta fazer o parse para JSON
                    })
                    .then(data => {
                        if (typeof data === 'string') {
                            console.error('Resposta HTML inesperada:',
                                data); // Exibe o conteúdo HTML se for string
                            alert('Erro: resposta inesperada do servidor');
                            return;
                        }

                        if (data.success) {
                            // Lógica de sucesso
                        } else {
                            alert('Erro ao buscar reservas: ' + data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Erro:', error);
                        alert('Erro ao buscar reservas');
                    });
            });
        });
    </script>
{/literal}
</body>

</html>