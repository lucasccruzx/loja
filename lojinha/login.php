<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
  <title>Login</title>
  <link rel="stylesheet" href="login.css" />
</head>
<body>
    <!-- Inicio do formulario -->
<form method="POST" action="">

<label>Usuário: </label>
<input type="text" name="usuario" placeholder="digite o usuário" required><br><br>

<label>Senha: </label>
<input type="password" name="senha_usuario" placeholder="digite a senha" required><br><br>

<input type="submit" name="Sendlogin" value="Acessar">
</form>
<!-- fim do formulario -->
  <div class="container" role="main">
    <div class="logo" aria-label="logo"></div>
    <form id="loginForm" aria-labelledby="loginTitle" novalidate>
      <h1 id="loginTitle" class="login-title">Login</h1>
      <label for="email">Endereço de e-mail ou nome de usuário</label>
      <input type="text" id="email" name="email" placeholder="Você pode usar o e-mail ou nome de usuário" autocomplete="username" required />
      <label for="password">Senha</label>
      <input type="password" id="password" name="password" placeholder="Sua senha" autocomplete="current-password" required />
      <button type="submit">Entrar</button>
      <div class="form-footer">
        Não tem uma conta? <a href="cadastro.html" target="_blank" rel="noopener noreferrer">Cadastre-se</a>
      </div>
    </form>
  </div>

  <script>
    document.getElementById('loginForm').addEventListener('submit', function(event) {
      event.preventDefault(); // Impede o envio padrão do formulário
      // Redireciona para a página desejada
      window.location.href = 'index.html'; // Substitua 'pagina-desejada.html' pela URL da página para a qual deseja redirecionar
    });
  </script>
</body>
</html>