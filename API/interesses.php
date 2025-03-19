<?php
include("../conexao.php");

$sql_interesses = "SELECT * FROM area_interesse_vw";
$result = $conn->query($sql_interesses);

$data = [];

if ($result && $result->num_rows > 0){
    while($row = $result->fetch_assoc()){
        $data[] = [
            'nome_anunciante' => $row['nome_anunciante'],
            'telefone_anunciante' => $row['telefone_anunciante'],
            'produto' => $row['produto'],
            'oferta' => $row['oferta'],
            'valor' => $row['valor'],
            'descricao' => $row['descricao'],
            'nome_produto' => $row['nome_produto'],
            'email_anunciante' => $row['email_anunciante'],
            'nome_interessado' => $row['nome_interessado'],
            'email_interessado' => $row['email_interessado'],
            'categoria_interesse' => $row['categoria_interesse'],
            'data_interesse' => $row['data_interesse'],
        ];
    }
    
}

echo json_encode($data);
header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, OPTIONS");



?>