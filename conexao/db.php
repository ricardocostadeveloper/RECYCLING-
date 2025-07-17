<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "recycle";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => 'Conexão falhou: ' . $conn->connect_error]));
}
?>