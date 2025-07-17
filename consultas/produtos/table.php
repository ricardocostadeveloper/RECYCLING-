<?php

// Incluir a conexao com o banco de dados
include_once '../../conexao/conexaoPDO.php';

// Receber os dados da requisição
$dados_requisicao = $_REQUEST;

// Lista de colunas da tabela
$colunas = [
    0 => 'id',
    1 => 'cimcode',
    2 => 'linha',
    3 => 'cliente'
];

// Obter a quantidade de registros no banco de dados
$query_qnt_produto = "SELECT COUNT(id) AS qnt_produto FROM produto";

// Acessa o IF quando há parâmetros de pesquisa   
if(!empty($dados_requisicao['search']['value'])) {
    $query_qnt_produto .= " WHERE cimcode LIKE :cimcode ";
    $query_qnt_produto .= "OR (select linha.descricao from linha where linha.id = produto.linha_id ) LIKE :linha ";
    $query_qnt_produto .= "OR (select clientes.descricao from clientes where clientes.id = produto.cliente_id ) LIKE :cliente ";
}

// Preparar a QUERY
$result_qnt_produto = $conn->prepare($query_qnt_produto);

// Acessa o IF quando há parâmetros de pesquisa   
if(!empty($dados_requisicao['search']['value'])) {
    $valor_pesq = "%" . $dados_requisicao['search']['value'] . "%";
    $result_qnt_produto->bindParam(':cimcode', $valor_pesq, PDO::PARAM_STR);
    $result_qnt_produto->bindParam(':linha', $valor_pesq, PDO::PARAM_STR);
    $result_qnt_produto->bindParam(':cliente', $valor_pesq, PDO::PARAM_STR);
}

// Executar a QUERY responsável em retornar a quantidade de registros no banco de dados
$result_qnt_produto->execute();
$row_qnt_produto = $result_qnt_produto->fetch(PDO::FETCH_ASSOC);

// Recuperar os registros do banco de dados
$query_produto = "SELECT id,
                    cimcode,
                    (select linha.descricao from linha where linha.id = produto.linha_id )linha,
                    (select clientes.descricao from clientes where clientes.id = produto.cliente_id )cliente
                FROM produto";

// Acessa o IF quando há parâmetros de pesquisa
if(!empty($dados_requisicao['search']['value'])) {
    $query_produto .= " WHERE cimcode LIKE :cimcode ";
    $query_produto .= "OR (select linha.descricao from linha where linha.id = produto.linha_id ) LIKE :linha ";
    $query_produto .= "OR (select clientes.descricao from clientes where clientes.id = produto.cliente_id ) LIKE :cliente ";
}

// Ordenar os registros
$query_produto .= " ORDER BY " . $colunas[$dados_requisicao['order'][0]['column']] . " " . $dados_requisicao['order'][0]['dir'] . " LIMIT :inicio , :quantidade";

// Preparar a QUERY
$result_produto = $conn->prepare($query_produto);
$result_produto->bindParam(':inicio', $dados_requisicao['start'], PDO::PARAM_INT);
$result_produto->bindParam(':quantidade', $dados_requisicao['length'], PDO::PARAM_INT);

// Acessa o IF quando há parâmetros de pesquisa   
if(!empty($dados_requisicao['search']['value'])) {
    $valor_pesq = "%" . $dados_requisicao['search']['value'] . "%";
    $result_produto->bindParam(':cimcode', $valor_pesq, PDO::PARAM_STR);
    $result_produto->bindParam(':linha', $valor_pesq, PDO::PARAM_STR);
    $result_produto->bindParam(':cliente', $valor_pesq, PDO::PARAM_STR);
}

// Executar a QUERY
$result_produto->execute();
$dados = [];

// Ler os registros retornados do banco de dados e atribuir no array 
while ($row_produto = $result_produto->fetch(PDO::FETCH_ASSOC)) {
    extract($row_produto);
    $registro = [];
    $registro[] = $cimcode;
    $registro[] = $linha;
    $registro[] = $cliente;
    $registro[] = $id;
    $dados[] = $registro;
}

// Cria o array de informações a serem retornadas para o Javascript
$resultado = [
    "draw" => intval($dados_requisicao['draw']), // Para cada requisição é enviado um número como parâmetro
    "recordsTotal" => intval($row_qnt_produto['qnt_produto']), // Quantidade de registros que há no banco de dados
    "recordsFiltered" => intval($row_qnt_produto['qnt_produto']), // Total de registros quando houver pesquisa
    "data" => $dados // Array de dados com os registros retornados da tabela usuario
];

// Retornar os dados em formato de objeto para o JavaScript
echo json_encode($resultado);
?>
