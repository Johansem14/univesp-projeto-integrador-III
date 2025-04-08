<?php

include("conexao.php");
session_start();

if (isset($_SESSION['usuario_id'])) {
    $usuario_id = $_SESSION['usuario_id'];
} else {
    echo "<script>alert('Usuário não está logado.');
    window.location.href = 'login.php'
    </script>";
    
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome = $_POST['nome'];
    $telefone = $_POST['telefone'];
    $produto = $_POST['produto'];
    $categoria = $_POST['categoria'];
    $oferta = $_POST['oferta'];
    $valor = $_POST['valor'];
    $descricao = $_POST['descricao'];
    $cep = $_POST['cep'];
    $logradouro = $_POST['logradouro'];
    $bairro = $_POST['bairro'];
    $localidade = $_POST['localidade'];
    $uf = $_POST['uf'];
    $_SESSION['usuario_id'] = $usuario_id;

    if(empty($_POST['oferta'])){
        echo "<script>alert('Selecione algum tipo de oferta');
        window.location.href = 'cad-prod.php'
        </script>";
    }

    if(empty($_POST['categoria'])){
        echo "<script>alert('Selecione alguma categoria');
        window.location.href = 'cad-prod.php'
        </script>";
    }

    if(strlen($telefone) !==11){
        echo "<script>alert('Informe um telefone válido');
        window.location.href = 'cad-prod.php'
        </script>"; 
    }

    

if(isset($_FILES['arquivo'])){
    $arquivo = $_FILES['arquivo'];

    if($arquivo['error'])
    echo "<script>alert('Falha ao enviar arquivo');</script>";


    if($arquivo['size'] > 2097152)
    echo "<script>alert('Arquivo muito grande! Max: 2MB');</script>";

    $pasta = "arquivos/";
    $nomeDoArquivo = $arquivo['name'];
    $novoNomeDoArquivo = uniqid();

    $extensao = strtolower(pathinfo($nomeDoArquivo, PATHINFO_EXTENSION));

    if($extensao != "jpg" && $extensao != 'png')
    echo "<script>alert('Tipo de arquivo não suportado, envie no formato jpg ou png');</script>";
else{
    $path = $pasta . $novoNomeDoArquivo . "." . $extensao;
    $deu_certo = move_uploaded_file($arquivo["tmp_name"], $path);
    if($deu_certo){
        $sqlproduto = "INSERT INTO tb_produtos (nome_anunciante, telefone, produto, categoria, oferta, valor, descricao, 
        nome_arquivo, path, tb_usuarios_id_usuarios) VALUES ('$nome', '$telefone', '$produto', '$categoria', '$oferta', 
        '$valor', '$descricao', '$nomeDoArquivo', '$path', '$usuario_id')";


        if($conn->query($sqlproduto) === TRUE){

            $id_produto = $conn->insert_id;

            $sqlendereco = "INSERT INTO tb_enderecos (cep, logradouro, bairro, localidade,uf, tb_produtos_id_produtos, id_usuario)
            VALUES ('$cep', '$logradouro', '$bairro', '$localidade', '$uf', '$id_produto', '$usuario_id')";

            if($conn->query($sqlendereco) === TRUE){

               
            echo "<script>alert('Produto Cadastrado com sucesso');
            window.location.href = 'home.php'
            </script>";

    
        
    }else  
        echo "<script>alert('Falha ao enviar arquivo');</script>" . $con->error;  

    }
}
}
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
        .text-center h2 {
    font-size: 1.5rem;
    margin: 0;
    position: absolute;
    left: 50%;
    transform: translateX(-50%);
        }

        @media (max-width: 991.98px) {
    .navbar-nav {
        justify-content: center;
    }

    .navbar-nav .nav-item {
        margin-right: 20px;
    }

    .navbar-nav .nav-item:last-child {
        margin-right: 0;
    }

    .navbar-nav .nav-link i {
        font-size: 1.5rem;
    }
}
    body {
        background-color: #FFFAEB;
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
                            <li><a class="dropdown-item text-danger" href="login.php"><i class=" bi bi-box-arrow-right"> Sair</i></a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container mt-5 bg-white p-4 rounded shadow" style="margin-bottom: 50px;">
        <form id="formCadastro" enctype="multipart/form-data" action="" method="POST">
            <div class="row">
                <!-- Parte Esquerda - Dados do Produto -->
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="nome" class="form-label fw-bold">Nome</label>
                        <input type="text" name="nome" class="form-control" id="nome" placeholder="Digite seu nome completo" required value="<?php if(isset($_POST['nome'])) echo $_POST['nome']?>">
                    </div>
                    <div class="mb-3">
                        <label for="telefone" class="form-label fw-bold">Telefone</label>
                        <input type="tel" name="telefone" class="form-control" id="telefone" maxlength="11" placeholder="Digite seu telefone com o DDD somente números" required value="<?php if(isset($_POST['telefone'])) echo $_POST['telefone']?>">
                    </div>
                    <div class="mb-3">
                        <label for="produto" class="form-label fw-bold">Produto</label>
                        <input type="text" name="produto" class="form-control" id="produto" placeholder="Digite o nome do produto" required value="<?php if(isset($_POST['produto'])) echo $_POST['produto']?>">
                    </div>
                    <div class="mb-3">
                        <label for="categoria" class="form-label fw-bold">Categoria</label>
                        <select class="form-select" id="categoria" name="categoria" required>
                        <option value="" disabled selected>Selecione a categoria do produto</option>
                        <option value="Cadeiras" <?php if(isset($_POST['categoria']) && $_POST['categoria'] == 'Cadeiras') echo 'selected'; ?>>Cadeiras</option>
                        <option value="Andadores" <?php if(isset($_POST['categoria']) && $_POST['categoria'] == 'Andadores') echo 'selected'; ?>>Andadores</option>
                        <option value="Muletas" <?php if(isset($_POST['categoria']) && $_POST['categoria'] == 'Muletas') echo 'selected'; ?>>Muletas</option>
                        <option value="Outros" <?php if(isset($_POST['categoria']) && $_POST['categoria'] == 'Outros') echo 'selected'; ?>>Outros</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="oferta" class="form-label fw-bold">Oferta</label>
                        <select class="form-select" id="oferta"  name="oferta" onchange="atualizarValor()" required>
                        <option value="Pago" <?php if(isset($_POST['oferta']) && $_POST['oferta'] == 'Pago') echo 'selected'; ?>>Pago</option>
                        <option value="Gratuito" <?php if(isset($_POST['oferta']) && $_POST['oferta'] == 'Gratuito') echo 'selected'; ?>>Gratuito</option>
                        <option value="Doação" <?php if(isset($_POST['oferta']) && $_POST['oferta'] == 'Doação') echo 'selected'; ?>>Doação</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="valor" class="form-label fw-bold">*Valor (apenas em ofertas com valores)</label>
                        <input type="text" name="valor" class="form-control" id="valor" placeholder="Digite o valor do produto" required value="<?php if(isset($_POST['valor'])) echo $_POST['valor']?>">
                    </div>
                    <div class="mb-3">
                        <label for="descricao" class="form-label fw-bold">Descrição</label>
                        <textarea class="form-control" name="descricao" id="descricao" rows="3" placeholder="Digite as características do produto" required> <?php if(isset($_POST['descricao'])) echo $_POST['descricao']?></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="foto" class="form-label fw-bold">Adicionar foto do produto</label>
                        <input name="arquivo" type="file" class="form-controls" id="foto" required>
                        <!--<button type="submit">Enviar arquivo</button> -->
                    </div>
                </div>

                <!-- Parte Direita - CEP e Inserção de Foto -->
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="cep" class="form-label fw-bold">CEP</label>
                        <input type="text" class="form-control" name="cep" id="cep" placeholder="Digite o número do seu CEP" required value="<?php if(isset($_POST['cep'])) echo $_POST['cep']?>">
                    </div>
                    <div class="mb-3">
                        <label for="endereco" class="form-label fw-bold">Logradouro</label>
                        <input type="text" class="form-control" name="logradouro" id="logradouro" placeholder="" required value="<?php if(isset($_POST['logradouro'])) echo $_POST['logradouro']?>">
                    </div>
                    <div class="mb-3">
                        <label for="bairro" class="form-label fw-bold">Bairro</label>
                        <input type="text" class="form-control" name="bairro" id="bairro" placeholder="" required value="<?php if(isset($_POST['bairro'])) echo $_POST['bairro']?>">
                    </div>
                    <div class="mb-3">
                        <label for="municipio" class="form-label fw-bold">Localidade</label>
                        <input type="text" class="form-control" name="localidade" id="localidade" placeholder="" required value="<?php if(isset($_POST['localidade'])) echo $_POST['localidade']?>">
                    </div>
                    <div class="mb-3">
                        <label for="uf" class="form-label fw-bold">UF</label>
                        <input type="text" class="form-control" name="uf" id="uf" placeholder="" required value="<?php if(isset($_POST['uf'])) echo $_POST['uf']?>">
                    </div>
                    
                </div>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-success mt-3">Cadastrar</button>
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
    // Adiciona o evento 'onblur' ao campo de CEP
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

<script>
function atualizarValor() {
    const oferta = document.getElementById('oferta').value;
    const valorInput = document.getElementById('valor');

    // Verifica se a oferta é "Gratuito" ou "Doação"
    if (oferta === 'Gratuito' || oferta === 'Doação') {
        valorInput.value = '0'; // Define o valor como 0
        valorInput.readOnly = true; // Bloqueia a edição
    } else {
        valorInput.value = ''; // Limpa o valor se for "Pago" ou não selecionado
        valorInput.readOnly = false; // Permite edição
    }
}
</script>
    </body>
</html>