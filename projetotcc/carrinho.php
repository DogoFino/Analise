<?php
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['cpf'])) {
    header("Location: login.php"); // Redireciona para a página de login se não estiver logado
    exit();
}

// Inclui o arquivo de configuração para conexão com o banco de dados
include 'config.php';

// Pega o CPF do usuário logado
$cpf = $_SESSION['cpf'];

// Prepara a consulta SQL para buscar os dados do usuário logado
$stmt = $conexao->prepare("SELECT * FROM usuario WHERE cpf = ?");
$stmt->bind_param("s", $cpf);

if ($stmt->execute()) {
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $usuario = $result->fetch_assoc(); // Obtém os dados do usuário
    } else {
        echo "Nenhum usuário encontrado com esse CPF.";
    }
} else {
    echo "Erro ao executar a consulta: " . $stmt->error;
}
$stmt->close();

// Lógica para adicionar produto ao carrinho
if (isset($_GET['add_product'])) {
    $produto_id = $_GET['add_product'];
    $nome = $_GET['nome'];
    $descricao = $_GET['descricao'];
    $preco = $_GET['preco'];
    $imagem = $_GET['imagem'];

    // Adiciona o produto ao carrinho na sessão
    if (!isset($_SESSION['carrinho'])) {
        $_SESSION['carrinho'] = [];
    }
    $produto = [
        'id' => $produto_id,
        'nome' => $nome,
        'descricao' => $descricao,
        'preco' => $preco,
        'imagem' => $imagem
    ];
    
    // Adiciona o produto ao carrinho
    $_SESSION['carrinho'][] = $produto;

    // Redireciona para a página do carrinho
    header("Location: carrinho.php");
    exit();
}

// Lógica para remover produto do carrinho
if (isset($_GET['remove_product'])) {
    $produto_id = $_GET['remove_product'];

    // Percorre o carrinho para remover o produto com o ID específico
    foreach ($_SESSION['carrinho'] as $key => $produto) {
        if ($produto['id'] == $produto_id) {
            unset($_SESSION['carrinho'][$key]); // Remove o produto do carrinho
            $_SESSION['carrinho'] = array_values($_SESSION['carrinho']); // Reindexa o carrinho
            break;
        }
    }

    // Redireciona para atualizar a página do carrinho
    header("Location: carrinho.php");
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
    <title>Carrinho</title>
</head>
<body>
    <header class="cabeçalho"> 
        <img src="./images/logok2.png" class="logo" alt="Logo">
        <nav>
            <a href="sistema.php" class="itens1">Voltar para a Página Principal</a>
            <div class="dropdown">
                <button class="dropbtn"><?= htmlspecialchars($usuario['nome']); ?></button>
                <div class="dropdown-content">
                    <a href="carrinho.php">Carrinho</a>
                    <a href="sair.php">Sair</a>
                </div>
            </div>
        </nav>
    </header>

    <main>
        <h2>Seu Carrinho</h2>

        <?php
        // Verifica se o carrinho está vazio
        if (isset($_SESSION['carrinho']) && count($_SESSION['carrinho']) > 0) {
            foreach ($_SESSION['carrinho'] as $produto) {
                echo "<div class='carrinho-item'>";
                echo "<img src='" . htmlspecialchars($produto['imagem']) . "' alt='Imagem do produto'>";
                echo "<div class='carrinho-item-info'>";
                echo "<h3>" . htmlspecialchars($produto['nome']) . "</h3>";
                echo "<p>" . htmlspecialchars($produto['descricao']) . "</p>";
                echo "<p><strong>R$" . number_format($produto['preco'], 2, ',', '.') . "</strong></p>";
                // Botão para remover o produto
                echo "<a href='?remove_product=" . $produto['id'] . "' class='btn-remover'>Remover</a>";
                echo "</div>";
                echo "</div>";
            }
        } else {
            echo "<p>Seu carrinho está vazio.</p>";
        }
        ?>

        <!-- Botões de ação -->
        <div class="botoes-carrinho">
            <a href="sistema.php"><button class="btn-continuar">Continuar Navegando</button></a>
            <a href="finalizar.php"><button class="btn-finalizar">Finalizar Pedido</button></a>
        </div>

    </main>
</body>
</html>
