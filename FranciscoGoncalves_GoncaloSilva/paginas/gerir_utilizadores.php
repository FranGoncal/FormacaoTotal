<?php 
    session_start();
    if( $_SESSION['nivel'] != "admin" ){
        header("Location: logout.php");
    }
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
        <link rel="stylesheet" href="folha_css.css">
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
                            <h1>Gestão de Utilizadores</h1>
                    </div>
                </div>

                <div style="display: flex ;justify-content: center">
                    <div class="caixa" style="width: 100%; text-align: center;border: none;margin-top:20px;margin-bottom:20px;" >
                        <a href="adiciona_utilizador.php"><Button class="botao">+ Novo Utilizador</Button></a>
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
                        echo "<table border='1' style='text-align:center; width: 1200px;'><tr><th>Nome</th><th>Username</th><br><th>Data Nascimento</th><th>Nivel</th><th>Editar</th><th>Validar</th></tr>";
                        // Liga a tabela na base de dados
                        $sql = 'SELECT * FROM utilizador ORDER BY nivel ASC;';
                        //Seleciona a base de dados
                        
                        $retval = mysqli_query( $conn, $sql );
                        if(! $retval ){
                            die('Could not get data: ' . mysqli_error($conn));// se não funcionar dá erro
                        }
                        
                        while($row = mysqli_fetch_array($retval)){// vai buscar ha base de dados os dados nela guardada e poem os na tabela	
                            echo "<tr>";
                            echo "<td style='width: 18%'>".$row['nome']."</td>";
                            echo "<td style='width: 18%'>".$row['username']."</td>";
                            echo "<td style='width: 18%'>".$row['data_nasc']."</td>";
                            echo "<td style='width: 18%'>".$row['nivel']."</td>";
                            echo "<td style='width: 12%'><a href='editar_utilizadores.php?utilizador=".$row['username']."'><img src='editar.png' alt='editar' style='width:28px'></a></td>";
                            if($row['nivel']=="pendente"){
                                echo "<td style='width: 12%'>
                                        <a style='margin: 5px' href='validar.php?utilizador=".$row['username']."&nivel=aluno'>
                                            <img src='validarAluno.png' alt='validar aluno' style='width:28px'>
                                        </a>
                                        <a style='margin: 5px' href='validar.php?utilizador=".$row['username']."&nivel=docente'>
                                            <img src='validarDocente.png' alt='validar docente' style='width:28px'>
                                        </a>
                                        <a style='margin: 5px' href='validar.php?utilizador=".$row['username']."&nivel=admin'>
                                            <img src='validarAdm.png' alt='validar adminsitrador' style='width:28px'>
                                        </a>
                                    </td>";
                            }
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
