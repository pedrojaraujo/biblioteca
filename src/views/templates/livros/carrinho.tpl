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
                <th>Data de Reserva</th>
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
            document.getElementById('reservationForm').addEventListener('submit', function (event) {
                event.preventDefault();
                const reservas = [];
                document.querySelectorAll('tr').forEach(row => {
                    const id = row.querySelector('.btn-remove-item').dataset.id;
                    const data_reserva = row.querySelector('input[name="data_reserva"]').value;
                    reservas.push({id: id, data_reserva: data_reserva});
                });

                fetch('/confirmar-reservas', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({reservas: reservas})
                }).then(response => response.json()).then(data => {
                    if (data.success) {
                        alert('Reservas confirmadas com sucesso!');
                        localStorage.removeItem('cart');
                        location.reload();
                    } else {
                        alert('Erro ao confirmar reservas: ' + data.message);
                    }
                });
            });
        });
    </script>
{/literal}
</body>
</html>