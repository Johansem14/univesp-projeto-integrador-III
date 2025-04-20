<?php
include("conexao.php");
session_start();


?>
<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Senha</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-white">
        <div class="container-fluid position-relative">
            <a class="navbar-brand" href="#">
                <img src="./img/logo.jpg" alt="Logo" style="max-height: 120px;">
            </a>
            <span class="navbar-text fs-4 fw-bold text-dark position-absolute start-50 translate-middle-x">RECUPERAR SENHA</span>
       </div>
    </nav>

    <section class="container">
        <div class="row justify-content-center">
            <form class="col-12 col-sm-6" action="processa-recuperacao.php" method="post">
                <input class="form-control" placeholder="Digite seu email aqui..." type="email" name="email" required>
                <div class="btn-recuperar_senha d-flex justify-content-center">
                <button class="mt-3 btn btn-primary mb-5" type="submit">Recuperar Senha</button>
                </div>
            </form>
        </div>
    </section>



<footer class="text-center py-5" style="background-color: #001F36;">
    <div class="container text-white">
        <p class="mb-0">Conecta+ © 2025 Projeto Integrador III - Todos os direitos reservados.</p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>