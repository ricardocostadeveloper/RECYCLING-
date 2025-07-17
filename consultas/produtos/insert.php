<?php
session_start();
include '../../conexao/db.php';

$usuario_id =$_SESSION['user']['id']; // Assumindo que você armazenou o ID do usuário na sessão


header('Content-Type: application/json'); // Define o cabeçalho para JSON

// Corrigindo o nome do campo para 'cimcode'
$cimcode = $_POST['cimcode'];
$linha = $_POST['linha_id'];
$cliente = $_POST['cliente_id'];

$sql = "INSERT INTO produto (cimcode, linha_id, cliente_id, usuario_id) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param('sssi', $cimcode, $linha, $cliente, $usuario_id);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Dados inseridos com sucesso.']);
} else {
    echo json_encode(['success' => false, 'message' => 'Erro ao inserir dados.']);
}

?>
