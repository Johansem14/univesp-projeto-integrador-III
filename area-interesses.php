<?php
  include("conexao.php");
  session_start();
  $sql = "SELECT * FROM tb_area_interesse";
  $result = $conn->query($sql);
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minha Área de Interesses</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">


    <style>
        .container_interesse{
            background-color: #fff;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1);
        }

        .botoes{
            display:flex;
            gap:10px;
        }

        .categoria_produto{
            font-size:20px;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white">
        <div class="container-fluid position-relative">
            <a class="navbar-brand" href="#">
                <img src="./img/logo.jpg" alt="Logo" style="max-height: 120px;">
            </a>
            <span class="navbar-text fs-4 fw-bold text-dark position-absolute start-50 translate-middle-x">MINHA ÁREA DE INTERESSES</span>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto flex-row">
                    <li class="nav-item">
                        <a class="nav-link fs-2 me-2" href="home.php"><i class="bi bi-house"></i></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fs-2 me-2" href="meus-produtos.php"><i class="bi bi-box"></i></a>
                    </li>
    
                    <!-- Dropdown do usuário -->
                    <li class="nav-item dropdown">
                        <a class="nav-link fs-2 me-2 dropdown-toggle" href="home.php" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li><a class="dropdown-item" href="meus-produtos.php">Meus Produtos</a></li>
                            <li><a class="dropdown-item" href="cad-prod.php">Cadastrar Produto</a></li>
                            <li><a class="dropdown-item" href="area-interesses.php">Minha Área de Interesses</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-danger" href="login.php"><i class="bi bi-box-arrow-right"></i> Sair</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Conteúdo Principal -->
    <div class="container-fluid py-5" style="background-color: #FFFAEB;">
        <div class="container text-center">
        <a href="cad-interesses.php">
            <button class="btn btn-primary mb-4">
                <i class="fas fa-plus">
                   
                </i> Adicionar Interesse</button>
                </a>
            
            <div class="row justify-content-center">
                <div class="col-md-8">
                   <?php
                     if($result && $result->num_rows > 0){
                        while ($row = $result->fetch_assoc()){
                          echo "<div class='container_interesse'>";
                          echo "<div class='item'>";
                          
                          echo "<h2>" . $produto = $row['nome_produto'] . "</h2>";
                          echo "<p class='categoria_produto'>" . "Categoria: " . $categoria = $row['categoria_interesse'] . "</p>";
                          echo "<div class='botoes'>";
                          echo "<a href='editar-interesses.php?id=" . $row['id'] . "' class='btn btn-primary'><i class='bi bi-pencil'></i> Editar Produto</a>";               
                          echo "<a href='remover-produto.php?id=" . $row['id'] . "' class='btn btn-danger' onclick=\"return confirm('Você tem certeza que deseja remover este produto?');\"><i class='bi bi-trash'></i> Remover Produto</a>";
                          echo "</div>";
                          echo "</div>";
                          echo "</div>";

                        }
                     }
                   ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Rodapé -->
    <footer class="text-center py-4 text-white" style="background-color: #001F36;">
        <div class="container">
            <p>&copy;2025 Projeto Integrador III - Todos os direitos reservados.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>