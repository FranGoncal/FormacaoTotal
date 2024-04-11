<?php 
  session_start();
    if(isset($_GET['nome'])){
        $_SESSION['nome']=$_GET['nome'];
    }

  $mensagem_erro = "";

  $nome = $_SESSION['nome'];
  
  // Ligar à base de dados
  include '../basedados/basedados.h';

  $sql = "SELECT * FROM formacao WHERE nome = '".$nome."'";
  $result = mysqli_query($conn, $sql);

  if (mysqli_num_rows($result) > 0) {
      $row = $result->fetch_assoc();

      $vagas = $row["num_maximo"];
      $esta_fechada = $row["esta_fechada"];
      $criterio = $row["criterio_selecao"];
      $data_fecho = $row["data_fecho"];
      $responsavel = $row["username"];
  } else {
      echo "Nenhum utilizador encontrado!";
      exit();
  }
  
  //Só antes do fecho das inscrições
  if (isset($_POST['submit'])) {        // && $data_fecho < date('Y-m-d')
    $vagas  = $_POST['num_maximo'];
    $data_fecho = $_POST['data_fecho'];
    $criterio = $_POST['criterio_selecao'];
    

    $sql = "UPDATE formacao SET num_maximo='$vagas', data_fecho='".$data_fecho."', criterio_selecao='".$criterio."' WHERE nome='".$nome."'";
    if ($conn->query($sql) === TRUE) {
        //echo "Dados atualizados com sucesso!";
        echo" <script>alert('Atualizado com sucesso!');</script>";
    } else {
        //echo "Erro ao atualizar os dados: " . $conn->error;
        echo" <script>alert('Atualizado sem sucesso :(!');</script>";
    }
    
    //exit();
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
  <link rel="stylesheet" href="pagina_inicial.css">
</head>
<body>
  <!-- Cabeçalho -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
      <?php
        if($_SESSION['nivel']=="cliente")
          echo'<a class="navbar-brand" href="pagina_inicial.php">Formação Total</a>';
        else 
          echo '<a class="navbar-brand" href="pagina_inicial_adm.php">Formação Total</a>';
      ?>
      
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
    <div class="contorno">
        <div class="caixa" style="min-width: 60%;">
            <div id="cabecalho" style="display: flex;justify-content: center;align-items: center;">
                <div class="caixa" style="width: 100%; text-align: center;border: none;margin-top:20px;margin-bottom:20px;">
                    <h1>Dados Formação</h1>
                </div>
            </div>

            <div style="min-height: 500px;display: flex;">

               <?php
                //Escrita do estado da formação dependendo do seu valor boolean (fechada/aberta)
                if ($esta_fechada)
                    $estadoFormacao = "Fechada";
                else
                    $estadoFormacao = "Aberta";



                //Caso a formação esteja aberta
                if (!$esta_fechada){
                    echo '
                    <div id="direita" style="width:100%; padding-top: 60px;padding-bottom: 60px; padding-left: 50px;text-align: left;margin-left: 33%;">
                    <form method="post" action="formacao.php">
                                <center>'.$mensagem_erro.'</center>

                                Nome da Formação: <th>'.$nome.'<br><br>
                                Vagas: <input type="text" style="margin-left: 95px;" name="num_maximo" value="'.$vagas.'"><br><br>
                                Esta Fechado: <th>'.$estadoFormacao.'<br><br>
                                Data Fecho: <input type="date" style="margin-left: 65px;" name="data_fecho" value="'.$data_fecho.'"><br><br>

                                Critério Seleção:<select id="opcoes" name="criterio_selecao" style="margin-left: 35px;">';
                                
                                    if($criterio == "data_inscricao"){
                                        echo'
                                        <option value="data_inscricao">Data Inscrição</option>
                                        <option value="ordem_alfabetica">Ordem Alfabética</option>
                                        <option value="maior_idade">Maior Idade</option>
                                        <option value="menor_idade">Menor Idade</option>';
                                    }
                                    else if($criterio == "ordem_alfabetica"){
                                        echo'
                                        <option value="ordem_alfabetica">Ordem Alfabética</option>
                                        <option value="data_inscricao">Data Inscrição</option>
                                        <option value="maior_idade">Maior Idade</option>
                                        <option value="menor_idade">Menor Idade</option>';
                                    }
                                    else if($criterio == "maior_idade"){
                                        echo'
                                        <option value="maior_idade">maior_idade</option>
                                        <option value="data_inscricao">Data Inscrição</option>
                                        <option value="ordem_alfabetica">Ordem Alfabética</option>
                                        <option value="menor_idade">Menor Idade</option>';
                                    }
                                    else if($criterio == "menor_idade"){
                                        echo'
                                        <option value="menor_idade">Menor Idade</option>
                                        <option value="data_inscricao">Data Inscrição</option>
                                        <option value="ordem_alfabetica">Ordem Alfabética</option>
                                        <option value="maior_idade">Maior Idade</option>';
                                    }
                                    
                                echo '</select><br><br>

                                Docente: <th>'.$responsavel.'<br><br>
                                
                                
                                <div style="margin-left: 130px;"><button class="botao" name="submit" type="submit">Atualizar</button></div>
                                <br>';
            
                                
                                if($data_fecho > date('Y-m-d')){//Caso a dataFecho tenha passado
                                    echo '<div style="margin-left: 100px;"><button class="botao" name="fechar" type="submit">Fechar Formação</button></div>';
                                }else{//Caso a dataFecho não tenha passado (cinzento)
                                    echo '<div style="margin-left: 100px;"><button class="botao_off" type="submit" onclick="alert(\'A Data limite ainda não passou\')">Fechar Formação</button></div>';
                                }
                                
                                    
                            echo '</form>
                            </div>';
                }
                else{
                    echo '
                    <div id="direita" style="width:100%; padding-top: 60px;padding-bottom: 60px; padding-left: 50px;text-align: left;margin: 6%;">
                    <div>
                                <center>'.$mensagem_erro.'</center>
                                Nome da Formação: <th>'.$nome.'<br><br>
                                Vagas: '.$vagas.'<br><br>
                                Esta Fechado: <th>'.$estadoFormacao.'<br><br>
                                Data Fecho:'.$data_fecho.'<br><br>
                                Critério Seleção: '.$criterio.'<br><br>
                                Docente: <th>'.$responsavel.'<br><br>
                    </div>
                    </div>';


                    echo "<table border='1' style='text-align:center; width: 1400px; margin: 6%   ;'><tr><th>Username</th><th>Nome</th><br><th>Data Nascimento</th></tr>";
                    // Liga a tabela na base de dados
                    $sql = 'SELECT u.username, u.nome, u.data_nasc
                            FROM utilizador u
                            JOIN inscricao i ON u.username = i.username
                            JOIN formacao f ON i.nome = f.nome
                            WHERE f.nome = "'.$nome.'" AND i.estado = "aceite";
                            ';
                    //Seleciona a base de dados
                    
                    $retval = mysqli_query( $conn, $sql );
                    if(! $retval ){
                        die('Could not get data: ' . mysqli_error($conn));// se não funcionar dá erro
                    }
                    
                        while($row = mysqli_fetch_array($retval)){// vai buscar ha base de dados os dados nela guardada e poem os na tabela	
                            echo "<tr>";
                            echo "<td style='width: 33%'>".$row['username']."</td>";
                            echo "<td style='width: 34%'>".$row['nome']."</td>";
                            echo "<td style='width: 33%'>".$row['data_nasc']."</td>";
                            echo "</tr>";
                        }
                    
                    echo "</table><br/>";
                    mysqli_close($conn);

                }
                
                    ?>
            </div>     
        </div>
    </div>
  

  <!-- Bootstrap JS e dependências -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
