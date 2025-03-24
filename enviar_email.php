<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


require 'vendor/autoload.php'; // Se instalou com Composer

function enviarEmail($destinatario, $link) {
    $mail = new PHPMailer(true);

    try {
        // Configuração do servidor SMTP para Gmail
        $mail->isSMTP();
        $mail->CharSet = "utf-8";
        $mail->Host       = 'smtp.gmail.com'; // Servidor do Gmail
        $mail->SMTPAuth   = true;
        $mail->Username   = ''; // Seu e-mail do Gmail
        $mail->Password   = ''; // aqui é a senha do app, que precisar criar no google
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );

        // Remetente e destinatário
        $mail->setFrom('', 'Conecta'); // Seu e-mail e nome
        $mail->addAddress($destinatario); // O destinatário agora é o usuário que solicitou a recuperação

        // Conteúdo do e-mail
        $mail->isHTML(true);
        $mail->Subject = 'Redefinição de Senha';
        $mail->Body    = "Clique no link para redefinir sua senha: <a href='$link'>Redefinir Senha</a>";

        // Enviar
        $mail->send();
        return true; // E-mail enviado com sucesso
    } catch (Exception $e) {
        return "Erro ao enviar e-mail: {$mail->ErrorInfo}";
    }
}
?>