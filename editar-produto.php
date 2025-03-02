<?php
include("conexao.php");
session_start();

if (!isset($_SESSION['usuario_id'])) {
    echo "<script>alert('Usuário não está logado.'); window.location.href = 'home.php';</script>";
    exit;
}

$usuario_id = $_SESSION['usuario_id'];

// Inicializa as variáveis
$nome = $telefone = $produto = $categoria = $oferta = $valor = $descricao = $cep = $logradouro = $bairro = $localidade = $uf = '';
$path = '';
$nomeDoArquivo = '';

$id_produto = null; // Inicializa o ID do produto

// Obter o ID do produto da URL
if (isset($_GET['id'])) {
    $id_produto = intval($_GET['id']);
} else {
    echo "<script>alert('ID do produto não fornecido.'); window.location.href = 'home.php';</script>";
    exit;
}

// Consulta para buscar os dados do produto
$sql = "SELECT p.nome_anunciante, p.telefone, p.produto, p.categoria, p.oferta, p.valor, p.descricao, p.nome_arquivo, p.path, e.cep, e.logradouro, e.bairro, e.localidade, e.uf
        FROM tb_produtos p
        JOIN tb_enderecos e ON p.id_produtos = e.tb_produtos_id_produtos
        WHERE p.id_produtos = '$id_produto' AND p.tb_usuarios_id_usuarios = '$usuario_id'";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $data = $result->fetch_assoc();
    // Preenche as variáveis com os dados do banco
    $nome = $data['nome_anunciante'];
    $telefone = $data['telefone'];
    $produto = $data['produto'];
    $categoria = $data['categoria'];
    $oferta = $data['oferta'];
    $valor = $data['valor'];
    $descricao = $data['descricao'];
    $nomeDoArquivo = $data['nome_arquivo'];
    $path = $data['path'];
    $cep = $data['cep'];
    $logradouro = $data['logradouro'];
    $bairro = $data['bairro'];
    $localidade = $data['localidade'];
    $uf = $data['uf'];
} else {
    echo "<script>alert('Produto não encontrado.'); window.location.href = 'home.php';</script>";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Sanitize input
    $nome = $conn->real_escape_string($_POST['nome']);
    $telefone = $conn->real_escape_string($_POST['telefone']);
    $produto = $conn->real_escape_string($_POST['produto']);
    $categoria = $conn->real_escape_string($_POST['categoria']);
    $oferta = $conn->real_escape_string($_POST['oferta']);
    $valor = $conn->real_escape_string($_POST['valor']);
    $descricao = $conn->real_escape_string($_POST['descricao']);
    $cep = $conn->real_escape_string($_POST['cep']);
    $logradouro = $conn->real_escape_string($_POST['logradouro']);
    $bairro = $conn->real_escape_string($_POST['bairro']);
    $localidade = $conn->real_escape_string($_POST['localidade']);
    $uf = $conn->real_escape_string($_POST['uf']);

    // Lógica de upload de arquivo
    if (isset($_FILES['arquivo']) && $_FILES['arquivo']['error'] == 0) {
        $arquivo = $_FILES['arquivo'];

        // Validação de arquivo
        if ($arquivo['size'] > 2097152) {
            echo "<script>alert('Arquivo muito grande! Max: 2MB');</script>";
        } else {
            $extensao = strtolower(pathinfo($arquivo['name'], PATHINFO_EXTENSION));
            if ($extensao != "jpg" && $extensao != "png") {
                echo "<script>alert('Tipo de arquivo não suportado, envie no formato jpg ou png');</script>";
            } else {
                // Renomeia o arquivo e move para a pasta
                $novoNomeDoArquivo = uniqid() . '.' . $extensao;
                $path = 'arquivos/' . $novoNomeDoArquivo;
                if (move_uploaded_file($arquivo['tmp_name'], $path)) {
                    $nomeDoArquivo = $novoNomeDoArquivo; // Atualiza com o novo nome
                } else {
                    echo "<script>alert('Falha ao enviar arquivo');</script>";
                }
            }
        }
    }

    // Atualiza dados no banco
    $sqlproduto = "UPDATE tb_produtos SET 
                       nome_anunciante='$nome', 
                       telefone='$telefone', 
                       produto='$produto', 
                       categoria='$categoria', 
                       oferta='$oferta', 
                       valor='$valor', 
                       descricao='$descricao', 
                       nome_arquivo='$nomeDoArquivo', 
                       path='$path' 
                   WHERE id_produtos='$id_produto' AND tb_usuarios_id_usuarios='$usuario_id'";

    if ($conn->query($sqlproduto) === TRUE) {
        $sqlendereco = "UPDATE tb_enderecos SET 
                            cep='$cep', 
                            logradouro='$logradouro', 
                            bairro='$bairro', 
                            localidade='$localidade', 
                            uf='$uf' 
                        WHERE tb_produtos_id_produtos='$id_produto' AND id_usuario='$usuario_id'";

        if ($conn->query($sqlendereco) === TRUE) {
            echo "<script>alert('Produto atualizado com sucesso!'); window.location.href = 'home.php';</script>";
            exit;
        } else {
            echo "<script>alert('Erro ao atualizar endereço: " . $conn->error . "');</script>";
        }
    } else {
        echo "<script>alert('Erro ao atualizar produto: " . $conn->error . "');</script>";
    }
}
?>

