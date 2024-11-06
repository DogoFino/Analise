<?php
session_start();

if (empty($_SESSION['cpf'])) {
    header("location: login.php");
    exit();
}

// Inclui o arquivo de configuração para conexão com o banco de dados
include 'config.php'; // Certifique-se de que este arquivo contém a configuração da conexão

// Verifica se o usuário está logado e pega o CPF
$logado = isset($_SESSION['cpf']);
$cpf = $logado ? $_SESSION['cpf'] : null;

if ($cpf) {
    // Prepara a consulta SQL
    $stmt = $conexao->prepare("SELECT * FROM usuario WHERE cpf = ?");
    $stmt->bind_param("s", $cpf); // 's' indica que o parâmetro é uma string

    // Executa a consulta
    if ($stmt->execute()) {
        $result = $stmt->get_result();

        // Verifica se algum usuário foi encontrado
        if ($result->num_rows > 0) {
            $usuario = $result->fetch_assoc(); // Obtém os dados do usuário
        } else {
            echo "Nenhum usuário encontrado com esse CPF.";
        }
    } else {
        echo "Erro ao executar a consulta: " . $stmt->error;
    }
    $stmt->close(); // Fecha o statement
} else {
    echo "Usuário não está logado.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="adm.css">
    <title>Document</title>
</head>
<body>
    <div class="cabecalho">
        <section class="embaixo-cabe" id="baixo">
            <?php if ($usuario): ?>
                <h1>Bem-vindo, <?= htmlspecialchars($usuario['nome']); ?></h1> <!-- Supondo que você tenha um campo 'nome' -->
            <?php else: ?>
                <h1>Usuário não encontrado.</h1>
            <?php endif; ?>
        </section> 
        <a href="sistema.php" class="volta"><h1>Ir para Página de cliente</h1></a>
        <a href="sair.php"><button class="saida">SAIR</button></a>
    </div>

    <div class="caixa">
        <a href="prod.php"><button class="botao1"><h1>Reg.Produto</h1></button></a>
        <a href="modprod1.php"><button class="botao2"><h1>Mod.Produto</h1></button></a>
        <a href="modcliente1.php"><button class="botao3"><h1>Mod.Cliente</h1></button></a>
    </div>
</body>
</html>
