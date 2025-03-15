<?php
include("conexao.php");
session_start();

if(!isset($_SESSION['usuario_id'])){
    echo "<script>alert('Usuário não está logado.'); window.location.href = 'home.php';</script>";
    exit;
}

$usuario_id = $_SESSION['usuario_id'];

if(!isset($_GET['id'])){
    echo "<script>alert('Produto não especificado.'); window.location.href = 'area-interesses.php';</script>";
    exit;
}else {
    $id = intval($_GET['id']);

    $sqlcheck = "SELECT * FROM tb_area_interesse WHERE id = '$id'";
    $result_check = $conn->query($sqlcheck);
    
    if($result_check->num_rows > 0){
        $sql = "DELETE FROM tb_area_interesse WHERE id = '$id'";
        $result = $conn->query($sql);

        if($result === TRUE){
            echo "<script>alert('Produto deletado com Sucesso.'); window.location.href = 'area-interesses.php';</script>";
        }else{
            echo "<script>alert('Erro ao deletar produto.'); window.location.href = 'area-interesses.php';</script>";
        }
    }else{
        echo "<script>alert('Produto não encontrado.'); window.location.href = 'area-interesses.php';</script>";
    }
    }

?>