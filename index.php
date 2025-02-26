<!doctype html>
<html lang="pt-br">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>&copy;Conecta+</title>
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
            <div class="container-fluid d-flex flex-column justify-content-center align-items-center py-5" style="background-color:#2D6073;">
                <div style="max-width: 500px; width: 100%;">
                    <h1 class="display-5 fw-bold text-white mb-5">BEM VINDO A NOSSA PLATAFORMA DE PRODUTOS PARA ACESSIBILIDADE</h1>
                    <p class="lead mb-0" style="color: rgb(223, 223, 223);">Acesse seu perfil ou cadastre-se para adquirir seu produto</p>
                </div>
            </div>
        </header>
    
        <section class="py-5" style="background-color: #f0f7da;">
            <div class="container">
                <h2 class="text-center mb-4">PRODUTOS EM DESTAQUE</h2>
                <div class="row row-cols-1 row-cols-md-4 g-4">
                    <!-- Produto 1 -->
                    <div class="col">
                        <div class="card h-100">
                            <img src="./img/cadeira-de-rodas.jpg" class="card-img-top" alt="Cadeira de Rodas">
                            <div class="card-body">
                                <h5 class="card-title">Cadeira de Rodas</h5>
                                <p class="card-text" style="color: rgb(107, 107, 107);">Fabricada em tubos de aço...</p>
                            </div>
                        </div>
                    </div>
                    <!-- Produto 2 -->
                    <div class="col">
                        <div class="card h-100">
                            <img src="./img/andador.jpg" class="card-img-top" alt="Andador de Alumínio">
                            <div class="card-body">
                                <h5 class="card-title">Andador de Alumínio</h5>
                                <p class="card-text" style="color: rgb(107, 107, 107);">Andador dobrável que suporta...</p>
                            </div>
                        </div>
                    </div>
                    <!-- Produto 3 -->
                    <div class="col">
                        <div class="card h-100">
                            <img src="./img/muleta-canadense.jpg" class="card-img-top" alt="Muleta Canadense">
                            <div class="card-body">
                                <h5 class="card-title">Muleta Canadense</h5>
                                <p class="card-text" style="color: rgb(107, 107, 107);">Construída em alumínio com...</p>
                            </div>
                        </div>
                    </div>
                    <!-- Produto 4 -->
                    <div class="col">
                        <div class="card h-100">
                            <img src="./img/protese-de-perna.jpg" class="card-img-top" alt="Prótese de Perna">
                            <div class="card-body">
                                <h5 class="card-title">Prótese de Perna</h5>
                                <p class="card-text" style="color: rgb(107, 107, 107);">Confeccionado em fibra de...</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <footer class="text-center py-5" style="background-color: #1f192f;">
            <div class="container text-white">
                <p class="mb-4 fw-bold fst-italic">*ESTA PLATAFORMA NÃO OFERECE SUPORTE DE TRANSAÇÕES BANCÁRIAS, ENTRE EM CONTATO COM O USUÁRIO DO ANÚNCIO PARA NEGOCIAÇÕES SOBRE O PAGAMENTO E RETIRADA DO PRODUTO.</p>
                <p class="mb-0">Conecta+ © 2024 Projeto Integrador II - Todos os direitos reservados.</p>
            </div>
        </footer>
  
        <!-- Option 1: Bootstrap Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    </body>
</html>

