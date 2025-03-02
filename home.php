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
    $conditions[] = "p.oferta IN ('" . implode("','", $oferta) . "')";
}

if (isset($_GET['categoria'])) {
    $categoria = $_GET['categoria'];
    $conditions[] = "p.categoria IN ('" . implode("','", $categoria) . "')";
}

if (isset($_GET['localizacao'])) {
    $localizacao = $_GET['localizacao'];
    $conditions[] = "e.uf IN ('" . implode("','", $localizacao) . "')";
   
}

// Cria a query com filtros, se houver
$sql = "SELECT p.id_produtos, p.nome_anunciante, p.telefone, p.produto, p.categoria, p.oferta, p.valor, p.descricao, p.nome_arquivo, p.path, e.bairro, e.localidade, e.uf 
        FROM tb_produtos p 
        JOIN tb_enderecos e ON p.id_produtos = e.tb_produtos_id_produtos";
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
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-white">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">
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

<div class="container mt-5">
    <div class="row">
        <!-- Barra lateral com filtros -->
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
                        <input class="form-check-input" type="checkbox" value="muletas" id="categoriaMuletas" name="categoria[]">
                        <label class="form-check-label" for="categoriaMuletas">Outros</label>
                    </div>
                </div>

                <h5 class="mt-4 mb-3">Localização</h5>
                <div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="sp" id="localSP" name="localizacao[]">
                        <label class="form-check-label" for="localSP">SP</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="rj" id="localMairipora" name="localizacao[]">
                        <label class="form-check-label" for="localMairipora">RJ</label>
                    </div>
                </div>

                <!-- Botão para aplicar o filtro -->
                <button type="submit" class="btn btn-primary mt-4">Aplicar Filtros</button>
                <!-- Botão para limpar os filtros -->
                <button type="button" class="btn btn-secondary mt-2" onclick="limparFiltros()">Limpar Filtros</button>
            </form>
        </div>

        <!-- Tabela de produtos -->
        <div class="col-lg-10">
            <h2 class="text-center">Lista de Produtos</h2>
            <div class="table-responsive mt-4">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Imagem</th>
                            <th>Nome do Anunciante</th>
                            <th>Produto</th>
                            <th>Categoria</th>
                            <th>Oferta</th>
                            <th>Valor</th>
                            <th>Descrição</th>
                            <th>Endereço</th>
                            <th>Telefone</th>
                            <th>Chamar no Whatsapp</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result && $result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td><img src='" . htmlspecialchars($row['path']) . "' alt='" . htmlspecialchars($row['nome_arquivo']) . "' style='max-width: 150px; max-height: 150px;'></td>";
                                echo "<td>" . htmlspecialchars($row['nome_anunciante']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['produto']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['categoria']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['oferta']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['valor']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['descricao']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['bairro']) . ", " . htmlspecialchars($row['localidade']) . " - " . htmlspecialchars($row['uf']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['telefone']) . "</td>";
                                echo "<td><a href='https://api.whatsapp.com/send?phone=55" . htmlspecialchars($row['telefone']) . "' target='_blank' class='btn btn-success'><i class='fab fa-whatsapp'></i></a></td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='10' class='text-center'>Nenhum produto encontrado.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    function limparFiltros() {
        const form = document.getElementById('filterForm');
        form.reset(); // Reseta os campos do formulário

        // Redireciona para a mesma página sem os parâmetros da URL
        window.location.href = window.location.pathname;
    }
</script>

<footer class="text-center py-5" style="background-color: #001F36;">
    <div class="container text-white">
        <p class="mb-4 fw-bold fst-italic">*ESTA PLATAFORMA NÃO OFERECE SUPORTE DE TRANSAÇÕES BANCÁRIAS, ENTRE EM CONTATO COM O USUÁRIO DO ANÚNCIO PARA NEGOCIAÇÕES SOBRE O PAGAMENTO E RETIRADA DO PRODUTO.</p>
        <p class="mb-0">Conecta+ © 2025 Projeto Integrador III - Todos os direitos reservados.</p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
