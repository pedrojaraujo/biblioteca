<?php
/* Smarty version 5.4.3, created on 2025-01-25 19:24:11
  from 'file:auth/login.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.4.3',
  'unifunc' => 'content_67953a5bdf3f65_21225138',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '4b6ef5cdbb84d8721b601cd12cc7d0b9d3297c4a' => 
    array (
      0 => 'auth/login.tpl',
      1 => 1737833047,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_67953a5bdf3f65_21225138 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = '/home/pedrojaraujo/Área de trabalho/projetos/biblioteca/src/views/templates/auth';
?><!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciador de Biblioteca</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css"
          rel="stylesheet">
</head>

<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        background-color: #f8f9fa;
        height: 100vh;
        width: 100vw;
        display: flex;
        justify-content: center;
    }

    .main-container {
        padding-top: 104px;
        display: flex;
        flex-direction: column;
        gap: 52px;
        align-items: center;
        height: 100%;
        max-height: 100%;
    }

    .login-form {
        max-width: 500px;
        width: 100%;
        padding: 30px;
        background-color: #ffffff;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .login-form h1 {
        font-size: 110px;
        margin-bottom: 20px;
    }

    .login-form .form-control {
        border-radius: 5px;
    }

    .login-form .btn-primary {
        width: 100%;
        border-radius: 5px;
    }

    footer {
        position: absolute;
        bottom: 0;
        width: 100%;
        background-color: #343a40;
        color: #ffffff;
        padding: 10px 0;
    }
</style>


<body>

<main class="main-container">
    <section>
        <h1 class="text-center py-3">Gerenciador de Biblioteca</h1>
    </section>
    <section class="login-form">

        <h1 class="text-center mb-4"><i class="bi bi-person-fill text-primary"></i></h1>
        <form method="POST" action="/login">
            <div class="mb-3">
                <label for="email" class="form-label">E-mail:</label>
                <input type="email" id="email" name="email" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="senha" class="form-label">Senha:</label>
                <input type="password" id="senha" name="senha" class="form-control" required>
            </div>
            <?php if ((true && ($_smarty_tpl->hasVariable('error') && null !== ($_smarty_tpl->getValue('error') ?? null)))) {?>
                <div class="p-1 alert alert-danger text-center" role="alert">
                    <?php echo $_smarty_tpl->getValue('error');?>

                </div>
            <?php }?>
            <div class="d-flex justify-content-center">
                <button type="submit" class="btn btn-primary">
                    Entrar
                </button>
            </div>

        </form>
    </section>
</main>

<footer class="text-center">
    <p>&copy; 2025 Biblioteca Online. Todos os direitos reservados.</p>
</footer>

<?php echo '<script'; ?>
 src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"><?php echo '</script'; ?>
>
</body>
</html><?php }
}
