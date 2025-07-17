<?php
include '../../conexao/conexaoPDO.php';

header('Content-Type: application/json');

$id = isset($_GET['id']) ? $_GET['id'] : null;

if ($id) {
    // Consulta SQL para obter os detalhes do scrap
    $sql = "SELECT 
        id,
        serial,
        elt(area, 'SMD', 'FA') as area,
        elt(reincidente, 'Sim', 'Não') as reincidente,
        elt(turno, 'COMERCIAL', 'ESPECIAL') as turno,
        (SELECT produto.cimcode FROM produto WHERE produto.id = scrap.produto_id) as produto,
        scrap.produto_id
     FROM scrap WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->execute(['id' => $id]);
    $scrap = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($scrap) {
        echo json_encode($scrap);
    } else {
        echo json_encode(['error' => 'Scrap não encontrado.']);
    }
} else {
    echo json_encode(['error' => 'ID do scrap não especificado.']);
}
