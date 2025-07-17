<?php
// Incluir o arquivo de conexão com o banco de dados
include_once '../../conexao/db.php';

// Verificar se a chave 'q' está definida e atribuir um valor padrão se não estiver
$searchTerm = isset($_GET['q']) ? '%' . $_GET['q'] . '%' : '%';
$id = isset($_GET['produto_id']) ? $_GET['produto_id'] : null;

// Consulta para obter dados do banco de dados
$sql = "SELECT produtos_partnumber.id,
                        partnumber.partnumber,
                        partnumber.valor_unit 
                    FROM produtos_partnumber
                    INNER JOIN produto ON produtos_partnumber.produto_id = produto.id
                    INNER JOIN partnumber ON produtos_partnumber.partnumber_id = partnumber.id
                    WHERE produtos_partnumber.produto_id = $id
                    AND partnumber LIKE ? ORDER BY partnumber";

$stmt = mysqli_prepare($conn, $sql);

if ($stmt) {
    mysqli_stmt_bind_param($stmt, "s", $searchTerm);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $id, $partnumber,$valor_unit);

    $data = array();

    while (mysqli_stmt_fetch($stmt)) {
        $data[] = array(
            'id' => $id,
            'title' => $partnumber, // Alteração: 'text' para 'title'
            'valor_unit' => $valor_unit, // Alteração: 'text' para 'title'
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