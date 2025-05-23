<?php
include("conexao.php");
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    echo "<script>alert('Usuário não está logado.'); window.location.href = 'login.php';</script>";
    exit;
}

// Inicializa o array de condições
$conditions = [];

// Verifica cada filtro e adiciona as condições ao array
if (isset($_GET['oferta'])) {
    $oferta = $_GET['oferta'];
    $conditions[] = "p.oferta IN ('" . implode("','", array_map([$conn,'real_escape_string'], $oferta)) . "')";
}

if (isset($_GET['categoria'])) {
    $categoria = $_GET['categoria'];
    $conditions[] = "p.categoria IN ('" . implode("','", array_map([$conn,'real_escape_string'], $categoria)) . "')";
}

if (isset($_GET['localizacao'])) {
    $localizacao = $_GET['localizacao'];
    $conditions[] = "e.uf IN ('" . implode("','", array_map([$conn,'real_escape_string'], $localizacao)) . "')";
}

$sql = "SELECT p.id_produtos, p.nome_anunciante, p.telefone, p.produto, p.categoria, p.oferta, p.valor, p.descricao, p.nome_arquivo, p.path, e.bairro, e.localidade, e.uf 
FROM tb_produtos p 
JOIN tb_enderecos e ON p.id_produtos = e.tb_produtos_id_produtos";

// Filtro de pesquisa
if (isset($_POST['pesquisar']) && !empty($_POST['pesquisar'])) {
    $pesquisar = $_POST['pesquisar'];
    $conditions[] = "p.produto LIKE '%" . $conn->real_escape_string($pesquisar) . "%'";
}

if (!empty($conditions)) {
    $sql .= " WHERE " . implode(" AND ", $conditions);
}

$sql .= " ORDER BY p.id_produtos DESC";

$result = $conn->query($sql);
?>

