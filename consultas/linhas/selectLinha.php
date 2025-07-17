<?php
// Incluir o arquivo de conexão com o banco de dados
include_once '../../conexao/db.php';

// Verificar se a chave 'q' está definida e atribuir um valor padrão se não estiver
$searchTerm = isset($_GET['q']) ? '%' . $_GET['q'] . '%' : '%';

// Consulta para obter dados do banco de dados
$sql = "SELECT id, descricao FROM linha WHERE descricao LIKE ? ORDER BY descricao";
$stmt = mysqli_prepare($conn, $sql);

if ($stmt) {
    mysqli_stmt_bind_param($stmt, "s", $searchTerm);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $id, $descricao);

    $data = array();

    while (mysqli_stmt_fetch($stmt)) {
        $data[] = array(
            'id' => $id,
            'title' => $descricao, // Alteração: 'text' para 'title'
            // 'url' => '#' // Pode adicionar uma URL se necessário
        );
    }

    // Criar um array com a chave 'options' para manter a consistência com o código JavaScript
    $resultArray = array('options' => $data);

    echo json_encode($resultArray);

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
?>