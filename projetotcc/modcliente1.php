<?php
include_once('config.php');

session_start();

// Verifica se o usuário está logado e pega o email
$logado = isset($_SESSION['email']);
$email = $logado ? $_SESSION['email'] : null;


// Obtém o termo de busca da URL (se existir)
$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';

// Cria a consulta SQL com filtragem por nome ou email
$sql = "SELECT nome, email, senha, cpf, telefone, tipo 
        FROM usuario 
        WHERE nome LIKE '%$searchTerm%' 
        OR email LIKE '%$searchTerm%'";

// Executa a consulta e verifica se houve sucesso
$result = $conexao->query($sql);
if (!$result) {
    die("Falha ao executar a consulta: " . $conexao->error);

}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="adm.css">
    <title>Document</title>
    <style>
       
    </style>
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

<div class="meio">


    <div class="box-search">
    
    <button onclick="searchData()" class="btn btn-primary" id="botao4">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6
            </svg>
        </button>
    </div>
    <div class="m-5">
        <table class="table text-white table-bg" id="tabelaa">
            <thead>
                <tr class="nomes">
                    
                
                    <th scope="col">nome</th>
                    <th scope="col">email</th>
                    <th scope="col">senha</th>
                    <th scope="col">cpf</th>
                    <th scope="col">telefone</th>
                    <th scope="col">tipo</th>
                    <th scope="col">...</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    while($user_data = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                      //  echo "<td>".$user_data['id']."</td>";
                        echo "<td>".$user_data['nome']."</td>";
                        echo "<td>".$user_data['email']."</td>";
                        echo "<td>".$user_data['senha']."</td>";
                        echo "<td>".$user_data['cpf']."</td>";
                        echo "<td>".$user_data['telefone']."</td>";
                        echo "<td>".$user_data['tipo']."</td>";
                        echo "<td>
                        <a class='negocio' href='edit.php?email=$user_data[email]' title='Editar'>
                            <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-pencil' viewBox='0 0 16 16'>
                                <path d='M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z'/>
                            </svg>
                            </a> 
                            <a class='delet' href='delete.php?email=$user_data[email]' title='Deletar'>
                                <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-trash-fill' viewBox='0 0 16 16'>
                                    <path d='M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z'/>
                                </svg>
                            </a>
                            </td>";
                        echo "</tr>";
                    }
                    ?>


    </div>
</body>
</html>