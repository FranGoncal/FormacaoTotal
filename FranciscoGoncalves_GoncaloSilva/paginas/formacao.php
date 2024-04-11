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
  if (isset($_POST['submit']) && $data_fecho < date('Y-m-d')) {
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

  function cursoValido($nome, $conn){
    $sql = "SELECT * FROM formacao WHERE nome = '$nome'";
    $retval = mysqli_query($conn, $sql);
    if(!$retval ){
      die('Could not get data: ' . mysqli_error($conn));
    }
    if(mysqli_num_rows($retval) > 0)
      return false;
    return true;
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
                    <h1>Dados Pessoais</h1>
                </div>
            </div>

            <div style="min-height: 500px;display: flex;">

                <div id="esquerda" style="width:50%; padding-top: 60px;padding-bottom: 60px;text-align: center;" >
                    <img src="user.png" style="width: 200px; height:200px;margin-bottom: 24px;" alt="">
                </div>

                <div id="direita" style="width:50%; padding-top: 60px;padding-bottom: 60px; padding-left: 50px;text-align: left;">
                    
                    <form method="post" action="dados_pessoais.php">
                        <center><?php echo $mensagem_erro; ?></center>
                        Nome de Utilizador: <th><?php echo $_SESSION['username']; ?><br><br>
                        Nome: <input type="text" style="margin-left: 95px;" name="nome" value="<?php echo $nome; ?>"><br><br>
                        Data de Nascimento: <input type="date" name="data_nasc" value="<?php echo $data_nasc; ?>"><br><br><br><br>
                        
                        <div style="margin-left: 100px;"><button class="botao" name="submit" type="submit">Atualizar</button></div>
                        
                    </form>
                </div>




            </div>

          

        </div>
    </div>
  

  <!-- Bootstrap JS e dependências -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
