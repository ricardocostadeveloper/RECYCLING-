<?php
include_once '../../conexao/db.php';
	$descricao_d = $_REQUEST['descricao_d'];
	$id = $_REQUEST['id'];

    $query = "UPDATE clientes SET
			descricao = '$descricao_d'
			WHERE id = $id
		";
$return_query = mysqli_query($conn, $query);


echo (json_encode($query));
