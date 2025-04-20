<?php
include("conexao.php");
session_start();
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $nome = $_POST['nome'];
  $email = $_POST['email'];
  $cpf = $_POST['cpf'];
  $pass = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash da senha

  // Escape para evitar SQL Injection
  $email = $conn->real_escape_string($email);

  // Verifica se o email já existe
  $checkEmail = "SELECT * FROM tb_usuarios WHERE email = '$email'";
  $result = $conn->query($checkEmail);

  $checkCpf = "SELECT * FROM tb_usuarios WHERE cpf = '$cpf'";
  $resultCpf = $conn->query($checkCpf);

  if ($result->num_rows > 0) {
      echo "<script>alert('Email já cadastrado!');</script>";

  }else if
    ($resultCpf->num_rows > 0) {
    echo "<script>alert('Cpf já cadastrado!');</script>";

}else if
(!filter_var($email, FILTER_VALIDATE_EMAIL)){
echo "<script>alert('Preencha um email Válido');</script>";

}else if
    (strlen($cpf) <11){
        echo "<script>alert('Preencha um cpf Válido');</script>";
}else if
(strlen($cpf) >13){
    echo "<script>alert('Preencha um cnpj Válido');</script>";

}else if
    (empty($nome) || empty($email) || empty($cpf) || empty($_POST['password'])){
        echo "<script>alert('Preencha todos os campos');</script>";

  } else {
      // Insere o novo usuário
      $sql = "INSERT INTO tb_usuarios (nome, email, senha, cpf, data_cadastro) VALUES ('$nome', '$email', '$pass', '$cpf', NOW())";
      if ($conn->query($sql) === TRUE) {
        $usuario_id = $conn->insert_id;
        $_SESSION['usuario_id'] = $usuario_id;
          echo "<script>alert('Usuário cadastrado com sucesso');
          window.location.href = 'home.php'
          </script>";
          
      } else {
          echo "Erro: " . $sql . "<br>" . $conn->error;
      }
  }
}





?>


<!doctype html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Cadastro de Usuário</title>
  </head>
  <body>
    <nav class="navbar navbar-light" style="background-color: white;">
        <div class="container-fluid d-flex justify-content-center align-items-center">
            <a class="navbar-brand">
                <img src="./img/logo.jpg" alt="Logo" style="max-height: 100px">
            </a>
            <span class="mx-auto fs-3"><strong>CADASTRO DE USUÁRIO</strong></span>
        </div>
    </nav>

    <div class="container-fluid py-5" style="background-color: #FFFAEB;">
        <div class="container d-flex justify-content-center">
            <div class="col-md-6">
                <h5 class="mb-4 text-center">PREENCHA OS DADOS A SEGUIR:</h5>
                <div class="card p-4">
                    <form action="cad-usuario.php" method="post">
                        <div class="mb-3">
                            <label for="nome" class="form-label"><strong>Nome:</strong></label>
                            <input value="<?php if(isset($_POST['nome'])) echo $_POST['nome'];?>"  type="text" class="form-control" id="nome" name="nome" placeholder="Preencha seu nome completo" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label"><strong>E-mail:</strong></label>
                            <input value="<?php if(isset($_POST['email'])) echo $_POST['email'];?>" type="email" class="form-control" id="email" name="email" placeholder="exemplo@email.com" required >
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label"><strong>Senha:</strong></label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Digite sua senha" required >
                        </div>
                        <div class="mb-3">
                            <label for="cpf" class="form-label"><strong>CPF/CNPJ:</strong></label>
                            <input value="<?php if(isset($_POST['cpf'])) echo $_POST['cpf'];?>" type="number" class="form-control" id="cpf" name="cpf" placeholder="Digite somente os números do seu CPF ou CNPJ" required >
                        </div>
                        <button type="submit" class="btn btn-success w-100">Cadastrar</button>
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
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    </body>
</html>