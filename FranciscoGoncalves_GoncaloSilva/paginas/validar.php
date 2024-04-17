<?php 
    //TODO Verificar o nivel de quem corre o script
    $utilizador = $_GET['utilizador'];
    $nivel = $_GET['nivel'];
    include '../basedados/basedados.h';

    $sql = "UPDATE utilizador SET nivel = '".$nivel."' WHERE username='$utilizador';"; 
    $res = mysqli_query ($conn, $sql);

    header("Location: gerir_utilizadores.php")
?>