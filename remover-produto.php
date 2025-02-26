<?php
include("conexao.php");
session_start();

// Habilita exibição de erros (somente para desenvolvimento)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    echo "<script>alert('Usuário não está logado.'); window.location.href = 'login.php';</script>";
    exit;
}

// Verifica se o ID do produto foi passado pela URL
if (!isset($_GET['id'])) {
    echo "<script>alert('Produto não especificado.'); window.location.href = 'meus-produtos.php';</script>";
    exit;
}

// Recupera o ID do produto e valida
$id_produto = intval($_GET['id']);
if ($id_produto <= 0) {
    echo "<script>alert('ID do produto inválido.'); window.location.href = 'meus-produtos.php';</script>";
    exit;
}

// Verifica a conexão
if (!$conn) {
    die("Conexão falhou: " . mysqli_connect_error());
}

// 1. Remove os endereços associados ao produto
$sql_endereco = "DELETE FROM tb_enderecos WHERE tb_produtos_id_produtos = $id_produto";

if (!mysqli_query($conn, $sql_endereco)) {
    echo "<script>alert('Erro ao remover endereços: " . mysqli_error($conn) . "'); window.location.href = 'meus-produtos.php';</script>";
    exit;
}

// 2. Remove o produto
$sql_produto = "DELETE FROM tb_produtos WHERE id_produtos = $id_produto";

if (mysqli_query($conn, $sql_produto)) {
    // Produto removido com sucesso
    echo "<script>alert('Produto removido com sucesso.'); window.location.href = 'meus-produtos.php';</script>";
} else {
    // Erro ao remover o produto
    echo "<script>alert('Erro ao remover o produto: " . mysqli_error($conn) . "'); window.location.href = 'teste.php';</script>";
}

// Fecha a conexão
mysqli_close($conn);
?>
