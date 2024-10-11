<?php
    session_start();
    //print_r($_SESSION);
    if((!isset($_SESSION['email']) == true) and (!isset($_SESSION['senha']) == true))
    {
        unset($_SESSION['email']);
        unset($_SESSION['senha']);
        header('Location: Login.php');
    }
    $logado = $_SESSION['email'];
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="sistema.css">
    <title>logado</title>
</head>
<body>
    <div class="cabeçalho"> 
        <img src="./images/logok2.png" class="logo">
        <a href="#baixo" class="itens1">Home</a>
        <a href="sair.php"><button class="saida">SAIR</button></a>
    </div>
    <div class="embaixo-cabe" id="baixo">
            <?php
                echo "<h1>Bem vindo <u>$logado</u></h1>";
            ?>
    </div>        
    
    <div class="card-container">

    <?php
include_once('config.php');

// Preparando a query SQL para selecionar os dados
$sql = "SELECT nomep, imagem, descricao, preco FROM produto";
$result = $conexao->query($sql);

if ($result->num_rows > 0) {
    // Saída dos dados de cada linha
    while($row = $result->fetch_assoc()) {
      
      echo "<div class='card'>";
      echo "<div class='card-header'><h2>" . $row["nomep"] . "</h2></div>"; // Nome do produto em h1
      echo "<div class='p'> <img src='" . $row["imagem"] . "' alt='Imagem'><br>" . "</div>";
      echo "<div class='p'><h1>Descrição: " . $row["descricao"] . "</h1></div>"; // Descrição em h1
      echo "<div class='p'><h1>Preço: " . $row["preco"] . "</h1></div>"; // Preço em h1
      echo '<a href="colab.html"><button>COMPRAR</button></a>';
      echo "</div>";  
        
    }
} else {
    echo "<h1>0 resultados</h1>"; // Mensagem de resultados em h1
}

$conexao->close();
?>

</div>

    
</body>
</html>