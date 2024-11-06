<?php
include_once('config.php');
session_start();

if (empty($_SESSION['cpf'])) {
    header("Location: login.php");
    exit();
}

// Inclui o arquivo de configuração para conexão com o banco de dados
include 'config.php'; // Certifique-se de que este arquivo contém a configuração da conexão

// Verifica se o usuário está logado e pega o CPF
$cpf = $_SESSION['cpf'];

// Prepara a consulta SQL para buscar os dados do usuário logado
$stmt = $conexao->prepare("SELECT * FROM usuario WHERE cpf = ?");
$stmt->bind_param("s", $cpf);

if ($stmt->execute()) {
    $result = $stmt->get_result();

    // Verifica se algum usuário foi encontrado
    if ($result->num_rows > 0) {
        $usuario = $result->fetch_assoc(); // Obtém os dados do usuário

        // Verifica o tipo de usuário e redireciona se for tipo 0
        if ($usuario['tipo'] == 0) {
            header("Location: sistema.php");
            exit();
        }
    } else {
        echo "Nenhum usuário encontrado com esse CPF.";
    }
} else {
    echo "Erro ao executar a consulta: " . $stmt->error;
}
$stmt->close();

if (isset($_GET['email'])) {
    $email = $_GET['email'];

    $stmt = $conexao->prepare("SELECT * FROM usuario WHERE email = ?");
    $stmt->bind_param("s", $email);

    if ($stmt->execute()) {
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user_data = $result->fetch_assoc();

            $nome = $user_data['nome'];
            $email = $user_data['email'];
            $senha = $user_data['senha'];
            $cpf = $user_data['cpf'];
            $telefone = $user_data['telefone'];
            $tipo = $user_data['tipo'];
        } else {
            echo "Usuário não encontrado.";
            exit();
        }
    } else {
        echo "Erro ao executar a consulta: " . $stmt->error;
        exit();
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="edit.css">
    <title>Editar Cliente</title>
    <style>
        /* Seus estilos CSS aqui */
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('cpf').addEventListener('input', function(e) {
                let value = e.target.value.replace(/\D/g, '').slice(0, 11);
                value = value.replace(/(\d{3})(\d)/, '$1.$2');
                value = value.replace(/(\d{3})(\d)/, '$1.$2');
                value = value.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
                e.target.value = value;
            });

            document.getElementById('telefone').addEventListener('input', function(e) {
                let value = e.target.value.replace(/\D/g, '').slice(0, 11);
                value = value.replace(/(\d{2})(\d{5})(\d{0,4})/, '($1) $2-$3');
                e.target.value = value;
            });
        });
    </script>
</head>
<body>
    <header>
        <h1>Editar Cliente</h1>
        <a href="modcliente1.php" class="saida">Voltar</a>
    </header>

    <div class="box">
        <form action="saveEdit.php" method="POST">
            <fieldset>
                <legend><b>Editar Cliente</b></legend>
                
                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($nome); ?>" required>

                <label for="email">E-mail:</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required readonly>

                <label for="senha">Senha:</label>
                <input type="password" id="senha" name="senha" value="<?php echo htmlspecialchars($senha); ?>" required>

                <label for="cpf">CPF:</label>
                <input type="text" id="cpf" name="cpf" value="<?php echo htmlspecialchars($cpf); ?>" maxlength="14" required readonly>

                <label for="telefone">Telefone:</label>
                <input type="tel" id="telefone" name="telefone" value="<?php echo htmlspecialchars($telefone); ?>" maxlength="15" required>

                <label for="tipo">Tipo:</label>
                <select id="tipo" name="tipo" required>
                    <option value="" disabled>Selecione o tipo</option>
                    <option value="0" <?php echo $tipo == 0 ? 'selected' : ''; ?>>0</option>
                    <option value="1" <?php echo $tipo == 1 ? 'selected' : ''; ?>>1</option>
                </select>

                <input type="hidden" name="original_email" value="<?php echo htmlspecialchars($email); ?>">
                <input type="submit" name="update" value="Atualizar">
            </fieldset>
        </form>
    </div>
</body>
</html>
