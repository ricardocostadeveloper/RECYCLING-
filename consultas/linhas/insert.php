<?php

session_start();

include '../../conexao/db.php';

$linha = $_POST['linha'];

// Se o cliente não existir
$sql = "INSERT INTO linha (descricao) VALUES (?)";
$stmt = $conn -> prepare($sql);
$stmt -> bind_param('s', $linha);
if($stmt -> execute()) {
    echo json_encode(['success' => true, 'message' => 'Linha inserido com sucesso.']);
} else {
    echo json_encode(['error' => false, 'message' => 'Erro ao inserir linha.']);
}


?>
