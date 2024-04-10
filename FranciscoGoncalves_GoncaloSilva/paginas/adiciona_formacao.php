<?php 
  session_start();
  $mensagem_erro = "";

  $username = $_SESSION['username'];
   
  // Ligar à base de dados
  include '../basedados/basedados.h';
  
  if (isset($_POST["submit"])) {
    $nome  = $_POST['nome'];
    $vagas = $_POST['vagas'];
    $data_fecho = $_POST['data_fecho'];
    $criterio_selecao= $_POST["criterio"];

    $sql = "INSERT INTO formacao (nome, num_maximo, esta_fechada, criterio_selecao, data_Fecho, username) VALUES
    ('".$nome."', '".$vagas."', false, '".$criterio_selecao."', '".$data_fecho."', '".$username."')";
    $retval = mysqli_query($conn, $sql);
            
    if(mysqli_affected_rows($conn) == 1){//INSERT com sucesso
        echo "<script>
                if(confirm('Conta criada com sucesso!')){
                    window.location.href = 'gestao_formacoes.php';
                }
            </script>";
        exit();
    }
    else//INSERT falhou
        $mensagem_erro = '<font color="red">Algo correu mal!!!</font>';
        
  }

  function usernameValido($username, $conn){
    $sql = "SELECT * FROM utilizador WHERE username = '$username'";
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
        <a class="navbar-brand" href="pagina_inicial_adm.php">Formação Total</a>;
      
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">

        <ul class="navbar-nav ms-auto">
          
            <li class="nav-item">
                <a class="nav-link" aria-current="page" href="logout.php">Terminar Sessão</a>
            </li>
            
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
                    <h1>Nova Formação</h1>
                </div>
            </div>

            <div style="min-height: 500px;display: flex;">

                <div id="esquerda" style="width:50%; padding-top: 60px;padding-bottom: 60px;text-align: center;" >
                    <img src="formacao.png" style="width: 200px; height:200px;margin-bottom: 24px;" alt="">
                </div>

                <div id="direita" style="width:50%; padding-top: 60px;padding-bottom: 60px; padding-left: 50px;text-align: left;">
                    
                    <form method="post" action="adiciona_formacao.php">
                        <center><?php echo $mensagem_erro; ?></center>
                        Nome da Formação: <th><input type="text" name="nome"><br><br>
                        Vagas: <input type="number" style="margin-left: 95px;" name="vagas"><br><br>
                        Data de Fecho: <input type="date" name="data_fecho" style="margin-left: 35px;"><br><br>
                        Criterio Seleção<select id="opcoes" name="criterio" style="margin-left: 35px;">
                            <option value="data_inscricao">Data Inscrição</option>
                            <option value="ordem_alfabetica">Ordem Alfabética</option>
                            <option value="maior_idade">Maior Idade</option>
                            <option value="menor_idade">Menor Idade</option>
                        </select>
                        <br><br><br><br>   

                        <div style="margin-left: 100px;"><button class="botao" name="submit" type="submit">Criar</button></div>
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