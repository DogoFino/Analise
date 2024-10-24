<?php
session_start();

// Verifica se o usuário está logado e pega o email
$logado = isset($_SESSION['email']);
$email = $logado ? $_SESSION['email'] : null;
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
            <?php if ($logado){ ?>
                <h1>Bem-vindo, <u><?= htmlspecialchars($email);} else{ 
                header("location: Login.php");} ?></u></h1>
             
        </section> 
    <a href="sistema.php" class="volta"><h1>Ir para Página de cliente</h1></a>
    <a href="sair.php"><button class="saida">SAIR</button></a>

    </div>

    <div class="caixa">

        <a href="prod.php"><button class="botao1" ><h1>Reg.Produto</h1></button></a>
        <a href=""><button class="botao2" ><h1>Mod.Produto</h1></button></a>
        <a href="modcliente1.php"><button class="botao3" ><h1>Mod.Cliente</h1></button></a>

    </div>
</body>
</html>