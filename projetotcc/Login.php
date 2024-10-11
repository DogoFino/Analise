<?php 
session_start();

if (isset($_POST['submit']) && !empty($_POST['email']) && !empty($_POST['senha'])) {
    include_once('config.php');
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Prepare a consulta SQL para evitar injeção
    $stmt = $conexao->prepare("SELECT * FROM usuario WHERE email=? AND senha=?");
    $stmt->bind_param("ss", $email, $senha); // Assumindo que email e senha são strings

    // Executa a consulta
    if ($stmt->execute()) {
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            // Verifica o tipo de usuário
            if ($row['tipo'] == 1) {
                // Login válido para administrador, redireciona para adm.php
                header("Location: adm.php");
                exit();
            } else {
                // Login válido para outro tipo de usuário, redireciona para home
                header("Location: Login.php");
                exit();
            }
        } else {
            // Mensagem de erro se o login falhar
            $_SESSION['error'] = "Email ou senha inválidos.";
            header("Location: login.php"); // Redireciona para a página de login
            exit();
        }
    } else {
        $_SESSION['error'] = "Erro ao executar a consulta.";
        header("Location: login.php"); // Redireciona para a página de login
        exit();
    }
}

// Para mostrar a mensagem de erro na página de login
if (isset($_SESSION['error'])) {
    echo $_SESSION['error'];
    unset($_SESSION['error']); // Limpa a mensagem após exibi-la
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Tela de Login</title>
    <link rel="stylesheet" href="LoginP.css">

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
  
  #cabe {
    background-color: #475D7F;
    height: 150px;
    width: 100%;
    text-align: center;
    display: flex;
    align-items: center;
    justify-content: center;
  }
  
  #logo {
    position: absolute;
    top: 0;
    left: 0;
    width: 160px;
    height: 100px;
    object-fit: cover;
    margin-right: 16px;
    margin-top: 20px;
  }
  
  #logo_nome {
    position: absolute;
    top: 27px;
    left: -50px;
    width: 500px;
    height: 100px;
    object-fit: cover;
    z-index: 1;
  }
  
  @media screen and (max-width: 768px) {

  
    #logo {
      position: relative;
      width: 100px;
      height: auto;
      margin: 0;
    }
  
    #logo_nome {
      position: relative;
      width: 100px;
      height: auto;
      margin: 0;
    }
  
    #cabe {
      height: 100px;
    }
  }
  
  #perfil {
      width: 05%;
      position: absolute;
      margin-left: 100%;
  
  }

  .lolo {
    position: absolute;
    margin-top: -14%;
    margin-left: -155%;
    width: 50%;
  }

  .inputs {
    position: relative;
    top: -120px;
    right: 20%;
    border: none;
        border-bottom: 2px solid white;
        background: none;
        outline: none;
        box-shadow: none;
        color: white;
  }

  .caixa {
    background-color: #475D7F;
    position: relative;
    height: 500px;
    width: 500px;
  }

  .escrita {
    color: rgba(255, 255, 255, 0.808);
    position: absolute;
    margin-left: 33%;
    margin-top: 30%;
    font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
    font-size: 120%;
  }

  .email {
    position: absolute;
    margin-left: -20%;
    margin-top: 40%;
    width: 75%;
    padding-left: 10px;
    padding-right: 10px;
    border: none;
        border-bottom: 2px solid white;
        background: none;
        outline: none;
        box-shadow: none;
        color: white;
  }

  .escrita2 {
    color: rgba(255, 255, 255, 0.808);
    position: absolute;
    margin-left: 34%;
    margin-top: 55%;
    font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
    font-size: 120%;
  }

  .senha2 {
    position: absolute;
    margin-left: -20%;
    margin-top: 65%;
    width: 75%;
    padding-left: 10px;
    padding-right: 10px;
    border: none;
        border-bottom: 2px solid white;
        background: none;
        outline: none;
        box-shadow: none;
        color: white;
  }

  .button {
    position: relative;
    right: 35%;
    top: -50px;
    border-radius: 5px;
    border: none;
    width: 200px;
    height: 50px;
    background-color: #5c79a5;
    color: white;
    font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
    font-size: 120%;
  }

  .button:hover {
    background-color: #404f64de;
  }

  .fundo {
    color: rgba(255, 255, 255, 0.808);
    position: absolute;
    margin-left: -07%;
    font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
    font-size: 120%;
  }

  .fundao {
    position: absolute;
    margin-top: 70%;
    margin-left: 30%;
    width: 600px;
    height: 200px;
  }

  .cada {
    position: absolute;
    margin-top: 03,5%;
    margin-left: 21%;
    font-size: 120%;
  }

  .esq {
    position: absolute;
    margin-top: 9%;
    font-size: 120%;
  }
</style>
</head>
<body>
    <!--<div id="cabe">    
        <img src="./images/logotool.png" id="logo">
        <a href="Index.html"><img src="./images/logo_nome.png" alt="Overlay Image" id="logo_nome"></a>
    </div>-->
    <br><br><br><br>
    <center>
        <div class="caixa">
            <a href="Index.html"><img src="./images/logok2.png" class="lolo"></a>
      <div class="inputs">
      <form action="Login.php" class="form" method="POST">
                <h1 class="escrita">Email</h1>
                <input type="text" class="email" name="email" class="inputs">
                    <h1 class="escrita2">Senha</h1>
                    <input type="password" class="senha2" name="senha" class="inputs">
              
      </div>        
                    <div class="fundao">
                        <button type="submit" class="button" name="submit" value="Enviar">Logar</button>
      </form>
                        <h2 class="fundo">Não possui conta?</h2>
                        <h2 class="cada"><a href="Registro.php">Cadastrar-se</a></h2>
                        <br>
                        <h2 class="esq"><a href="nada">Esqueci minha senha</a></h2>
                    </div>
                   
        </div>
    </center>
</body>
</html>