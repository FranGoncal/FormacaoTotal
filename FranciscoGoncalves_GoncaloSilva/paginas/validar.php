<?php 
    //TODO Verificar o nivel de quem corre o script
    session_start();
    if( $_SESSION['nivel'] != "admin" ){
        header("Location: logout.php");
    }
    
    $utilizador = $_GET['utilizador'];
    $nivel = $_GET['nivel'];
    include '../basedados/basedados.h';

    $sql = "UPDATE utilizador SET nivel = '".$nivel."' WHERE username='$utilizador';"; 
    $res = mysqli_query ($conn, $sql);

    header("Location: gerir_utilizadores.php")
?>