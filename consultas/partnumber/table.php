<?php

// Incluir a conexao com o banco de dados
include_once '../../conexao/conexaoPDO.php';

// Receber os dados da requisição
$dados_requisicao = $_REQUEST;

// Lista de colunas da tabela
$colunas = [
    0 => 'id',
    1 => 'partnumber',
    2 => 'valor_unit',
    3 => 'descricao'
];

// Obter a quantidade de registros no banco de dados
$query_qnt_partnumber = "SELECT COUNT(id) AS qnt_partnumber FROM partnumber";

// Acessa o IF quando há parâmetros de pesquisa   
if (!empty($dados_requisicao['search']['value'])) {
    $query_qnt_partnumber .= " WHERE partnumber LIKE :partnumber ";
    $query_qnt_partnumber .= " OR valor_unit LIKE :valor_unit ";
    $query_qnt_partnumber .= " OR descricao LIKE :descricao ";
}

// Preparar a QUERY
$result_qnt_partnumber = $conn->prepare($query_qnt_partnumber);

// Acessa o IF quando há parâmetros de pesquisa   
if (!empty($dados_requisicao['search']['value'])) {
    $valor_pesq = "%" . $dados_requisicao['search']['value'] . "%";
    $result_qnt_partnumber->bindParam(':partnumber', $valor_pesq, PDO::PARAM_STR);
    $result_qnt_partnumber->bindParam(':valor_unit', $valor_pesq, PDO::PARAM_STR);
    $result_qnt_partnumber->bindParam(':descricao', $valor_pesq, PDO::PARAM_STR);
}

// Executar a QUERY responsável em retornar a quantidade de registros no banco de dados
$result_qnt_partnumber->execute();
$row_qnt_partnumber = $result_qnt_partnumber->fetch(PDO::FETCH_ASSOC);

// Recuperar os registros do banco de dados
$query_partnumber = "SELECT id,
                        partnumber,
                        valor_unit,
                        descricao
                    FROM partnumber";

// Acessa o IF quando há parâmetros de pesquisa   
if (!empty($dados_requisicao['search']['value'])) {
    $query_partnumber .= " WHERE partnumber LIKE :partnumber ";
    $query_partnumber .= " OR valor_unit LIKE :valor_unit ";
    $query_partnumber .= " OR descricao LIKE :descricao ";
}

// Ordenar os registros
$query_partnumber .= " ORDER BY " . $colunas[$dados_requisicao['order'][0]['column']] . " " . $dados_requisicao['order'][0]['dir'] . " LIMIT :inicio , :quantidade";

// Preparar a QUERY
$result_partnumber = $conn->prepare($query_partnumber);
$result_partnumber->bindParam(':inicio', $dados_requisicao['start'], PDO::PARAM_INT);
$result_partnumber->bindParam(':quantidade', $dados_requisicao['length'], PDO::PARAM_INT);

// Acessa o IF quando há parâmetros de pesquisa   
if (!empty($dados_requisicao['search']['value'])) {
    $valor_pesq = "%" . $dados_requisicao['search']['value'] . "%";
    $result_partnumber->bindParam(':partnumber', $valor_pesq, PDO::PARAM_STR);  // Remover espaço extra
    $result_partnumber->bindParam(':valor_unit', $valor_pesq, PDO::PARAM_STR);   // Remover espaço extra
    $result_partnumber->bindParam(':descricao', $valor_pesq, PDO::PARAM_STR);    // Remover espaço extra
}

// Executar a QUERY
$result_partnumber->execute();
$dados = [];

// Ler os registros retornados do banco de dados e atribuir no array 
while ($row_partnumber = $result_partnumber->fetch(PDO::FETCH_ASSOC)) {
    extract($row_partnumber);
    $registro = [];
    $registro[] = $partnumber;
    $registro[] = $valor_unit;
    $registro[] = $descricao;
    $registro[] = $id;
    $dados[] = $registro;
}

// Criar o array de informações a serem retornadas para o JavaScript
$resultado = [
    "draw" => intval($dados_requisicao['draw']), // Para cada requisição é enviado um número como parâmetro
    "recordsTotal" => intval($row_qnt_partnumber['qnt_partnumber']), // Quantidade de registros que há no banco de dados
    "recordsFiltered" => intval($row_qnt_partnumber['qnt_partnumber']), // Total de registros quando houver pesquisa
    "data" => $dados // Array de dados com os registros retornados da tabela
];

// Retornar os dados em formato de objeto para o JavaScript
echo json_encode($resultado);
?>
