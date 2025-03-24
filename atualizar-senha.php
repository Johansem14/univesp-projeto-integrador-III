<?php
require 'conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $token = $_POST["token"];
    $nova_senha = password_hash($_POST["senha"], PASSWORD_DEFAULT);

    // Verificar se o token existe
    $sql = "SELECT id_usuarios FROM tb_usuarios WHERE token_recuperacao = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Atualizar a senha e remover o token
        $sql = "UPDATE tb_usuarios SET senha = ?, token_recuperacao = NULL WHERE token_recuperacao = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $nova_senha, $token);
        $stmt->execute();

        echo "<script>alert('Senha Alterada com Sucesso');
        window.location.href = 'login.php';
        </script>";
    } else {
        echo "<script>alert('Token Inválido');
         window.location.href = 'index.php';
        </script>";
    }

    $stmt->close();
    $conn->close();
}
?>