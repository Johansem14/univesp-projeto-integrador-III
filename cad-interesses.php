<?php
include("conexao.php");
session_start();

if (!isset($_SESSION['usuario_id'])){
    echo "<script>alert('Usuário não está logado.');
    window.location.href = 'login.php'
    </script>";
}else{
    $usuario_id = $_SESSION['usuario_id'];
}

if ($_SERVER["REQUEST_METHOD"] === "POST"){
    $nome = $_POST['produto'];
    $produto = $_POST['categoria'];

    if(empty($nome)){
        echo "<script>alert('Digite o nome de um produto.');
        window.location.href = 'cad-interesses.php'
        </script>";

    }
    if($produto ===''){
        echo "<script>alert('Selecione uma categoria.');
        window.location.href = 'cad-interesses.php'
        </script>";
    }
$sql = "INSERT INTO tb_area_interesse (tb_usuarios_id_usuarios, nome_produto, categoria_interesse, data_interesse) VALUES(?,?,?, NOW())";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iss", $usuario_id, $nome, $produto);

if($stmt->execute()){
    echo "<script>alert('Produto Cadastrado com Sucesso.');
    window.location.href = 'cad-interesses.php'
    </script>";

}else{
    echo "<script>alert('Produto Não Cadastrado.');
    window.location.href = 'cad-interesses.php'
    </script>";
}
}

?>





<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Área de Interresse</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <style>
        body {
            background-color: #FFFAEB;
        }
        .form-container {
            display:flex;
            background-color: white;
            justify-content: center;
            align-items:center;
            padding: 150px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            max-width: 25%;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="./img/logo.jpg" alt="Logo" style="max-height: 120px;">
            </a>
            <span class="navbar-text fs-4 fw-bold text-dark position-absolute start-50 translate-middle-x">CADASTRO DA ÁREA DE INTERESSE</span>
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
    <div class="d-flex justify-content-center align-items-center vh-100">
        <div class="form-container container-fluid">
            <form class="col-12" method="POST" action="">
                <div class="mb-3">
                    <h4>Digite o nome do produto:</h4>
                    <input type="text" class="form-control" id="nomeProduto" name="produto" placeholder="Insira aqui...">
                </div>
    
                <div class="mb-3">
                    <select class="form-select" id="categoriaProduto" name="categoria">
                        <option value="" disable selected>Selecione a categoria do Produto</option>
                        <option value="Cadeiras">Cadeiras</option>
                        <option value="Andadores">Andadores</option>
                        <option value="Muletas">Muletas</option>
                        <option value="Outros">Outros</option>
                    </select>
                </div>
    
                <div class="d-flex gap-2 justify-content-center">
                    <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> Salvar</button>
                    <button type="button" class="btn btn-danger"><i class="fas fa-times"></i> Cancelar</button>
                </div>
            </form>
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