<?php
include("../conexao.php");

$sql_produtos = "SELECT * FROM categoria_mais_cadastrada_vw";
$result = $conn->query($sql_produtos);

$data = [];

if($result && $result->num_rows > 0){
    while($row = $result->fetch_assoc()){
        $data[] =[ 
            'categoria' => $row['categoria'],
            'quantidade' => $row['QTD'],
            'ultima_url' => $row['ULTIMA_URL'],
        ];
        
    }
}
header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, OPTIONS");

echo json_encode($data);
