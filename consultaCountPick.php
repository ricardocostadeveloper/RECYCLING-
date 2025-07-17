<?php
include '../conexao/db.php';
  $linha = $_REQUEST['linha'];
  $sql = "SELECT count(*)count FROM picklist WHERE linha = '$linha' AND status =  2";

  // Consultar novas ordens de serviço desde a última verificação
  $qryLista = mysqli_query($conn, $sql);   
  $resultado = mysqli_fetch_assoc($qryLista);
        // $vetor= $resultado; 
  // Atualizar a última data e hora de verificação
  $count = $resultado['count'];

  header('Content-Type: application/json');
  echo json_encode($count);

// $conn->close();
?>