<?php 
  session_start();
  if( $_SESSION['nivel'] != "admin" ){
    header("Location: logout.php");
  }

    //TODO confirmar se o get ta setado e se não tiver fazer algo quanto a isso

    $utilizador = $_GET['utilizador'];
    
  // Ligar à base de dados
  include '../basedados/basedados.h';

  $sql = "SELECT * FROM utilizador WHERE username = '".$utilizador."'";
  $result = mysqli_query($conn, $sql);

  if (mysqli_num_rows($result) > 0) {
      $row = $result->fetch_assoc();

      $nome = $row["nome"];
      $data_nasc = $row["data_nasc"];
      $nivel = $row["nivel"];
  } else {
      echo "Nenhum utilizador encontrado!";
      exit();
  }
  

  if (isset($_POST['submit'])) {
    $nome  = $_POST['nome'];
    $data_nasc = $_POST['data_nasc'];
    $nivel = $_POST['nivel'];
    

    $sql = "UPDATE utilizador SET nome='$nome', data_nasc='".$data_nasc."', nivel='".$nivel."' WHERE username='".$utilizador."'";
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
        if($_SESSION['nivel']=="aluno")
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
                    <h1>Edição do Utilizador</h1>
                </div>
            </div>

            <div style="min-height: 500px;display: flex;">
<!--------------------------------------------------------------------------------------------------------------------------------->
                <?php
                echo '<div id="direita" style="width:100%; padding-top: 60px;padding-bottom: 60px; padding-left: 50px;text-align: left;margin-left: 33%;">
                    <form method="post" action="editar_utilizadores.php?utilizador='.$utilizador.'">

                                Nome de Utilizador: <th>'.$utilizador.'<br><br>
                                Nome: <input type="text" style="margin-left: 95px;" name="nome" value="'.$nome.'"><br><br>
                                Data de Nascimento: <input type="date" name="data_nasc" value="'.$data_nasc.'"><br><br>
                                Nivel: <input type="text" style="margin-left: 110px;" name="nivel" value="'.$nivel.'"><br><br>
                                
                                <div style="margin-left: 130px;"><button class="botao" name="submit" type="submit">Atualizar</button></div>
                                <br>';
                                    
                            echo '</form>';

                            //a pagina validar.php é usada para apagar a conta, passando o nivel no $_GET
                            if(!($nivel == "apagado")){//Caso a dataFecho tenha passado
                                echo '<a href="validar.php?utilizador='.$utilizador.'&nivel=apagado"><div style="margin-left: 100px;"><button class="botao_vermelho" name="fechar">Apagar Utilizador</button></div></a>';
                            }

                            ?>
                        <!-------------------------------------------------------------------------------------------------------------------->
            </div>     
        </div>
    </div>
  

  <!-- Bootstrap JS e dependências -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
