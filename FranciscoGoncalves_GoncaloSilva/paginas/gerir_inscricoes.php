<?php 
  session_start();
  if( $_SESSION['nivel'] != "aluno" ){
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
      <a class="navbar-brand" href="pagina_inicial.php">Formação Total</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">

        <ul class="navbar-nav ms-auto">
          
          <?php 
            //
            if(isset($_SESSION['username'])){//No caso de ter sessao iniciada
              //Mostra a opcao de terminar sessao
              echo '<li class="nav-item">
                      <a class="nav-link" aria-current="page" href="logout.php">Terminar Sessão</a>
                    </li>';
            }
            else{//No caso de nao ter iniciado sessao
                  //Mostra as opcoes da navbar iniciar sessao e criar conta
              echo '<li class="nav-item">
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

            <form action="gerir_inscricoes.php" method="post">
                <div style="display: flex ;justify-content: center">
                    <div style="margin-top: 4px; margin-right: 20px;">
                        <?php
                            if(!isset($_POST['option'])){
                                echo '<input type="checkbox" name="option" >';
                            }
                            else{
                                echo '<input type="checkbox" name="option" checked >';
                            }
                        ?>
                        As minhas Formações 
                    </div>
                    
                    <div style="background-color: #cccccc; border-radius: 20px;border: 1px solid #02365c; padding-left: 12px;padding-right: 10px;">
                        <input type="text" name="nome" placeholder="A sua pesquisa..." style="height: 30px;border: 0px;background-color: #dddddd;margin: 2px;">
                        <Button class="botao_cinzento" name="submit" type="submit" style="height: 30px;">Pesquisar</Button>
                    </div>
                    
                </div>
            </form>
            <div style="display: flex ;justify-content: center">
                <center><?php
                    // Ligar à base de dados
                    include '../basedados/basedados.h';
                    
                    if(! $conn ){
                        die('Could not connect: ' . mysqli_error($conn)); /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                    }
                    // Cria a tabela
                    echo "<table border='1' style='text-align:center; width: 1100px;'><tr><th>Nome</th><th>Vagas</th><br><th>Data Fecho</th><th>Critério</th><th>Estado</th><th>Inscricao</th></tr>";
                    // Liga a tabela na base de dados
                    $nome='';
                    if(!isset($_POST['submit'])){ //caso não tenha pesquisado
                        $sql = 'SELECT 
                                    f.nome AS nome,
                                    f.data_fecho AS data_fecho,
                                    f.criterio_selecao AS criterio_selecao,
                                    f.esta_fechada AS esta_fechada,
                                    f.num_maximo AS numMax
                                FROM 
                                    formacao f
                                LEFT JOIN 
                                    inscricao i ON f.nome = i.nome
                                GROUP BY 
                                    f.nome, f.num_maximo;';
                    }
                    else if(isset($_POST['option'])){ //Caso checkbox preenhcida e tenha pesquisado
                        $nome = $_POST['nome'];
                        $sql = 'SELECT 
                                    f.nome AS nome,
                                    f.data_fecho AS data_fecho,
                                    f.criterio_selecao AS criterio_selecao,
                                    f.esta_fechada AS esta_fechada,
                                    f.num_maximo AS numMax
                                FROM 
                                    formacao f
                                LEFT JOIN 
                                    inscricao i ON f.nome = i.nome
                                WHERE
                                    f.nome like "%'.$nome.'%" AND i.username = "'.$_SESSION['username'].'"
                                GROUP BY 
                                    f.nome, f.num_maximo;';
                    }
                    else{ //Caso checkbox não preenhcida e tenha pesquisado
                        $nome = $_POST['nome'];
                        $sql = 'SELECT 
                                    f.nome AS nome,
                                    f.data_fecho AS data_fecho,
                                    f.criterio_selecao AS criterio_selecao,
                                    f.esta_fechada AS esta_fechada,
                                    f.num_maximo AS numMax
                                FROM 
                                    formacao f
                                LEFT JOIN 
                                    inscricao i ON f.nome = i.nome
                                WHERE
                                    f.nome like "%'.$nome.'%"
                                GROUP BY 
                                    f.nome, f.num_maximo;';
                    }


                    //Seleciona a base de dados
                    $retval = mysqli_query( $conn, $sql );
                    if(! $retval ){
                        die('Could not get data: ' . mysqli_error($conn));// se não funcionar dá erro
                    }
                    
                        while($row = mysqli_fetch_array($retval)){// vai buscar ha base de dados os dados nela guardada e poem os na tabela	
                            echo "<tr onclick=\"window.location='dados_formacao.php?nome=".$row['nome']."';\" style='cursor:pointer;'>";
                            echo "<td style='width: 15%'>".$row['nome']."</td>";
                            echo "<td style='width: 15%'>".$row['numMax']."</td>";
                            echo "<td style='width: 15%'>".$row['data_fecho']."</td>";
                            echo "<td style='width: 20%'>".$row['criterio_selecao']."</td>";
                          
                            if($row['esta_fechada'])
                              $estado = "Fechada";
                            else
                              $estado = "Aberta";
                            echo "<td style='width: 20%'>".$estado."</td>";
                          
                          $estado = estadoInscricao($row['nome'], $conn);
                          if( $estado == "aceite" ){
                            echo "<td style='width: 20%'>Aceite</td>";
                          }
                          else if ( $estado == "pendente" ){
                            echo "<td style='width: 20%'>Pendente</td>";
                          }
                          

                            echo "</tr>";
                        }
                    
                    echo "</table><br/>";
                    mysqli_close($conn);
                        
                    function estadoInscricao($nome, $conn){
                      $sql = "SELECT estado
                              FROM inscricao
                              WHERE username = '".$_SESSION['username']."'
                              AND nome = '".$nome."';";

                      $retval = mysqli_query($conn, $sql);
                      if(!$retval ){
                        die('Could not get data: ' . mysqli_error($conn));
                      }
                      if(mysqli_num_rows($retval) == 0)
                        return ;

                      $row = mysqli_fetch_array($retval);
                      return $row['estado'];
                    }

                ?></center>

            </div>
            

        </div>
    </div>
  
  <!-- Bootstrap JS e dependências -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>