<?php 
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

    $conexao->close();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Tela de Registro de Produtos</title>

    <script src="RegistroPro.js"></script>
    <style> 
    body {
    height: 100%;
    margin: 0;
    padding: 0;
  }
  
  body {
    background-image: url('./images/background.jpg');
    background-repeat: no-repeat;
    background-size: cover;
    background-position: center center;
    background-attachment: fixed;
  }

  .caixa {
    background-color: #475D7F;
    position: relative;
    height: 700px;
    width: 80%;
  }

  .lolo {
      position: absolute;
      margin-top: -10%;
      margin-left: -63%;
      width: 20%;
  }

  .titu {
      position: relative;
      right: 50px;
      top: 20px;
      margin-top: 4%;
      margin-left: 10%;
      font-size: 50px;
      color: rgba(255, 255, 255, 0.801);
  }

  .infos {
    width: 20%;
  }

  .inputs {
      position: relative;
      top: 5%;
      right: 35%;
      height: 72.5%;
      width: 100%;
  }

  .inpute {
    position: relative;
    left: 100px;
    border: none;
    border-bottom: 2px solid white;
    background: none;
    outline: none;
    box-shadow: none;
    color: white;
  }

  .container {
    background-color: #475D7F;
    padding: 15px;
    display: grid;
    grid-template-columns: 10% 20% 24% 35%;
    grid-template-rows: 40% 50% 60%;
    height: 500px;
}

.container div {
    padding: 20px;
}

.desgra {
    position: relative;
    left: 110%;
    top: -875px;
}

.raiva {
    position: relative;
    left: 150%;
    top: 450px;
}

.p {
    position: relative;
}

.s {
    position: relative;
    top: 16px;
}

.t {
    position: relative;
    top: 40px;
}


#foto {
    grid-column-start: 4;
    grid-row-start: 1;
    grid-row-end: 3;
}

#h2 {
  color: rgba(255, 255, 255, 0.801);
}

#text {
    border-radius: 2px;
    border-color: white;
    padding: 03%;
    width: 90%;
  }

#text1 {
  position: relative;
  left: 50px;
  width: 300px;
  height: 100px;
  resize: none;

}

#botao {
  width: 50%;
  height: 40px;
  position: relative;
  right: 90%;
  top: 50px;
  border-radius: 5px;
  outline: none;
  border: none;
}

button:hover {
    background-color: #adadad;
  }

#descri {
  position: relative;
  right: -10%;
}

h1 {
  font-family: cursive;
}
    </style>
</head>
<body>
    <!--<div id="cabe">    
        <img src="./images/logotool.png" id="logo">
        <img src="./images/logo_nome.png" alt="Overlay Image" id="logo_nome">
        <img src="./images/perfil.png" id="perfil">
    </div> -->
    <br><br><br><br>
    <center>
        <div class="caixa">
            <img src="./images/logok2.png" class="lolo">
            <h1 class="titu">Cadastro de Produtos</h1>
            <div class="inputs">
                <form method="POST" action="RegistroPro.php" class="infos" enctype="multipart/form-data">
                    <s="container">
                        <div id="pri" class="p">
                            <center>
                                <h1 id="h2">Preço do Produto</h1>
                                <input name="preco" type="number" id="text" class="inpute" step="0.01" min="0" placeholder="0.00" required>
                            </center>
                        </div>
                        <div class="s">
                            <center>
                                <h1 id="h2">Nome do Produto</h1>
                                <input name="nomep" type="text" id="text" class="inpute" required>
                            </center>
                        </div>
                        <div class="t">  
                            <center>
                                <h1 id="h2">Quantidade</h1>
                                <input name="quantidade" type="number" id="text" class="inpute" required>
                            </center>
                        </div>
                    <div class="desgra">
                            <div id="foto" class="raiva">
                                <center>
                                    <p><input type="file"  accept="images/*" name="images" id="file" onchange="loadFile(event)" style="display: none;" required></p>
                                    <h1><p id="h2"><label for="file" style="cursor: pointer;">Upload Image</label></p></h1>
                                    <p><img id="output" width="500" height="300" /></p>
                                    <button type="submit" value="Enviar" name="env" id="botao">Enviar</button>
                                </center>
                            </div>
                            <div>
                                <center>
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
                                </center> 
                            </div>
                            <div id="descri">
                                <center>
                                    <h1 id="h2">Descrição</h1>
                                    <textarea name="desc" id="text1" class="inpute" required></textarea>
                                </center>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </center>
</body>
</html>