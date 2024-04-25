<?php
    session_start();
    if( $_SESSION['nivel'] != "docente" || $_SESSION['nivel'] != "admin" ){
        header("Location: logout.php");
    }

    $vagas = $_GET['vagas'];
    $nome = $_GET['nome'];
    $criterio = $_GET['criterio'];

    // Ligar à base de dados
    include '../basedados/basedados.h';


    $sql = "UPDATE formacao SET esta_fechada = TRUE WHERE nome = '".$nome."';";

    if ($conn->query($sql) === TRUE) {
        //echo "Estado atualizado com sucesso!";
        
    } else {
        //echo "Erro ao atualizar os dados: " . $conn->error;
        echo" <script>alert('Ocorreu um erro :(!');</script>";
    }

    //Validar inscricoes
    switch ($criterio) {
        case "Data Inscrição":
                $sql="UPDATE inscricao
                SET estado = 'aceite'
                WHERE nome = '".$nome."' AND username IN (
                    SELECT username
                    FROM (
                        SELECT username
                        FROM inscricao
                        WHERE nome = '".$nome."'
                        ORDER BY data_inscricao
                        LIMIT ".$vagas."
                    ) AS subquery
                );";
            break;
        case "Ordem Alfabética":
            $sql="UPDATE inscricao
                SET estado = 'aceite'
                WHERE nome = '".$nome."' AND username IN (
                    SELECT username
                    FROM (
                        SELECT username
                        FROM inscricao
                        WHERE nome = '".$nome."'
                        ORDER BY (
                            SELECT nome
                            FROM utilizador
                            WHERE utilizador.username = inscricao.username
                        ) ASC
                        LIMIT ".$vagas."
                    ) AS subquery
                );
                ";            
            break;
        case "Maior Idade":
            $sql="UPDATE inscricao
                SET estado = 'aceite'
                WHERE nome = '".$nome."' AND username IN (
                    SELECT username
                    FROM (
                        SELECT username
                        FROM inscricao
                        WHERE nome = '".$nome."'
                        ORDER BY (
                            SELECT data_nasc
                            FROM utilizador
                            WHERE utilizador.username = inscricao.username
                        ) ASC
                        LIMIT ".$vagas."
                    ) AS subquery
                );";            
            break;
        case "Menor Idade":
            $sql="UPDATE inscricao
                SET estado = 'aceite'
                WHERE nome = '".$nome."' AND username IN (
                    SELECT username
                    FROM (
                        SELECT username
                        FROM inscricao
                        WHERE nome = '".$nome."'
                        ORDER BY (
                            SELECT data_nasc
                            FROM utilizador
                            WHERE utilizador.username = inscricao.username
                        ) DESC
                        LIMIT ".$vagas."
                    ) AS subquery
                );"; 
            break;
        default:
            echo" <script>alert('O critério não é válido :(!');</script>";
    }


    if ($conn->query($sql) === TRUE) {
        //echo "Estado atualizado com sucesso!";
        echo" <script>alert('Formação fechada com sucesso! :)');</script>";
    } else {
        //echo "Erro ao atualizar os dados: " . $conn->error;
        echo" <script>alert('Ocorreu um erro :(!');</script>";
    }

    header('Location: formacao.php');
?>