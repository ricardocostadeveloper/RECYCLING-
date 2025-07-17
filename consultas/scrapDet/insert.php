<?php
session_start();
include '../../conexao/db.php';

header('Content-Type: application/json');

// Dados do POST
$scrap = $_POST['scrap'];
$partnumber = $_POST['partnumber'];
$falha = $_POST['falhas'];
$quantidade = $_POST['quantidade'];
$valor_t = $_POST['valor_t']; // Converte para número decimal
$observacao = $_POST['observacao'];
// Inserção de dados na tabela 'scrap'
$sql = "INSERT INTO scrap_pn (scrap_id, partnumber_id, falhas_id, quantidade, valor_t, observacao) VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
if ($stmt === false) {
    echo json_encode(['success' => false, 'message' => 'Erro na preparação da consulta.']);
    exit();
}

$stmt->bind_param('iiiids', $scrap, $partnumber, $falha, $quantidade, $valor_t, $observacao);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Dados inseridos com sucesso.']);
} else {
    echo json_encode(['success' => false, 'message' => 'Erro ao inserir dados.']);
}

$stmt->close();
$conn->close();

?>


