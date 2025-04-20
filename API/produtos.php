<?php
include("../conexao.php");

$url = "localhost/univesp-projeto-integrador-III/";
$sql_produtos = "SELECT * FROM produtos_view";
$result = $conn->query($sql_produtos);

$data = [];

if($result && $result->num_rows > 0){
    while($row = $result->fetch_assoc()){
        $data[] =[ 
            'id' => $row['id_produtos'],
            'nome_anunciante' => $row['nome_anunciante'],
            'telefone' => $row['telefone'],
            'produto' => $row['produto'],
            'categoria' => $row['categoria'],
            'oferta' => $row['oferta'],
            'valor' => $row['valor'],
            'descricao' => $row['descricao'],
            'nome_arquivo' => $row['nome_arquivo'],
            'path' =>  $url . $row['path'],
            'data_registro' => $row['data_upload'],

        ];
        
    }
}
header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, OPTIONS");

echo json_encode($data);
