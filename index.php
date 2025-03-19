<?php
include("conexao.php");

$sql_categorias = "SELECT * FROM categoria_mais_cadastrada_vw";
$result = $conn->query($sql_categorias);
?>

<!doctype html>
<html lang="pt-br">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>&copy;Conecta+</title>
    <style>
      .item-container {
        display: grid;
        grid-template-columns: repeat(4, 1fr); /* Cria 3 colunas de largura igual */
        gap: 20px; /* Espaço entre as colunas e linhas */
      }

      @media (max-width: 768px) {
        .item-container {
          grid-template-columns: 1fr; /* 1 coluna em telas pequenas */
        }
      }

      .categoria-item img {
        margin: 0 auto;
        display: block;
        height:250px;
      }

      .categoria-item {
        box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1);
        align-items: center;
        align-self: flex-start;
       
      }

      .titulo-categoria {
        text-align: center;
      }
      .titulo-categorias{
        text-align: center;
        text-decoration-color:black;
        text-underline-offset: 15px;
        text-decoration:underline;
        text-decoration-thickness: 1px;
      
      }
   
    </style>
  </head>
  <body>

    <nav class="navbar navbar-expand-lg navbar-light" style="background-color: white;">
      <div class="container-fluid">
        <a class="navbar-brand">
          <img src="./img/logo.jpg" alt="Logo" style="max-height: 130px;">
        </a>
        <div class="d-flex ms-auto me-5">
          <a class="btn btn-primary me-2" href="login.php">Entrar</a>
          <a class="btn btn-success" style="background-color: rgb(0, 156, 0);" href="cad-usuario.php">Cadastre-se</a>
        </div>
      </div>
    </nav>

    <header class="text-center">
      <div class="container-fluid d-flex flex-column justify-content-center align-items-center py-5" style="background-color:#13747D;">
        <div style="max-width: 500px; width: 100%;">
          <h1 class="display-5 fw-bold text-white mb-5">BEM VINDO A NOSSA PLATAFORMA DE PRODUTOS PARA ACESSIBILIDADE</h1>
          <p class="lead mb-0" style="color: rgb(223, 223, 223);">Acesse seu perfil ou cadastre-se para adquirir seu produto</p>
        </div>
      </div>
    </header>

    <div class="container">
      <?php
        if ($result && $result->num_rows > 0) {
            echo "<div class='container-fluid'>";
            echo "<h1 class='titulo-categorias py-5 text-secondary'>Categorias Mais Cadastradas</h1>";
            echo "</div>";
         
          echo "<div class='item-container'>";
          while($row = $result->fetch_assoc()) {
            echo "<div class='categoria-item py-5 my-1'>";
            echo "<a href=''><img src='" . htmlspecialchars($row['ULTIMA_URL']) . "' alt='" . "'></a>";
            echo "<div class='titulo-categoria h2 py-3'>";
            echo $row['categoria'];
            echo "</div>";
            echo "</div>";
          }
          echo "</div>";
        }
      ?>
    </div>

    <footer class="text-center py-5" style="background-color: #001F36;">
      <div class="container text-white">
        <p class="mb-4 fw-bold fst-italic">*ESTA PLATAFORMA NÃO OFERECE SUPORTE DE TRANSAÇÕES BANCÁRIAS, ENTRE EM CONTATO COM O USUÁRIO DO ANÚNCIO PARA NEGOCIAÇÕES SOBRE O PAGAMENTO E RETIRADA DO PRODUTO.</p>
        <p class="mb-0">Conecta+ © 2025 Projeto Integrador III - Todos os direitos reservados.</p>
      </div>
    </footer>

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  </body>
</html>