<?php
	include_once '../../conexao/conexaoPDO.php';

    $id = $_REQUEST['id'];

	$sql = "SELECT id,
                    fase,
                    partnumber,
                    valor_unit
            FROM partnumber 
            WHERE id  = '$id'";

   $result_qnt_material = $conn->prepare($sql);
   $result_qnt_material->execute();
   $row_qnt_material = $result_qnt_material->fetch(PDO::FETCH_ASSOC);
   // var_dump($row_qnt_material);

   echo json_encode($row_qnt_material);

?>