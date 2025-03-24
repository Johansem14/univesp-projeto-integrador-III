<?php
include("conexao.php");

session_start();
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $email = $_POST['email'];
  $pass = $_POST['password'];

  // Escape para evitar SQL Injection
  $email = $conn->real_escape_string($email);
  
  // Consulta SQL
  $sql = "SELECT * FROM tb_usuarios WHERE email = '$email'";
  $result = $conn->query($sql);

  // Verifica se o usuário existe
  if ($result->num_rows > 0) {
      $row = $result->fetch_assoc();
      // Verifica a senha
      if (password_verify($pass, $row['senha'])) {
          // Login bem-sucedido
          $_SESSION['usuario_id'] = $row['id_usuarios'];
          echo "<script>alert('Bem-vindo, " . htmlspecialchars($email) . "!');
          window.location.href = 'home.php';
          </script>";
      } else {
        echo "<script>alert('Senha incorreta');</script>";
      }
  } else {
    echo "<script>alert('Usuário não encontrado');</script>";
  }
}

$conn->close();
?>


<!doctype html>
<html lang="pt-br">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Login de Usuário</title>
  </head>
  <body>
    <nav class="navbar navbar-light" style="background-color: white; margin-right: 120px;">
        <div class="container-fluid d-flex justify-content-center align-items-center">
            <!-- Logo -->
            <a class="navbar-brand">
                <img src="./img/logo.jpg" alt="Logo" style="max-height: 100px">
            </a>
            <!-- Texto centralizado -->
            <span class="mx-auto fs-3"><strong>LOGIN DE USUÁRIO</strong></span>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container-fluid py-5" style="background-color: #FFFAEB">
        <div class="container d-flex justify-content-center">
            <div class="col-md-6">
                <h5 class="mb-4 text-center">PREENCHA OS DADOS A SEGUIR:</h5>
                <div class="card p-4">
                    <form action="login.php" method="post">
                        <div class="mb-3">
                            <label for="email" class="form-label"><strong>Email:</strong></label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="exemplo@email.com" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label"><strong>Senha:</strong></label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Digite sua senha" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Entrar</button>
                        <div class="mt-3 text-center">
                           <a href="recuperar-senha.php" class="text-decoration-none">Esqueci minha senha</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


        <footer class="text-center py-5" style="background-color: #001F36;">
            <div class="container text-white">
                <p class="mb-0">Conecta+ © 2025 Projeto Integrador III - Todos os direitos reservados.</p>
            </div>
        </footer>
  
        <!-- Option 1: Bootstrap Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    </body>
</html>