<?php

// Incluir a conexao com o banco de dados
include_once '../../conexao/conexaoPDO.php';

// Receber os dados da requisição
$dados_requisicao = $_REQUEST;

// Lista de colunas da tabela
$colunas = [
    0 => 'id',
    1 => 'serial',
    2 => 'area',
    3 => 'reincidente',
    4 => 'produto_id'
];

// Obter a quantidade de registros no banco de dados
$query_qnt_scrap = "SELECT COUNT(id) AS qnt_scrap FROM scrap";

// Acessa o IF quando há parâmetros de pesquisa   
if(!empty($dados_requisicao['search']['value'])) {
    $query_scrap .= " WHERE serial LIKE :serial 
                     OR area LIKE :area
                     OR reincidente LIKE :reincidente
                     OR turno LIKE :turno
                     OR (SELECT produto.cimcode FROM produto WHERE produto.id = scrap.produto_id) LIKE :produto_id";
}

// Preparar a QUERY para contar os registros
$result_qnt_scrap = $conn->prepare($query_qnt_scrap);

// Acessa o IF quando há parâmetros de pesquisa   
if(!empty($dados_requisicao['search']['value'])) {
    $valor_pesq = "%" . $dados_requisicao['search']['value'] . "%";
    $result_qnt_scrap->bindParam(':serial', $valor_pesq, PDO::PARAM_STR);
    $result_qnt_scrap->bindParam(':area', $valor_pesq, PDO::PARAM_STR);
    $result_qnt_scrap->bindParam(':reincidente', $valor_pesq, PDO::PARAM_STR);
    $result_qnt_scrap->bindParam(':turno', $valor_pesq, PDO::PARAM_STR);
    $result_qnt_scrap->bindParam(':produto_id', $valor_pesq, PDO::PARAM_STR);
}

// Executar a QUERY para contar os registros
$result_qnt_scrap->execute();
$row_qnt_scrap = $result_qnt_scrap->fetch(PDO::FETCH_ASSOC);

// Recuperar os registros do banco de dados
$query_scrap = "SELECT id,
                        serial,
                        elt(area, 'SMD', 'FA') as area,
                        elt(reincidente, 'Sim', 'Não') as reincidente,
                        elt(turno, 'COMERCIAL', 'ESPECIAL') as turno,
                        (SELECT produto.cimcode FROM produto WHERE produto.id = scrap.produto_id) as produto_id
                FROM scrap";

// Acessa o IF quando há parâmetros de pesquisa
if(!empty($dados_requisicao['search']['value'])) {
    $query_scrap .= " WHERE serial LIKE :serial 
                      OR area LIKE :area
                      OR reincidente LIKE :reincidente
                      OR turno LIKE :turno
                      OR (SELECT produto.cimcode FROM produto WHERE produto.id = scrap.produto_id) LIKE :produto_id";
}

// Ordenar os registros
$query_scrap .= " ORDER BY " . $colunas[$dados_requisicao['order'][0]['column']] . " " . $dados_requisicao['order'][0]['dir'] . " LIMIT :inicio , :quantidade";

// Preparar a QUERY para buscar os registros
$result_scrap = $conn->prepare($query_scrap);
$result_scrap->bindParam(':inicio', $dados_requisicao['start'], PDO::PARAM_INT);
$result_scrap->bindParam(':quantidade', $dados_requisicao['length'], PDO::PARAM_INT);

// Acessa o IF quando há parâmetros de pesquisa   
if(!empty($dados_requisicao['search']['value'])) {
    $valor_pesq = "%" . $dados_requisicao['search']['value'] . "%";
    $result_scrap->bindParam(':serial', $valor_pesq, PDO::PARAM_STR);
    $result_scrap->bindParam(':area', $valor_pesq, PDO::PARAM_STR);
    $result_scrap->bindParam(':reincidente', $valor_pesq, PDO::PARAM_STR);
    $result_scrap->bindParam(':turno', $valor_pesq, PDO::PARAM_STR);
    $result_scrap->bindParam(':produto_id', $valor_pesq, PDO::PARAM_STR);
}

// Executar a QUERY
$result_scrap->execute();
$dados = [];



while ($row_scrap = $result_scrap->fetch(PDO::FETCH_ASSOC)) {
    // Adicionando os dados ao array associativo
    $dados[] = [
        'serial' => $row_scrap['serial'],
        'area' => $row_scrap['area'],
        'reincidente' => $row_scrap['reincidente'],
        'turno' => $row_scrap['turno'],
        'produto_id' => $row_scrap['produto_id'],
        'id' => $row_scrap['id']
    ];
}

// Criar o array de informações a serem retornadas para o Javascript
$resultado = [
    "draw" => intval($dados_requisicao['draw']), // Para cada requisição é enviado um número como parâmetro
    "recordsTotal" => intval($row_qnt_scrap['qnt_scrap']), // Quantidade de registros que há no banco de dados
    "recordsFiltered" => intval($row_qnt_scrap['qnt_scrap']), // Total de registros quando houver pesquisa
    "data" => $dados // Array de dados com os registros retornados da tabela scrap
];

// Retornar os dados em formato de objeto para o JavaScript
echo json_encode($resultado);

?>
