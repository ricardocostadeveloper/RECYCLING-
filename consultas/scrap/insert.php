<?php
session_start();
include '../../conexao/db.php';

$usuario_id = $_SESSION['user']['id']; // Assumindo que o ID do usuário está na sessão

header('Content-Type: application/json');

// Dados do POST
$area = $_POST['area'];
$turno = $_POST['turno'];
$produto = $_POST['produto_id'];
$reincidente = $_POST['reincidente'];

// Inserção de dados na tabela 'scrap'
$sql = "INSERT INTO scrap (area, turno, produto_id, reincidente, usuario_id) VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
if ($stmt === false) {
    echo json_encode(['success' => false, 'message' => 'Erro na preparação da consulta.']);
    exit();
}

$stmt->bind_param('iiiii', $area, $turno, $produto, $reincidente, $usuario_id);

if ($stmt->execute()) {
    // Resgata o ID do último insert
    $last_id = $conn->insert_id;

    // Agora faz o UPDATE na tabela 'scrap'
    $serial = 'SC'.$last_id; // Defina o valor que você deseja para a coluna 'serial'
    $update_sql = "UPDATE scrap SET serial = ? WHERE id = ?";
    $update_stmt = $conn->prepare($update_sql);
    if ($update_stmt === false) {
        echo json_encode(['success' => false, 'message' => 'Erro na preparação da consulta de update.']);
        exit();
    }

    $update_stmt->bind_param('si', $serial, $last_id);

    if ($update_stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Dados inseridos e serial atualizado com sucesso.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Erro ao atualizar o serial: ' . $update_stmt->error]);
    }

    $update_stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Erro ao inserir dados: ' . $stmt->error]);
}

$stmt->close();
$conn->close();
?>
