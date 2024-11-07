<?php
session_start();
include_once('config.php');

// Verifica se o usuário já está logado
if (isset($_SESSION['cpf'])) {
    // Redireciona conforme o tipo de usuário
    if (isset($_SESSION['tipo']) && $_SESSION['tipo'] == 1) {
        header("Location: adm.php");
    } else {
        header("Location: sistema.php");
    }
    exit();
}

// Processa o login se o formulário foi enviado
if (isset($_POST['submit']) && !empty($_POST['email']) && !empty($_POST['senha'])) {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Prepara a consulta SQL para evitar injeção de SQL
    $stmt = $conexao->prepare("SELECT cpf, nome, tipo FROM usuario WHERE email=? AND senha=?");
    $stmt->bind_param("ss", $email, $senha);

    // Executa a consulta
    if ($stmt->execute()) {
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            // Armazena os dados do usuário na sessão
            $_SESSION['cpf'] = $row['cpf'];
            $_SESSION['nome'] = $row['nome']; // Armazena o nome do usuário na sessão
            $_SESSION['tipo'] = $row['tipo'];

            // Redireciona conforme o tipo de usuário
            if ($row['tipo'] == 1) {
                header("Location: adm.php");
            } else {
                header("Location: sistema.php");
            }
            exit();
        } else {
            // Define uma mensagem de erro se o login falhar
            $_SESSION['error'] = "Email ou senha inválidos.";
            header("Location: login.php");
            exit();
        }
    } else {
        // Define uma mensagem de erro se houver falha ao executar a consulta
        $_SESSION['error'] = "Erro ao executar a consulta.";
        header("Location: login.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Tela de Login</title>
    <link rel="stylesheet" href="LoginP.css">
</head>
<body>
    <center>
        <div class="caixa">
            <a href="Index.html"><img src="./images/logok2.png" class="lolo"></a>
            <div class="inputs">
                <form action="" class="form" method="POST">
                    <h1 class="escrita">Email</h1>
                    <input type="text" class="email" name="email" required>
                    <h1 class="escrita2">Senha</h1>
                    <input type="password" class="senha2" name="senha" required>
            </div>        
            <div class="fundao">
                <button type="submit" class="button" name="submit" value="Enviar">Logar</button>
                </form>

                <!-- Exibe mensagem de erro, se houver -->
                <?php
                if (isset($_SESSION['error'])) {
                    echo "<p style='color:red'>" . $_SESSION['error'] . "</p>";
                    unset($_SESSION['error']); // Remove a mensagem de erro após exibi-la
                }
                ?>

                <h2 class="fundo">Não possui conta?</h2>
                <h2 class="cada"><a href="Registro.php">Cadastrar-se</a></h2>
                <br>
                <h2 class="esq"><a href="nada">Esqueci minha senha</a></h2>
            </div>
        </div>
    </center>
</body>
</html>
