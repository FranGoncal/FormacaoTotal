<?php 
    session_start();
    if( $_SESSION['nivel'] != "admin" && $_SESSION['nivel'] != "docente"){
        header("Location: logout.php");
    }

    $nome = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Formação Total</title>
        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- Estilos personalizados -->
        <link rel="stylesheet" href="pagina_inicial.css">
    </head>
    <body>
        <!-- Cabeçalho -->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
            <div class="container">
                <a class="navbar-brand" href="pagina_inicial_adm.php">Formação Total</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <?php
                            if(isset($_SESSION['username'])){//No caso de ter sessao iniciada
                                //Mostra a opcao de terminar sessao
                                echo '  <li class="nav-item">
                                            <a class="nav-link" aria-current="page" href="logout.php">Terminar Sessão</a>
                                        </li>';
                            }
                            else{//No caso de nao ter iniciado sessao
                                //Mostra as opcoes da navbar iniciar sessao e criar conta
                                echo '  <li class="nav-item">
                                            <a class="nav-link" aria-current="page" href="iniciar_sessao.php">Iniciar Sessão</a>
                                        </li>
                                
                                        <li class="nav-item">
                                            <a class="nav-link" aria-current="page" href="criar_conta.php">Criar Conta</a>
                                        </li>';
                            }
                        ?>

                        <li class="nav-item">
                            <a class="nav-link" href="sobre.php">Sobre</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Conteúdo da página-->
        <div class="contorno" >
            
            <div class="caixa" style="max-width: 85%; min-width: 75%;">
            
                <div id="cabecalho" style="display: flex;justify-content: center;align-items: center;">
                    <div class="caixa" style="width: 100%; text-align: center;border: none;margin-top:20px;margin-bottom:20px;">
                            <h1>Formações</h1>
                    </div>
                </div>


                <div style="display: flex ;justify-content: center">
                    <div class="caixa" style="width: 100%; text-align: center;border: none;margin-top:20px;margin-bottom:20px;" >
                        <a href="adiciona_formacao.php"><Button class="botao">+ Adicionar</Button></a>
                    </div>
                    <br><br><br>
                </div>
                
                <div style="display: flex ;justify-content: center">
                    <center><?php
                        // Ligar à base de dados
                        include '../basedados/basedados.h';
                        
                        if(! $conn ){
                            die('Could not connect: ' . mysqli_error($conn)); /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                        }
                        // Cria a tabela
                        echo "<table border='1' style='text-align:center; width: 1000px;'><tr><th>Nome</th><th>Vagas</th><br><th>Inscrições</th><th>Data Fecho</th><th>Critério</th><th>Estado</th></tr>";
                        // Liga a tabela na base de dados
                        $sql = 'SELECT 
                                    f.nome AS nome,
                                    f.data_fecho AS data_fecho,
                                    f.criterio_selecao AS criterio_selecao,
                                    f.esta_fechada AS esta_fechada,
                                    f.num_maximo AS numMax,
                                    COUNT(i.nome) AS numInscricoes
                                FROM 
                                utilizador u
                                JOIN 
                                    formacao f ON u.username = f.username
                                LEFT JOIN 
                                    inscricao i ON f.nome = i.nome
                                WHERE 
                                    u.username = "'.$nome.'"
                                GROUP BY 
                                    f.nome, f.num_maximo;';
                        //Seleciona a base de dados
                        $retval = mysqli_query( $conn, $sql );
                        if(! $retval ){
                            die('Could not get data: ' . mysqli_error($conn));// se não funcionar dá erro
                        }
                        
                        while($row = mysqli_fetch_array($retval)){// vai buscar ha base de dados os dados nela guardada e poem os na tabela	
                            echo "<tr onclick=\"window.location='formacao.php?nome=".$row['nome']."';\" style='cursor:pointer;'>";
                            echo "<td style='width: 10%'>".$row['nome']."</td>";
                            echo "<td style='width: 15%'>".$row['numMax']."</td>";
                            echo "<td style='width: 20%'>".$row['numInscricoes']."</td>";
                            echo "<td style='width: 25%'>".$row['data_fecho']."</td>";
                            echo "<td style='width: 20%'>".$row['criterio_selecao']."</td>";
                            if($row['esta_fechada'])
                            $estado = "Fechada";
                            else
                            $estado = "Aberta";
                            echo "<td style='width: 20%'>".$estado."</td>";
                            echo "</tr>";
                        }
                        
                        echo "</table><br/>";
                        mysqli_close($conn);
                    ?></center>
                </div>
            </div>
        </div>
        
        <!-- Bootstrap JS e dependências -->
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
    </body>
</html>
