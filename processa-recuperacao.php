<?php
include 'conexao.php'; // Certifique-se de incluir a conexão com o banco
include 'enviar_email.php'; // Incluir o arquivo de envio de e-mail

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];

    // Verifica se o e-mail existe no banco
    $stmt = $conn->prepare("SELECT id_usuarios FROM tb_usuarios WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $usuario = $result->fetch_assoc();
        $token = bin2hex(random_bytes(50)); // Gera um token seguro
        $expira_em = date("Y-m-d H:i:s", strtotime("+1 hour"));

        // Salva o token no banco
        $stmt = $conn->prepare("UPDATE tb_usuarios SET token_recuperacao = ?, token_expira = ? WHERE email = ?");
        $stmt->bind_param("sss", $token, $expira_em, $email);
        $stmt->execute();

        // Enviar e-mail com o link de recuperação
        $link = "http://localhost/univesp-projeto-integrador-III-back-end/redefinir_senha.php?token=$token";
        $resultado = enviarEmail($email, $link); // Chama a função de envio de e-mail

        if ($resultado === true) {
            echo "<script>alert('Um e-mail foi enviado com as instruções para redefinir sua senha.');
            window.location.href = 'login.php';
            </script>";
        } else {
            echo $resultado; // Exibe o erro caso o envio tenha falhado
        }
    } else {
        echo "<script>alert('E-mail não encontrado');
            window.location.href = 'login.php';
            </script>";
     
    }
}
?>