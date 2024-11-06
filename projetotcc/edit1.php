<?php
include_once('config.php');
session_start();

// Verifica se o usuário está logado e pega o email
$logado = isset($_SESSION['email']);
$email = $logado ? $_SESSION['email'] : null;

if (!$logado) {
    header("location: Login.php");
    exit;
}

if (!$logado || !isset($_SESSION['tipo']) || $_SESSION['tipo'] != 0) {
    // Redireciona para sistema.php se o usuário não for tipo=1
    header("Location: sistema.php");
    exit(); // Para o script após o redirecionamento
}

// Verifica se o id_produto foi passado na URL
if (isset($_GET['id_produto'])) {
    // Sanitiza a entrada
    $id_produto = mysqli_real_escape_string($conexao, $_GET['id_produto']);

    // Prepara a consulta SQL para buscar o produto específico pelo id_produto
    $sql = "SELECT * FROM produto WHERE id_produto=?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("i", $id_produto); // Passa id_produto como parâmetro

    // Executa a consulta
    if ($stmt->execute()) {
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Obtém os dados do produto
            $produto_data = $result->fetch_assoc();

            // Atribui os valores recuperados para exibir no formulário
            $nomep = $produto_data['nomep'];
            $preco = $produto_data['preco'];
            $classificacao = $produto_data['classificacao'];
            $descricao = $produto_data['descricao'];
            $imagem = $produto_data['imagem'];
            $quantidade = $produto_data['quantidade'];
        } else {
            echo "Produto não encontrado.";
            exit;
        }
    } else {
        echo "Erro ao executar a consulta: " . $stmt->error;
        exit;
    }
    $stmt->close();
} else {
    echo "ID do produto não fornecido.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Produto</title>
    <style>
        /* Seu CSS aqui */
    </style>
</head>
<body>
<?php if ($logado) { ?>
    <h1>Editor de Produto</h1>
<?php } else { 
    header("location: Login.php");
    exit;
} ?>
    
<a href="modprod1.php" class="saida">Voltar</a>
<div class="box">
    <form action="saveEdit1.php" method="POST" enctype="multipart/form-data">
        <fieldset>
            <legend><b>Editar Produto</b></legend>
            <!-- Passa o ID do produto como um campo oculto -->
            <input type="hidden" name="id_produto" value="<?php echo htmlspecialchars($id_produto); ?>">

            <label for="preco">Preço:</label>
            <input type="text" id="preco" name="preco" value="<?php echo htmlspecialchars($preco); ?>" required>

            <label for="nomep">Nome:</label>
            <input type="text" id="nomep" name="nomep" value="<?php echo htmlspecialchars($nomep); ?>" required>

            <!-- Substitui o input de classificação pelo select -->
            <label for="classificacao">Classificação:</label>
            <label for="classificacao">Classificação:</label>
            <select id="classificacao" name="classificacao" required>
                <option value="">Nenhuma</option>
                <option value="Chave de Fenda" <?php echo ($classificacao == 'Chave de Fenda') ? 'selected' : ''; ?> style="color: black;">Chave de Fenda</option>
                <option value="Chave Philips" <?php echo ($classificacao == 'Chave Philips') ? 'selected' : ''; ?> style="color: black;">Chave Philips</option>
                <option value="Chave de Boca" <?php echo ($classificacao == 'Chave de Boca') ? 'selected' : ''; ?> style="color: black;">Chave de Boca</option>
                <option value="Martelo" <?php echo ($classificacao == 'Martelo') ? 'selected' : ''; ?> style="color: black;">Martelo</option>
                <option value="Chave Inglesa" <?php echo ($classificacao == 'Chave Inglesa') ? 'selected' : ''; ?> style="color: black;">Chave Inglesa</option>
                <option value="Serrote" <?php echo ($classificacao == 'Serrote') ? 'selected' : ''; ?> style="color: black;">Serrote</option>
                <option value="Furadeira" <?php echo ($classificacao == 'Furadeira') ? 'selected' : ''; ?> style="color: black;">Furadeira</option>
                <option value="Trena" <?php echo ($classificacao == 'Trena') ? 'selected' : ''; ?> style="color: black;">Trena</option>
            </select>

            <label for="descricao">Descrição:</label>
            <input type="text" id="descricao" name="descricao" value="<?php echo htmlspecialchars($descricao); ?>" required>

            <label for="imagem">Imagem:</label>
            <input type="file" id="imagem" name="imagem" accept="image/*"><br>

            <label for="quantidade">Quantidade:</label>
            <input type="text" id="quantidade" name="quantidade" value="<?php echo htmlspecialchars($quantidade); ?>" required>

            <input type="submit" name="update" id="submit">
        </fieldset>
    </form>
</div>

</body>
</html>