<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Produto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #FFFAEB;
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
            <div class="text-center" style="text-align: center; justify-content: center;">
                <h2>CADASTRO DE PRODUTO</h2>
            </div>
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
                    <li class="nav-item dropdown">
                        <a class="nav-link fs-2 me-2 dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li><a class="dropdown-item" href="meus-produtos.php">Meus Produtos</a></li>
                            <li><a class="dropdown-item" href="cad-prod.php">Cadastrar Produto</a></li>
                            <li><a class="dropdown-item" href="area-interesses.php">Minha Área de Interesses</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-danger" href="index.php"><i class="bi bi-box-arrow-right"> Sair</i></a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5 bg-white p-4 rounded shadow">
        <form id="formCadastro" enctype="multipart/form-data" action="" method="POST">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="nome" class="form-label fw-bold">Nome</label>
                        <input type="text" name="nome" class="form-control" id="nome" placeholder="Digite seu nome completo" value="<?php echo htmlspecialchars($nome); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="telefone" class="form-label fw-bold">Telefone</label>
                        <input type="tel" maxlength="11" minlength="11" name="telefone" class="form-control" id="telefone" placeholder="Digite seu telefone com o DDD" value="<?php echo htmlspecialchars($telefone); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="produto" class="form-label fw-bold">Produto</label>
                        <input type="text" name="produto" class="form-control" id="produto" placeholder="Digite o nome do produto" value="<?php echo htmlspecialchars($produto); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="categoria" class="form-label fw-bold">Categoria</label>
                        <select class="form-select" id="categoria" name="categoria">
                            <option value="" disabled <?php echo empty($categoria) ? 'selected' : ''; ?>>Selecione a categoria do produto</option>
                            <option value="Cadeiras" <?php echo $categoria === 'Cadeiras' ? 'selected' : ''; ?>>Cadeiras</option>
                            <option value="Andadores" <?php echo $categoria === 'Andadores' ? 'selected' : ''; ?>>Andadores</option>
                            <option value="Muletas" <?php echo $categoria === 'Muletas' ? 'selected' : ''; ?>>Muletas</option>
                            <option value="Outros" <?php echo $categoria === 'Outros' ? 'selected' : ''; ?>>Outros</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="oferta" class="form-label fw-bold">Oferta</label>
                        <select class="form-select" id="oferta" name="oferta">
                            <option value="" disabled <?php echo empty($oferta) ? 'selected' : ''; ?>>Selecione o tipo de oferta</option>
                            <option value="Pago" <?php echo $oferta === 'Pago' ? 'selected' : ''; ?>>Pago</option>
                            <option value="Gratuito" <?php echo $oferta === 'Gratuito' ? 'selected' : ''; ?>>Gratuito</option>
                            <option value="Doação" <?php echo $oferta === 'Doação' ? 'selected' : ''; ?>>Doação</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="valor" class="form-label fw-bold">*Valor (apenas em ofertas com valores)</label>
                        <input type="text" name="valor" class="form-control" id="valor" placeholder="Digite o valor do produto" value="<?php echo htmlspecialchars($valor); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="descricao" class="form-label fw-bold">Descrição</label>
                        <textarea class="form-control" name="descricao" id="descricao" rows="3" placeholder="Digite as características do produto" required><?php echo htmlspecialchars($descricao); ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="foto" class="form-label fw-bold">Adicionar foto do produto</label>
                        <input name="arquivo" type="file" class="form-control" id="foto">
                        
                        <?php if (!empty($path)): ?>
                            <div class="mt-2">
                                <label class="form-label fw-bold">Imagem atual:</label>
                                <img src="<?php echo htmlspecialchars($path); ?>" alt="Imagem do produto" class="img-fluid" style="max-width: 100%; height: auto;">
                            </div>
                        <?php else: ?>
                            <p>Imagem não disponível.</p>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="cep" class="form-label fw-bold">CEP</label>
                        <input type="text" class="form-control" name="cep" id="cep" placeholder="Digite o número do seu CEP" value="<?php echo htmlspecialchars($cep); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="endereco" class="form-label fw-bold">Logradouro</label>
                        <input type="text" class="form-control" name="logradouro" id="logradouro" value="<?php echo htmlspecialchars($logradouro); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="bairro" class="form-label fw-bold">Bairro</label>
                        <input type="text" class="form-control" name="bairro" id="bairro" value="<?php echo htmlspecialchars($bairro); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="municipio" class="form-label fw-bold">Localidade</label>
                        <input type="text" class="form-control" name="localidade" id="localidade" value="<?php echo htmlspecialchars($localidade); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="uf" class="form-label fw-bold">UF</label>
                        <input type="text" class="form-control" name="uf" id="uf" value="<?php echo htmlspecialchars($uf); ?>" required>
                    </div>
                </div>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-success mt-3">Atualizar</button>
            </div>
        </form>
    </div>

    <footer class="text-center py-5" style="background-color: #001F36;">
        <div class="container text-white">
            <p class="mb-0">Conecta+ © 2025 Projeto Integrador III - Todos os direitos reservados.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
document.addEventListener('DOMContentLoaded', () => {
    document.getElementById('cep').addEventListener('blur', () => {
        const cep = document.getElementById('cep').value.replace(/\D/g, '');
        if (cep.length === 8) {
            fetch(`https://viacep.com.br/ws/${cep}/json/`)
                .then(response => response.json())
                .then(data => {
                    if (data.erro) {
                        alert('CEP não encontrado.');
                        document.getElementById('logradouro').value = '';
                        document.getElementById('bairro').value = '';
                        document.getElementById('localidade').value = '';
                        document.getElementById('uf').value = '';
                    } else {
                        document.getElementById('logradouro').value = data.logradouro;
                        document.getElementById('bairro').value = data.bairro;
                        document.getElementById('localidade').value = data.localidade;
                        document.getElementById('uf').value = data.uf;
                    }
                })
                .catch(error => {
                    console.error('Erro ao buscar CEP:', error);
                    alert('Ocorreu um erro ao buscar o CEP.');
                });
        } else {
            alert('CEP inválido. Deve conter 8 dígitos.');
        }
    });
});
</script>
</body>
</html>
