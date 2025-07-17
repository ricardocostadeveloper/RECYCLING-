<?php

// Incluir a conexao com o banco de dados
include_once '../../conexao/conexaoPDO.php';

// Receber os dados da requisição
$dados_requisicao = $_REQUEST;
// $scrap_id = $_REQUEST['scrap_id'];


// Lista de colunas da tabela
$colunas = [
    0 => 'id',
    1 => 'partnumber_id',
    2 => 'falhas_id',
    3 => 'quantidade',
    4 => 'valor_t',
    5 => 'observacao'
];

// Obter a quantidade de registros no banco de dados
$query_qnt_scrap_pn = "SELECT COUNT(scrap_pn.id) AS qnt_scrap_pn
                            FROM scrap_pn
                            INNER JOIN partnumber ON scrap_pn.partnumber_id = partnumber.id
                            INNER JOIN falhas ON scrap_pn.falhas_id = falhas.id
                            WHERE scrap_pn.scrap_id = 6 ";

// Acessa o IF quando há parâmetros de pesquisa   
if(!empty($dados_requisicao['search']['value'])) {
    $query_scrap_pn .= " OR (SELECT partnumber.partnumber FROM partnumber WHERE partnumber.id = scrap_pn.partnumber_id) LIKE :partnumber_id
                     OR (SELECT falhas.descricao FROM falhas WHERE falhas.id = scrap_pn.falhas_id) LIKE :falhas_id
                     OR quantidade LIKE :quantidade
                     OR valor_t LIKE :valor_t
                     OR observacao LIKE : observacao";
}

// Preparar a QUERY para contar os registros
$result_qnt_scrap_pn = $conn->prepare($query_qnt_scrap_pn);

// Acessa o IF quando há parâmetros de pesquisa   
if(!empty($dados_requisicao['search']['value'])) {
    $valor_pesq = "%" . $dados_requisicao['search']['value'] . "%";
    $result_scrap_pn->bindParam(':partnumber_id', $valor_pesq, PDO::PARAM_STR);
    $result_scrap_pn->bindParam(':falhas_id', $valor_pesq, PDO::PARAM_STR);
    $result_scrap_pn->bindParam(':quantidade', $valor_pesq, PDO::PARAM_STR);
    $result_scrap_pn->bindParam(':valor_t', $valor_pesq, PDO::PARAM_STR);
    $result_scrap_pn->bindParam(':observacao', $valor_pesq, PDO::PARAM_STR);
}

// Executar a QUERY para contar os registros
$result_qnt_scrap_pn->execute();
$row_qnt_scrap_pn = $result_qnt_scrap_pn->fetch(PDO::FETCH_ASSOC);

// Recuperar os registros do banco de dados
$query_scrap_pn = "SELECT id,
                        (SELECT partnumber.partnumber FROM partnumber WHERE partnumber.id = scrap_pn.partnumber_id) as partnumber_id,
                        (SELECT falhas.descricao FROM falhas WHERE falhas.id = scrap_pn.falhas_id) as falhas_id,
                        quantidade,
                        valor_t,
                        observacao
                FROM scrap_pn ";

// Acessa o IF quando há parâmetros de pesquisa
if(!empty($dados_requisicao['search']['value'])) {
    $query_scrap_pn .= " WHERE (SELECT partnumber.partnumber FROM partnumber WHERE partnumber.id = scrap_pn.partnumber_id) LIKE :partnumber_id
                     OR (SELECT falhas.descricao FROM falhas WHERE falhas.id = scrap_pn.falhas_id) LIKE :falhas_id
                     OR quantidade LIKE :quantidade
                     OR valor_t LIKE :valor_t
                     OR observacao LIKE : observacao";
}

// Ordenar os registros
$query_scrap_pn .= " ORDER BY " . $colunas[$dados_requisicao['order'][0]['column']] . " " . $dados_requisicao['order'][0]['dir'] . " LIMIT :inicio , :quantidade";

// Preparar a QUERY para buscar os registros
$result_scrap_pn = $conn->prepare($query_scrap_pn);
$result_scrap_pn->bindParam(':inicio', $dados_requisicao['start'], PDO::PARAM_INT);
$result_scrap_pn->bindParam(':quantidade', $dados_requisicao['length'], PDO::PARAM_INT);

// Acessa o IF quando há parâmetros de pesquisa   
if(!empty($dados_requisicao['search']['value'])) {
    $valor_pesq = "%" . $dados_requisicao['search']['value'] . "%";
    $result_scrap_pn->bindParam(':partnumber_id', $valor_pesq, PDO::PARAM_STR);
    $result_scrap_pn->bindParam(':falhas_id', $valor_pesq, PDO::PARAM_STR);
    $result_scrap_pn->bindParam(':quantidade', $valor_pesq, PDO::PARAM_STR);
    $result_scrap_pn->bindParam(':valor_t', $valor_pesq, PDO::PARAM_STR);
    $result_scrap_pn->bindParam(':observacao', $valor_pesq, PDO::PARAM_STR);
}

// Executar a QUERY
$result_scrap_pn->execute();
$dados = [];

// Ler os registros retornados do banco de dados e atribuir no array 
while ($row_scrap_pn = $result_scrap_pn->fetch(PDO::FETCH_ASSOC)) {
    // Adicionando os dados ao array associativo
    $dados[] = [
        'partnumber_id' => $row_scrap_pn['partnumber_id'],
        'falhas_id' => $row_scrap_pn['falhas_id'],
        'quantidade' => $row_scrap_pn['quantidade'],
        'valor_t' => $row_scrap_pn['valor_t'],
        'observacao' => $row_scrap_pn['observacao'],
        'id' => $row_scrap_pn['id']
    ];
}


// Criar o array de informações a serem retornadas para o Javascript
$resultado = [
    "draw" => intval($dados_requisicao['draw']), // Para cada requisição é enviado um número como parâmetro
    "recordsTotal" => intval($row_qnt_scrap_pn['qnt_scrap_pn']), // Quantidade de registros que há no banco de dados
    "recordsFiltered" => intval($row_qnt_scrap_pn['qnt_scrap_pn']), // Total de registros quando houver pesquisa
    "data" => $dados // Array de dados com os registros retornados da tabela scrap
];

// Retornar os dados em formato de objeto para o JavaScript
echo json_encode($resultado);

?>
