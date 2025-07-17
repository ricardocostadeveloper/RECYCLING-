<?php
session_start();
include '../../conexao/db.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user']['id'])) {
    echo json_encode(['success' => false, 'message' => 'Usuário não autenticado.']);
    exit;
}

$usuario_id = $_SESSION['user']['id'];

// Recebe os dados do POST
$titulo = $_POST['titulo'] ?? '';
$tipo_residuo = $_POST['tipo_residuo'] ?? '';
$localizacao = $_POST['localizacao'] ?? '';
$quantidade = $_POST['quantidade'] ?? '';
$unidade = $_POST['unidade'] ?? '';
$preco_unidade = $_POST['preco_unidade'] ?? null;
$descricao = $_POST['descricao'] ?? '';

if (!$titulo || !$tipo_residuo || !$localizacao || !$quantidade || !$unidade) {
    echo json_encode(['success' => false, 'message' => 'Preencha todos os campos obrigatórios.']);
    exit;
}

$sql = "INSERT INTO residuos (titulo, tipo_residuo, localizacao, quantidade, unidade, preco_unidade, descricao, usuario_id, created_at)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())";
$stmt = $conn->prepare($sql);
$stmt->bind_param(
    "sssssdsi",
    $titulo,
    $tipo_residuo,
    $localizacao,
    $quantidade,
    $unidade,
    $preco_unidade,
    $descricao,
    $usuario_id
);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Anúncio publicado com sucesso!']);
} else {
    echo json_encode(['success' => false, 'message' => 'Erro ao publicar anúncio: ' . $conn->error]);
}