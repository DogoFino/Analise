<?php
    $hostname = "localhost";
    $bancodedados = "felipe";
    $usuario = "root";
    $senha = "";

    $mysql = new mysqli($hostname, $usuario, $senha, $bancodedados);
    if ($mysql->connect_errno) {
        echo "falha ao conectar:(" . $mysql->connect_errno . ")" . $mysql->connect_errno;
    }
    else
        echo "Conectado ao Banco";
?>