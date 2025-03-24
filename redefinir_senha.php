<?php
require "conexao.php";
$token = $_GET["token"] ?? '';

$sql = "SELECT id_usuarios FROM tb_usuarios WHERE token_recuperacao = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $token);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows == 0) {
    echo "<script>alert('Token inválido ou expirado');
    window.location.href = 'login.php';
    </script>";
}
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
    <section class="container mt-5">
    <div class="row justify-content-center">
        <form class="col-12 col-sm-6" action="atualizar-senha.php" method="post">
            <h3>Informe sua nova Senha:</h3>
            <input type="hidden" name="token" value="<?= htmlspecialchars($token)?>">
            <input class="form-control" placeholder="Digite aqui nova Senha..." type="password" name="senha" required>
            <div class="btn-recuperar_senha d-flex justify-content-center">
            <button class="mt-3 btn btn-primary mb-5" type="submit">Redefinir Senha</button>
            </div>
        </form>
    </div>
    </section>
</body>
</html>

