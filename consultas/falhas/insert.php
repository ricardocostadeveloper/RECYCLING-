<?php

session_start();

include '../../conexao/db.php';

$falha = $_POST['falha'];

// Se o cliente não existir
$sql = "INSERT INTO falhas (descricao) VALUES (?)";
$stmt = $conn -> prepare($sql);
$stmt -> bind_param('s', $falha);
if($stmt -> execute()) {
    echo json_encode(['success' => true, 'message' => 'Cliente inserido com sucesso.']);
} else {
    echo json_encode(['error' => false, 'message' => 'Erro ao inserir cliente.']);
}


?>
