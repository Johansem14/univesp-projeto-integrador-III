<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "bdacessibilidade";

// Cria conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");
date_default_timezone_set('America/Sao_Paulo');