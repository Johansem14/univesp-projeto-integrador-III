<?php
include("conexao.php");
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    echo "<script>alert('Usuário não está logado.'); window.location.href = 'login.php';</script>";
    exit;
}

// Recupera o ID do usuário logado
$usuario_id = $_SESSION['usuario_id'];

// Cria a query para buscar os produtos do usuário
$sql = "SELECT p.id_produtos, p.nome_anunciante, p.telefone, p.produto, p.categoria, p.oferta, p.valor, p.descricao, p.nome_arquivo, p.path, e.bairro, e.localidade, e.uf 
        FROM tb_produtos p 
        JOIN tb_enderecos e ON p.id_produtos = e.tb_produtos_id_produtos 
        WHERE p.tb_usuarios_id_usuarios = $usuario_id 
        ORDER BY p.id_produtos DESC";

// Executa a query
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meus Produtos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #FFFAEB;
        }
        .favorite-item {
            background-color: #fff;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1);
        }
        .favorite-item img {
            max-width: 100px;
            border-radius: 10px;
        }
        .my-prod-details {
            flex-grow: 1;
            margin-left: 20px;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white">
        <div class="container-fluid">
            <a class="navbar-brand">
                <img src="./img/logo.jpg" alt="Logo" style="max-height: 120px;">
            </a>
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
                        <a class="nav-link fs-2 me-2 dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
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

    <div class="container mt-4">
        <h3 class="mb-4">Meus Produtos</h3>

        <?php
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div class='favorite-item'>";
                echo "<a href=''><img src='" . htmlspecialchars($row['path']) . "' alt='" . htmlspecialchars($row['nome_arquivo']) . "'></a>";
                echo "<div class='my-prod-details'>";
                echo "<h5>" . htmlspecialchars($row['produto']) . "</h5>";
                echo "<p>R$ " . htmlspecialchars($row['valor']) . "</p>";
                echo "<p>" . htmlspecialchars($row['bairro']) . ", " . htmlspecialchars($row['localidade']) . " - " . htmlspecialchars($row['uf']) . "</p>";
                echo "</div>";
                echo "<div class='d-grid gap-2 d-md-flex justify-content-md-end'>";
                
                // Link para remover o produto
                echo "<a href='editar-produto.php?id=" . $row['id_produtos'] . "' class='btn btn-primary'><i class='bi bi-pencil'></i> Editar Produto</a>";               
                echo "<a href='remover-produto.php?id=" . $row['id_produtos'] . "' class='btn btn-danger' onclick=\"return confirm('Você tem certeza que deseja remover este produto?');\"><i class='bi bi-trash'></i> Remover Produto</a>";
                echo "</div>";
                echo "</div>";
            }
        } else {
            echo "<div class='alert alert-warning' role='alert'>Nenhum produto encontrado.</div>";
        }
        ?>
    </div>

    <footer class="text-center py-5" style="background-color: #001F36;">
        <div class="container text-white">
            <p class="mb-0">Conecta+ © 2025 Projeto Integrador III - Todos os direitos reservados.</p>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>
