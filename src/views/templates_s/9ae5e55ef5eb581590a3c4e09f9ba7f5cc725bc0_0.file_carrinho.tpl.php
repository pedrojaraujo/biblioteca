<?php
/* Smarty version 5.4.3, created on 2025-01-26 01:59:11
  from 'file:livros/carrinho.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.4.3',
  'unifunc' => 'content_679596ef72b956_65887450',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '9ae5e55ef5eb581590a3c4e09f9ba7f5cc725bc0' => 
    array (
      0 => 'livros/carrinho.tpl',
      1 => 1737856748,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_679596ef72b956_65887450 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = '/home/pedrojaraujo/Área de trabalho/projetos/biblioteca/src/views/templates/livros';
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
<?php echo '<script'; ?>
 src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"><?php echo '</script'; ?>
>

    <?php echo '<script'; ?>
>
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
    <?php echo '</script'; ?>
>

</body>
</html><?php }
}
