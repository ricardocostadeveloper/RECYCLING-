<?php

// Incluir a conexao com o banco de dados
include_once '../../conexao/conexaoPDO.php';

//Receber os dados da requisão
$dados_requisicao = $_REQUEST;

// Lista de colunas da tabela
$colunas = [
    0 => 'id',
    1 => 'descricao',
];

// Obter a quantidade de registros no banco de dados
$query_qnt_linha = "SELECT COUNT(id) AS qnt_linha FROM linha";

// Acessa o IF quando ha paramentros de pesquisa   
if(!empty($dados_requisicao['search']['value'])) {
    $query_qnt_linha .= " WHERE descricao LIKE :descricao ";
}

// Preparar a QUERY
$result_qnt_linha = $conn->prepare($query_qnt_linha);
// Acessa o IF quando ha paramentros de pesquisa   
if(!empty($dados_requisicao['search']['value'])) {
    $valor_pesq = "%" . $dados_requisicao['search']['value'] . "%";
    $result_qnt_linha->bindParam(':descricao', $valor_pesq, PDO::PARAM_STR);
}
// Executar a QUERY responsável em retornar a quantidade de registros no banco de dados
$result_qnt_linha->execute();
$row_qnt_linha = $result_qnt_linha->fetch(PDO::FETCH_ASSOC);
//var_dump($row_qnt_linha);

// Recuperar os registros do banco de dados
$query_linha = "SELECT id,
                        descricao
                    FROM linha ";

// Acessa o IF quando ha paramentros de pesquisa   
if(!empty($dados_requisicao['search']['value'])) {
    $query_linha .= " WHERE descricao LIKE :descricao ";
}

// Ordenar os registros
$query_linha .= " ORDER BY " . $colunas[$dados_requisicao['order'][0]['column']] . " " . $dados_requisicao['order'][0]['dir'] . " LIMIT :inicio , :quantidade";
// Preparar a QUERY
$result_linha = $conn->prepare($query_linha);
$result_linha->bindParam(':inicio', $dados_requisicao['start'], PDO::PARAM_INT);
$result_linha->bindParam(':quantidade', $dados_requisicao['length'], PDO::PARAM_INT);

// Acessa o IF quando ha paramentros de pesquisa   
if(!empty($dados_requisicao['search']['value'])) {
    $valor_pesq = "%" . $dados_requisicao['search']['value'] . "%";
    $result_linha->bindParam(':descricao', $valor_pesq, PDO::PARAM_STR);
}
// Executar a QUERY
$result_linha->execute();
$dados = [];

// Ler os registros retornado do banco de dados e atribuir no array 
while ($row_linha = $result_linha->fetch(PDO::FETCH_ASSOC)) {
    extract($row_linha);
    $registro = [];
    $registro[] = $descricao;
    $registro[] = $id;
    $dados[] = $registro;
}

//Cria o array de informações a serem retornadas para o Javascript
$resultado = [
    "draw" => intval($dados_requisicao['draw']), // Para cada requisição é enviado um número como parâmetro
    "recordsTotal" => intval($row_qnt_linha['qnt_linha']), // Quantidade de registros que há no banco de dados
    "recordsFiltered" => intval($row_qnt_linha['qnt_linha']), // Total de registros quando houver pesquisa
    "data" => $dados // Array de dados com os registros retornados da tabela usuario
];

// Retornar os dados em formato de objeto para o JavaScript
echo json_encode($resultado);
