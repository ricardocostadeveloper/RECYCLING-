<?php
include_once '../../conexao/db.php';

	$area = $_POST['area'];
	$turno = $_POST['turno'];
	$reincidente = $_POST['reincidente'];
	$produto = $_POST['produto_id'];

    $query = "UPDATE scrap SET
			area = '$area',
			turno = '$turno',
			reincidente = '$reincidente'
			produto = '$produto_id'
			WHERE id = $id
		";
$return_query = mysqli_query($conn, $query);


echo (json_encode($query));

