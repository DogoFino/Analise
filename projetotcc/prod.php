<?php
session_start();

// Verifica se o usuário está logado e pega o email
$logado = isset($_SESSION['email']);
$email = $logado ? $_SESSION['email'] : null;

if(isset($_POST['env']))
{
    
    // Função para upload de imagem (com tratamento de erros)
    function uploadImagem($image) {
        $target_dir = "images/";
        $target_file = $target_dir . basename($image["name"]);

        if (move_uploaded_file($image["tmp_name"], $target_file)) {
            return $target_file;
        } else {
            echo "Erro ao fazer upload da imagem.";
            return null;
        }
    }

    include_once('config.php');
        $preco = $_POST['preco'];
        $nomep = $_POST['nomep'];
        $quantidade = $_POST['quantidade'];
        $image = $_FILES['images'];
        $classificacao = $_POST['clas'];
        $descricao = $_POST['desc'];

    // Upload da imagem
    $imagem_path = null;
    if (isset($image) && $image["error"] === 0) {
        $imagem_path = uploadImagem($image);
        if (!$imagem_path) {
            $erros[] = "Erro ao enviar a imagem.";
        }
    }
    
    // Verifica se o upload da imagem foi bem-sucedido
    if ($imagem_path) {
        
        $stmt = $conexao->prepare("INSERT INTO produto (preco, nomep, classificacao, descricao, imagem ,quantidade) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $preco, $nomep, $classificacao, $descricao, $imagem_path, $quantidade);

        // Executando a query
        if ($stmt->execute()) {
            echo "Novos registros inseridos com sucesso";
        } else {
            echo "Erro ao inserir registros: ";
        }

    }

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="prod.css">
    <title>CUUUUUUUUUU</title>
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

        <a href="prod.php"><button class="botao1"><h1>Reg.Produto</h1></button></a>
        <a href=""><button class="botao2"><h1>Mod.Produto</h1></button></a>
        <a href="modcliente1.php"><button class="botao3"><h1>Mod.Cliente</h1></button></a>

    </div>
    <div class="meio">

                <form method="POST" action="prod.php" class="infos" enctype="multipart/form-data">
                    <s="container">
                            <div>
                                <h1 id="h2">Nome do Produto</h1>
                                <input name="nomep" type="text" id="text" class="inpute" required>
                            </div>
                            <div>
                                <h1 id="h2">Preço do Produto</h1>
                                <input name="preco" type="number" id="text" class="inpute" step="0.01" min="0" placeholder="0.00" required>
                            </div>
                            <div class="quant">
                                <h1 id="h2">Quantidade</h1>
                                <input name="quantidade" type="number" id="text" class="inpute" required>
                            </div>
                            <div class="classe">
                                <h1 id="h2">Classificação</h1>
                                <select name="clas" type="text" id="text" class="inpute" required>
                                    <option value="">Nenhuma</option>
                                    <option value="Chave de Fenda" style="color: black;">Chave de Fenda</option>
                                    <option value="Chave Philips" style="color: black;">Chave Philips</option>
                                    <option value="Chave de Boca" style="color: black;">Chave de Boca</option>
                                    <option value="Martelo" style="color: black;">Martelo</option>
                                    <option value="Chave Inglesa" style="color: black;">Chave Inglesa</option>
                                    <option value="Serrote" style="color: black;">Serrote</option>
                                    <option value="Furadeira" style="color: black;">Furadeira</option>
                                    <option value="Trena" style="color: black;">Trena</option>
                                </select>
                            </div> 
                            <div class="descr">   
                                    <h1 id="h2">Descrição</h1>
                                    <textarea name="desc" id="text1" class="inpute" required></textarea>
                            </div>
                            <div class="imagem">
                                    <p><input type="file"  accept="images/*" name="images" id="file" onchange="loadFile(event)" style="display: none;" required></p>
                                    <h1><p id="h2"><label for="file" style="cursor: pointer;">Clique aqui para escolher a imagem</label></p></h1>
                                    <button type="submit" value="Enviar" name="env" id="botao">Enviar</button>
                            </div>
                </form>
    </div>
</body>
</html>