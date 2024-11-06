<?php
include_once('config.php');

if (!empty($_GET['id_produto'])) {
    $id_produto = mysqli_real_escape_string($conexao, $_GET['id_produto']);

    // Prepare the SELECT query
    $sqlSelect = "SELECT * FROM produto WHERE id_produto=?";
    $stmtSelect = $conexao->prepare($sqlSelect);
    $stmtSelect->bind_param("s", $id_produto);

    // Execute the SELECT query
    if ($stmtSelect->execute()) {
        $result = $stmtSelect->get_result();

        if ($result->num_rows > 0) {
            // Prepare the DELETE query
            $sqlDelete = "DELETE FROM produto WHERE id_produto=?";
            $stmtDelete = $conexao->prepare($sqlDelete);
            $stmtDelete->bind_param("s", $id_produto);

            // Execute the DELETE query
            if ($stmtDelete->execute()) {
                echo "Produto deletado com sucesso!";
            } else {
                echo "Erro ao deletar produto: " . $stmtDelete->error;
            }
        } else {
            echo "Produto não encontrado.";
        }
    } else {
        echo "Erro ao executar a consulta SELECT: " . $stmtSelect->error;
    }

    // Close statements
    $stmtSelect->close();
    $stmtDelete->close();
}

header('Location: modprod1.php');