<?php
/* Smarty version 5.4.3, created on 2025-01-29 21:55:32
  from 'file:auth/login.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.4.3',
  'unifunc' => 'content_679aa3d49a3b69_27016640',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '5c4d5175f16b4f11c29b57f6ba1f5dc1a4425f80' => 
    array (
      0 => 'auth/login.tpl',
      1 => 1738148131,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_679aa3d49a3b69_27016640 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = '/var/www/html/src/views/templates/auth';
?><!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciador de Biblioteca</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css"
        rel="stylesheet">
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
</head>

<body>
    <main class="main-container">
        <section>
            <h1 class="text-center py-3">Library</h1>
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
                <div id="loginButton" class="d-flex justify-content-center">
                    <button type="submit" class="btn btn-primary">
                        Entrar
                    </button>
                </div>
            </form>
        </section>
    </main>

    <footer class="text-center mt-5">
        <p>&copy; 2025 Desenvolvido por Pedro Joaquim Araujo. Licenciado sob a MIT License. Todos os direitos
            reservados.</p>
    </footer>

    <?php echo '<script'; ?>
 src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"><?php echo '</script'; ?>
>
    
        <?php echo '<script'; ?>
 defer>
            document.querySelector('form').addEventListener('submit', async function(event) {
                event.preventDefault(); // Evita o envio do formulário

                const formData = new FormData(event.target);
                const email = formData.get('email');
                const senha = formData.get('senha');

                const response = await fetch('/login', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({email: email, senha: senha})
                });

                try {
                    const data = await response.json();

                    if (response.ok) {
                        localStorage.setItem('jwt_token', data.token);
                        console.log('Login bem-sucedido!');
                        window.location.href = '/livros'; // Redireciona para a página de livros
                    } else {
                        let errorDiv = document.querySelector('.alert-danger');
                        if (!errorDiv) {
                            errorDiv = document.createElement('div');
                            errorDiv.className = 'p-1 alert alert-danger text-center';
                            document.querySelector('#loginButton').insertAdjacentElement('beforebegin',
                                errorDiv);
                        }
                        errorDiv.textContent = data.error || 'Erro ao fazer login';
                        errorDiv.style.display = 'block';
                    }
                } catch (error) {
                    console.error('Erro ao processar a resposta:', error);
                    let errorDiv = document.querySelector('.alert-danger');
                    if (!errorDiv) {
                        errorDiv = document.createElement('div');
                        errorDiv.className = 'p-1 alert alert-danger text-center';
                        document.querySelector('#loginButton').insertAdjacentElement('beforebegin', errorDiv);
                    }
                    errorDiv.textContent = 'Erro ao fazer login';
                    errorDiv.style.display = 'block';
                }
            });
        <?php echo '</script'; ?>
>
    
</body>

</html><?php }
}
