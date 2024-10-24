<?php
include_once ('config.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Obter dados do formulário
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $cpf = $_POST['cpf'];
    $telefone = $_POST['telefone'];


    // Inserir dados na tabela
    $sql = "INSERT INTO usuario (nome, email, senha, cpf, telefone) VALUES ('$nome', '$email', '$senha', '$cpf', '$telefone')";

    if ($conexao->query($sql) === TRUE) {
        header("Location: Login.php");
    }
    else{
        echo "Erro no Cadastro ";
    }

    

    // Fechar conexão
    $conexao->close();
    
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="StyleR.css">
    <title>Tela Registro</title>
    
</head>

<style>

.inputs {
  width: 90%;
  height: 30%;
  padding-left: 10px;
  padding-right: 10px;
  border: none;
  border-bottom: 2px solid white;
  background: none;
  outline: none;
  box-shadow: none;
  color: white;
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

<body>
    <div id="lgo">
        <a href="Index.html"><img src="./images/logok2.png" class="lolo"></a> 
    </div>
    
<div class="container">
    <form action="Registro.php" class="form" method="POST">
        <div class="lado_e">
            <h1 class="escrita">Nome</h1>
            <input name="nome" type="text" class="inputs" required>
        </div>
        <div class="lado_e">            
            <h1 class="escrita">Email</h1>
            <input name="email" type="email" class="inputs" required>
        </div>
        <div class="lado_e">
            <h1 class="escrita">Senha</h1>
            <input name="senha" type="password" class="inputs" required>
        </div>
        <div class="lado">
            <h1 class="escrita">CPF</h1>
            <input name="cpf" type="text" id="cpf" class="inputs" placeholder="000.000.000-00" maxlength="14" required>
        </div>
        <div class="lado2">
            <h1 class="escrita">Telefone</h1>
            <input name="telefone" type="tel" id="telefone" class="inputs" placeholder="(00) 00000-0000" maxlength="15" required>
        </div>
        <div id="botom">
            <button type="submit" name="submit" id="enviar">Terminar Cadastro</button>
        </div>
    </form>
    <div id="fundo">
        <h2 id="link">Já possui conta?</h2>
        <a href="Login.php"><h2 id="lika">Login</h2></a>
    </div>
</div>

<div class="footer">
    <img src="./images/logok.png" class="fot">
    <h4 class="txtfoot">trabalho estudantil © Copyright 2024. Todos os direitos reservados.</h4>
</div>
</body>
</html>

