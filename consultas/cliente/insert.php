<?php

session_start();

include '../../conexao/db.php';

$cliente = $_POST['cliente'];

// Se o cliente não existir
$sql = "INSERT INTO clientes (descricao) VALUES (?)";
$stmt = $conn -> prepare($sql);
$stmt -> bind_param('s', $cliente);
if($stmt -> execute()) {
    echo json_encode(['success' => true, 'message' => 'Cliente inserido com sucesso.']);
} else {
    echo json_encode(['error' => false, 'message' => 'Erro ao inserir cliente.']);
}


?>
