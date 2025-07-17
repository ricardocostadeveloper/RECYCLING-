<?php

// Incluir a conexao com o banco de dados
include_once '../../conexao/conexaoPDO.php';

// Receber os dados da requisição
$dados_requisicao = $_REQUEST;
$produto_id = $_REQUEST['produto_id'];
// Lista de colunas da tabela
$colunas = [
    0 => 'produtos_partnumber.id',
    1 => 'partnumber',
];

// Obter a quantidade de registros no banco de dados
$query_qnt_partnumber = "SELECT COUNT(produtos_partnumber.id) AS qnt_produtoPartnumber
                            FROM produtos_partnumber
                            INNER JOIN produto ON produtos_partnumber.produto_id = produto.id
                            INNER JOIN partnumber ON produtos_partnumber.partnumber_id = partnumber.id
                            WHERE produtos_partnumber.produto_id = $produto_id ";

// Acessa o IF quando há parâmetros de pesquisa   
if(!empty($dados_requisicao['search']['value'])) {
    $query_qnt_partnumber .= "AND partnumber.partnumber LIKE :partnumber ";
}

// Preparar a QUERY
$result_qnt_produtoPartnumber = $conn->prepare($query_qnt_partnumber);

// Acessa o IF quando há parâmetros de pesquisa   
if(!empty($dados_requisicao['search']['value'])) {
    $valor_pesq = "%" . $dados_requisicao['search']['value'] . "%";
    $result_qnt_produtoPartnumber->bindParam(':partnumber', $valor_pesq, PDO::PARAM_STR);
}

// Executar a QUERY responsável em retornar a quantidade de registros no banco de dados
$result_qnt_produtoPartnumber->execute();
$row_qnt_produtoPartnumber = $result_qnt_produtoPartnumber->fetch(PDO::FETCH_ASSOC);

// Recuperar os registros do banco de dados
$query_produto = "SELECT produtos_partnumber.id,
                        partnumber.partnumber 
                    FROM produtos_partnumber
                    INNER JOIN produto ON produtos_partnumber.produto_id = produto.id
                    INNER JOIN partnumber ON produtos_partnumber.partnumber_id = partnumber.id
                    WHERE produtos_partnumber.produto_id = $produto_id";
 

// Acessa o IF quando há parâmetros de pesquisa
if(!empty($dados_requisicao['search']['value'])) {
    $query_qnt_partnumber .= " AND partnumber.partnumber LIKE :partnumber ";
}

// Ordenar os registros
$query_produto .= " ORDER BY " . $colunas[$dados_requisicao['order'][0]['column']] . " " . $dados_requisicao['order'][0]['dir'] . " LIMIT :inicio , :quantidade";

// Preparar a QUERY
$result_partnumber = $conn->prepare($query_produto);
$result_partnumber->bindParam(':inicio', $dados_requisicao['start'], PDO::PARAM_INT);
$result_partnumber->bindParam(':quantidade', $dados_requisicao['length'], PDO::PARAM_INT);

// Acessa o IF quando há parâmetros de pesquisa   
if(!empty($dados_requisicao['search']['value'])) {
    $valor_pesq = "%" . $dados_requisicao['search']['value'] . "%";
    $result_partnumber->bindParam(':partnumber', $valor_pesq, PDO::PARAM_STR);
}

// Executar a QUERY
$result_partnumber->execute();
$dados = [];

// Ler os registros retornados do banco de dados e atribuir no array 
// Ler os registros retornados do banco de dados e atribuir no array 
while ($row_produto = $result_partnumber->fetch(PDO::FETCH_ASSOC)) {
    // Adicionando os dados ao array associativo
    $dados[] = [
        'partnumber' => $row_produto['partnumber'],
        'id' => $row_produto['id']
    ];
}


// Cria o array de informações a serem retornadas para o Javascript
$resultado = [
    "draw" => intval($dados_requisicao['draw']), // Para cada requisição é enviado um número como parâmetro
    "recordsTotal" => intval($row_qnt_produtoPartnumber['qnt_produtoPartnumber']), // Quantidade de registros que há no banco de dados
    "recordsFiltered" => intval($row_qnt_produtoPartnumber['qnt_produtoPartnumber']), // Total de registros quando houver pesquisa
    "data" => $dados // Array de dados com os registros retornados da tabela usuario
];

// Retornar os dados em formato de objeto para o JavaScript
echo json_encode($resultado);
?>
