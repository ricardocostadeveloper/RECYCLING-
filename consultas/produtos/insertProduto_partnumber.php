<?php
session_start();
include '../../conexao/db.php';


header('Content-Type: application/json'); // Define o cabeçalho para JSON

// Corrigindo o nome do campo para 'produto'
$produto = $_POST['produto_id'];
$partnumber = $_POST['partnumber_id'];


$sql = "INSERT INTO produtos_partnumber (produto_id, partnumber_id) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param('ii', $produto, $partnumber);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Dados inseridos com sucesso.']);
} else {
    echo json_encode(['success' => false, 'message' => 'Erro ao inserir dados.']);
}

?>
