<?php
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['cpf'])) {
    header("Location: login.php");
    exit();
}

// Inclui o arquivo de configuração para conexão com o banco de dados
include 'config.php';

// Pega o CPF do usuário logado
$cpf = $_SESSION['cpf'];

// Verifica se o nome do usuário está na sessão; caso contrário, usa "Visitante"
$nomeUsuario = isset($_SESSION['nome']) && !empty($_SESSION['nome']) ? $_SESSION['nome'] : 'Visitante';

// Lógica para adicionar produtos ao carrinho
if (isset($_GET['add_product'])) {
    $id_produto = $_GET['add_product'];

    // Consulta para buscar o produto
    $stmt = $conexao->prepare("SELECT id_produto, nomep, preco, descricao, imagem FROM produto WHERE id_produto = ?");
    $stmt->bind_param("i", $id_produto);
    
    if ($stmt->execute()) {
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $produto = $result->fetch_assoc();
            
            // Verifica se o produto já está no carrinho
            $check_stmt = $conexao->prepare("SELECT quantidade FROM carrinho WHERE cpf = ? AND id_produto = ?");
            $check_stmt->bind_param("si", $cpf, $id_produto);
            $check_stmt->execute();
            $check_result = $check_stmt->get_result();

            if ($check_result->num_rows > 0) {
                // Incrementa a quantidade do produto no carrinho
                $update_stmt = $conexao->prepare("UPDATE carrinho SET quantidade = quantidade + 1 WHERE cpf = ? AND id_produto = ?");
                $update_stmt->bind_param("si", $cpf, $id_produto);
                $update_stmt->execute();
                $_SESSION['mensagem'] = "Quantidade do Produto Aumentada!";
                $update_stmt->close();
            } else {
                // Adiciona o produto ao carrinho
                $insert_stmt = $conexao->prepare("INSERT INTO carrinho (cpf, id_produto, nomep, preco, imagem, quantidade) VALUES (?, ?, ?, ?, ?, 1)");
                $insert_stmt->bind_param("sisds", $cpf, $id_produto, $produto['nomep'], $produto['preco'], $produto['imagem']);
                $insert_stmt->execute();
                $_SESSION['mensagem'] = "Produto Adicionado ao Carrinho!";
                $insert_stmt->close();
            }
            $check_stmt->close();
        } else {
            $_SESSION['mensagem'] = "Produto não encontrado.";
        }
        $stmt->close();
    } else {
        $_SESSION['mensagem'] = "Erro ao buscar produto: " . $stmt->error;
    }

    // Redireciona para evitar reenviar o formulário
    header("Location: sistema.php");
    exit();
}
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
            <div class="dropdown">
                <button class="dropbtn"><?= htmlspecialchars($nomeUsuario); ?></button>
                <div class="dropdown-content">
                    <a href="carrinho.php">Carrinho</a>
                    <a href="sair.php">Sair</a>
                </div>
            </div>
        </nav>
    </header>

    <main>
        <section class="embaixo-cabe" id="baixo"></section>  

        <?php
        if (isset($_SESSION['mensagem'])) {
            echo '<div class="mensagem">' . $_SESSION['mensagem'] . '</div>';
            unset($_SESSION['mensagem']);
        }
        ?>

        <div class="card-container">
            <?php
            // Exibe produtos
            $sql = "SELECT id_produto, nomep, imagem, preco, descricao FROM produto";
            $result = $conexao->query($sql);

            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='card'>";
                    echo "<div class='card-header'><h2>" . htmlspecialchars($row["nomep"]) . "</h2></div>"; 
                    echo "<div class='p'><img src='" . htmlspecialchars($row["imagem"]) . "' alt='Imagem do produto'></div>";
                    echo "<div class='p'><h3>Preço: R$" . number_format($row["preco"], 2, ',', '.') . "</h3></div>"; 
                    echo "<div class='card-header'><h3>" . htmlspecialchars($row["descricao"]) . "</h3></div>"; 
                    echo "<a href='sistema.php?add_product=" . $row['id_produto'] . "'><button>COMPRAR</button></a>";
                    echo "</div>";  
                }
                $result->free();
            } else {
                echo "<h1>0 resultados</h1>"; 
            }
            ?>
        </div>
    </main>
</body>
</html>

<?php
$conexao->close();
?>
