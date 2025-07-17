<?php
    include_once '../../conexao/db.php';

    // Verifica se 'id' está presente e é um número válido
    if (isset($_REQUEST['id']) && is_numeric($_REQUEST['id'])) {
        $id = intval($_REQUEST['id']); // Garante que $id seja um número inteiro

        // Usa prepared statements para evitar SQL Injection
        $stmt = $conn->prepare("DELETE FROM clientes WHERE id = ?");
        $stmt->bind_param("i", $id); // "i" indica que é um inteiro

        if ($stmt->execute()) {
            // Sucesso na exclusão
            echo json_encode(['success' => true, 'message' => 'Cliente excluído com sucesso.']);
        } else {
            // Falha na execução da query
            echo json_encode(['success' => false, 'message' => 'Erro ao excluir cliente.']);
        }

        $stmt->close();
    } else {
        // ID inválido ou ausente
        echo json_encode(['success' => false, 'message' => 'ID inválido ou ausente.']);
    }

    $conn->close(); // Fecha a conexão com o banco de dados
?>