<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Produtos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .item-container{
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            justify-items: center;
        }

        .home-produtos{
            box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1);
            padding: 40px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            width: 100%;
            overflow: hidden;
        }

        .home-produtos img{
            margin: 0 auto;
            display: block;
            height: 200px;
        }

        .home-detalhes{
            text-align: center;
        }

        @media (max-width: 768px) {
            .item-container {
                grid-template-columns: 1fr;
            }
        }

        .form-pesquisar{
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .navbar-title {
            font-size: 1.5rem;
            font-weight: bold;
            color: #000;
            text-align: center;
            width: 100%;
        }
        @media (min-width: 992px) {
        .navbar-header {
            position: relative;
        }

        .navbar-title {
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            margin-top: 0;
            white-space: nowrap;
        }
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-white">
    <div class="container-fluid d-flex flex-column flex-lg-row align-items-center justify-content-between">
        <!-- Logo + Título -->
        <div class="d-flex flex-column flex-lg-row align-items-center justify-content-center">
            <a class="navbar-brand me-lg-3" href="#">
                <img src="./img/logo.jpg" alt="Logo" style="max-height: 120px;">
            </a>
            <span class="navbar-title fs-4 fw-bold text-dark text-center mt-2 mt-lg-0">PRODUTOS CADASTRADOS</span>
        </div>

        <!-- Botões / Ícones à direita -->
        <div class="d-flex align-items-center mt-3 mt-lg-0">
            <button class="navbar-toggler me-2" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
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
                    <li class="nav-item">
                        <a class="nav-link fs-2 me-2" href="contato.php"><i class="bi bi-envelope"></i></a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link fs-2 me-2 dropdown-toggle" href="home.php" id="userDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
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
    </div>
</nav>

<div class="container mt-5">
    <div class="row">
        <div class="col-lg-2 bg-light p-4">
            <form id="filterForm" method="GET" action="">
                <h5 class="mb-3">Tipo de Oferta</h5>
                <div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="gratuito" id="ofertaGratuita" name="oferta[]">
                        <label class="form-check-label" for="ofertaGratuita">Gratuito</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="pago" id="ofertaPaga" name="oferta[]">
                        <label class="form-check-label" for="ofertaPaga">Pago</label>
                    </div>
                </div>

                <h5 class="mt-4 mb-3">Categoria</h5>
                <div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="cadeiras" id="categoriaCadeiras" name="categoria[]">
                        <label class="form-check-label" for="categoriaCadeiras">Cadeiras</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="andadores" id="categoriaAndadores" name="categoria[]">
                        <label class="form-check-label" for="categoriaAndadores">Andadores</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="muletas" id="categoriaMuletas" name="categoria[]">
                        <label class="form-check-label" for="categoriaMuletas">Muletas</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="Outros" id="categoriaMuletas" name="categoria[]">
                        <label class="form-check-label" for="categoriaMuletas">Outros</label>
                    </div>
                </div>

                <?php
                    $sql_uf = "SELECT DISTINCT uf FROM tb_enderecos";
                    $result_uf = $conn->query($sql_uf);
                ?>
                <h5 class="mt-4 mb-3">Localização</h5>
                <?php
                    if ($result_uf->num_rows > 0) {
                        while ($row = $result_uf->fetch_assoc()) {
                            echo "<div class='form-check'>
                            <input class='form-check-input' type='checkbox' value='" . $row['uf'] . "' id='uf" . $row['uf'] . "' name='localizacao[]'>
                            <label class='form-check-label' for='uf" . $row['uf'] . "'>" . strtoupper($row['uf']) . "</label>
                            </div>";
                        }
                    }
                ?>
                <button type="submit" class="btn btn-primary mt-4">Aplicar Filtros</button>
                <button type="button" class="btn btn-secondary mt-2" onclick="limparFiltros()">Limpar Filtros</button>
            </form>
        </div>

        <div class="col-lg-10">
            <section class="pesquisar">
                <form action="" method="POST">
                    <div class="col-10 col-md-6 mt-3 form-pesquisar">
                        <input type="text" class="form-control" placeholder="Pesquisar Produto..." name="pesquisar">
                        <div class="btn-pesquisar">
                            <button type="submit" class="btn btn-secondary">Pesquisar</button>
                        </div>
                        <div class="btn-limpar">
                            <a href="home.php">
                            <button type="button" class="btn btn-danger" onclick="limparFiltros()">Limpar</button>
                            </a>
                        </div>
                    </div>
                </form>
            </section>
            <h2 class="text-center mt-3">Lista de Produtos</h2>

            <div class='item-container mt-5'>
                <?php
                    if ($result && $result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<div class='home-produtos pt-5'>";
                            echo "<img src='" . htmlspecialchars($row['path']) . "' alt='" . htmlspecialchars($row['nome_arquivo']) . "' style='max-width: 150px; max-height: 150px;'>";
                            echo "<div class='home-detalhes mt-2'>";
                            echo "<span class='h4 text-primary'>" . htmlspecialchars($row['produto']) . "</span><br>";
                            echo "<div class='mt-2'>";
                            echo "<span><strong>R$</strong> " . htmlspecialchars($row['valor']) . "</span><br>";
                            echo "<span>" . htmlspecialchars($row['uf']) . "</span><br>";
                            echo "</div>";
                            echo "<div class='home-btn pt-3 pb-2'>";
                            echo "<a href='https://api.whatsapp.com/send?phone=55" . htmlspecialchars($row['telefone']) . "' target='_blank' class='btn btn-success'>Contato <i class='fab fa-whatsapp'></i></a>";
                            echo "</div>";
                            echo "</div>";
                            echo "</div>";
                        }
                    } else {
                        echo "<tr><td colspan='10' class='text-center'>Nenhum produto encontrado.</td></tr>";
                    }
                ?>
            </div>
        </div>
    </div>
</div>

<script>
    function limparFiltros() {
        const form = document.getElementById('filterForm');
        form.reset();
        window.location.href = window.location.pathname;
    }
</script>

<footer class="text-center py-5" style="background-color: #001F36;">
    <div class="container text-white">
        <p class="mb-4 fw-bold fst-italic">*ESTA PLATAFORMA NÃO OFERECE SUPORTE DE TRANSAÇÕES BANCÁRIAS, ENTRE EM CONTATO COM O USUÁRIO DO ANÚNCIO PARA NEGOCIAÇÕES SOBRE O PAGAMENTO E RETIRADA DO PRODUTO.</p>
        <p class="mb-0">Conecta+ © 2025 Projeto Integrador III - Todos os direitos reservados.</p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js">

function limparFiltros() {
    const form = document.getElementById('filterForm');
    form.reset(); // Reseta os checkboxes e campos do filtro

    // Remove os parâmetros da URL (se houver)
    const url = window.location.href.split('?')[0]; // Pega apenas a URL sem parâmetros
    window.location.href = url; // Redireciona para a mesma URL sem parâmetros
}
</script>


</body>
</html>