<?php
include_once('config.php');

session_start();

// Verifica se o usuário está logado e pega o email
$logado = isset($_SESSION['email']);
$email = $logado ? $_SESSION['email'] : null;

// Verifica se o parâmetro 'email' foi enviado via GET
if (isset($_GET['email'])) {
    // Sanitiza o email para evitar injeção de SQL
    $email = mysqli_real_escape_string($conexao, $_GET['email']);

    // Prepara a consulta SQL utilizando prepared statements
    $sql = "SELECT * FROM usuario WHERE email=?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("s", $email);

    // Executa a consulta
    if ($stmt->execute()) {
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Obtém os dados do usuário
            $user_data = $result->fetch_assoc();

            // Atribui os valores aos campos do formulário
            $nome = $user_data['nome'];
            $email = $user_data['email'];
            // ... outros campos ...
        } else {
            echo "Usuário não encontrado.";
            exit;
        }
    } else {
        echo "Erro ao executar a consulta: " . $stmt->error;
        exit;
    }
}
    // Fecha o statement

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Cadastro de Cliente</title>
    <style>
        body {
            background-image: url('./images/background.jpg');
        background-repeat: no-repeat;
        background-size: cover;
        background-position: center center;
        background-attachment: fixed;
        color: white;
        }
        h1{
            text-align: center;
        }
        header{
            background-color: palevioletred;
             padding: 10px 0;
            text-align: center;
            }
        form {
            max-width: 600px;
            margin: 0 auto;
            background-color: #475D7F;
        }

        label {
            display: block;
            margin-bottom: 8px;
        }

        input, select {
            width: 100%;
            padding: 8px;
            margin-bottom: 16px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #45e05f;
            color: white;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #435dd1;
        }
        header{
    background-color: palevioletred;
    padding: 10px 0;
    text-align: center;
    }

    nav ul{
    list-style: none;

    }

        nav ul li{
    display: inline;
    margin-right: 20px;
    }
    nav ul li a{
    text-decoration: none;
    color: #151414;
    font-weight: bold;
    }
    .saida {
    padding: 20px;
    border-radius: 100px;
    background-color: #5c79a5;
    color:rgba(255, 255, 255, 0.801);
    border-style: none;
    font-size: 25px;
}

.saida:hover {
    background-color: #475D7F;
}

    </style>
    <script>

document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('cpf').addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        if (value.length <= 11) {
            value = value.replace(/(\d{3})(\d)/, '$1.$2');
            value = value.replace(/(\d{3})(\d)/, '$1.$2');
            value = value.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
        }
        e.target.value = value;
    });

    document.getElementById('telefone').addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        if (value.length <= 11) {
            value = value.replace(/(\d{2})(\d{5})(\d{0,4})/, '($1) $2-$3');
        }
        e.target.value = value;
    });
});

</script>

</head>
<body>
    
<?php if ($logado){ ?>
                <h1>Editor de Cliente<?php } else{ 
                header("location: Login.php");} ?></u></h1>
    <body>
    <a href="modcliente1.php" class="saida">Voltar</a>
    <div class="box">
        <form action="saveEdit.php" method="POST">
            <fieldset>
                <legend><b>Editar Cliente</b></legend>
                <br>
                <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" required>

        <label for="email">E-mail:</label>
        <input type="email" id="email" name="email" required>

        <label for="senha">Senha:</label>
        <input type="password" id="senha" name="senha" required>

        <label for="cpf">CPF:</label>
        <input name="cpf" type="text" id="cpf" class="inputs" placeholder="000.000.000-00" maxlength="14" required>

        <label for="telefone">Telefone:</label>
        <input name="telefone" type="tel" id="telefone" class="inputs" placeholder="(00) 00000-0000" maxlength="15" required>

        <label for="tipo">tipo:</label>
        <select id="tipo" name="tipo" required>
            <option value="" disabled selected>Selecione o tipo</option>
            <option value="0">0</option>
            <option value="1">1</option>
           
        </select>

        <br><br>
				<input type="hidden" name="email" value=<?php echo $email;?>>
                <input type="submit" name="update" id="submit">
            </fieldset>
        </form>
    </div>

</html>