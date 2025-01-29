<?php
/* Smarty version 5.4.3, created on 2025-01-29 21:55:17
  from 'file:livros/carrinho.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.4.3',
  'unifunc' => 'content_679aa3c5493a07_16673125',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '093e078c5e0b35bee57c8e604e2d2d38892200f2' => 
    array (
      0 => 'livros/carrinho.tpl',
      1 => 1738148131,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_679aa3c5493a07_16673125 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = '/var/www/html/src/views/templates/livros';
?><!DOCTYPE html>
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
        <footer class="text-center mt-5">
            <p>&copy; 2025 Desenvolvido por Pedro Joaquim Araujo. Licenciado sob a MIT License. Todos os direitos
                reservados.</p>
        </footer>
    </div>
    <?php echo '<script'; ?>
 src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"><?php echo '</script'; ?>
>
    
        <?php echo '<script'; ?>
>
            document.addEventListener('DOMContentLoaded', function() {
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
                                    button.addEventListener('click', function() {
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

                document.getElementById('reservationForm').addEventListener('submit', function(event) {
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
        <?php echo '</script'; ?>
>
    
</body>

</html><?php }
}
