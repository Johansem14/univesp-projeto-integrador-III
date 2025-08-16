<?php
include("../conexao.php");

$url = "localhost/univesp-projeto-integrador-III/";
$sql_produtos = "SELECT * FROM categoria_interesse_vw";
$result = $conn->query($sql_produtos);

$data = [];

if($result && $result->num_rows > 0){
    while($row = $result->fetch_assoc()){
        $data[] =[ 
            'categoria' => $row['categoria_interesse'],
            'total' => $row['total'],
        ];
        
    }
}
header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, OPTIONS");

echo json_encode($data);
