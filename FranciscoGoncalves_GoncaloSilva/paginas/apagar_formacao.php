<?php 
    $nome = $_GET['nome'];

    // Ligar à base de dados
    include '../basedados/basedados.h';


    $sql = "DELETE FROM inscricao WHERE nome = '".$nome."';";

    $retval = mysqli_query($conn , $sql);
    
    //Se der problemas dá o aviso abaixo
    if (mysqli_affected_rows ($conn) == 1){
        echo "<script>
            if(confirm('Apagado Inscricoes sem sucesso!')){
                window.location.href = 'gestao_formacoes.php';
            }
        </script>";
    }


    $sql = "DELETE FROM formacao WHERE nome = '".$nome."';";

    $retval = mysqli_query($conn , $sql);
    
    //Se correr bem dá o aviso abaixo
    if (mysqli_affected_rows ($conn) == 1)
        echo "<script>
            if(confirm('Apagado com sucesso!')){
                window.location.href = 'gestao_formacoes.php';
            }
        </script>";
    //Se der problemas dá o aviso abaixo
    else
        echo "<script>
            if(confirm('Apagado sem sucesso! :(')){
                window.location.href = 'gestao_formacoes.php';
            }
        </script>";

?>