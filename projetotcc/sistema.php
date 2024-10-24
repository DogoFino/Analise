<?php
session_start();

// Verifica se o usuário está logado e pega o email
$logado = isset($_SESSION['email']);
$email = $logado ? $_SESSION['email'] : null;
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="sistema.css">
    <title>Logado</title>
</head>
<body>
    <header class="cabeçalho"> 
        <img src="./images/logok2.png" class="logo" alt="Logo">
        <nav>
            <a href="#baixo" class="itens1">Home</a>
            <a href="sair.php"><button class="saida">SAIR</button></a>
        </nav>
    </header>

    <main>
        <section class="embaixo-cabe" id="baixo">
            <?php if ($logado){ ?>
                <h1>Bem-vindo, <u><?= htmlspecialchars($email);} else{ 
                header("location: Login.php");} ?></u></h1>
             
        </section>        

        <div class="card-container">
            <?php
            include_once('config.php');

            // Preparando a query SQL para selecionar os dados
            $sql = "SELECT nomep, imagem, descricao, preco FROM produto";
            $result = $conexao->query($sql);

            if ($result && $result->num_rows > 0) {
                // Saída dos dados de cada linha
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='card'>";
                    echo "<div class='card-header'><h2>" . htmlspecialchars($row["nomep"]) . "</h2></div>"; 
                    echo "<div class='p'><img src='" . htmlspecialchars($row["imagem"]) . "' alt='Imagem do produto'></div>";
                    echo "<div class='p'><h1>Descrição: " . htmlspecialchars($row["descricao"]) . "</h1></div>"; 
                    echo "<div class='p'><h1>Preço: R$" . number_format($row["preco"], 2, ',', '.') . "</h1></div>"; 
                    echo '<a href="colab.html"><button>COMPRAR</button></a>';
                    echo "</div>";  
                }
            } else {
                echo "<h1>0 resultados</h1>"; 
            }

            $conexao->close();
            ?>
        </div>
    </main>
</body>
</html>
