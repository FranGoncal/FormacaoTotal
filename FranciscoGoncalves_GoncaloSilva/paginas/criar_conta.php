<?php
  $data_nasc = isset($_POST["data_nasc"]) ? $_POST["data_nasc"] : "";
  $nome = isset($_POST["nome"]) ? $_POST["nome"] : "";
  $username = isset($_POST["username"]) ? $_POST["username"] : "";
  $password = isset($_POST["palavra_passe"]) ? $_POST["palavra_passe"] : "";
  $p_confirmar = isset($_POST["confirmar_senha"]) ? $_POST["confirmar_senha"] : "";
  $mensagem_erro = "";
  
  if(isset($_POST["submit"])) {
    if($p_confirmar === $password){
      
      // Ligar à base de dados
      include '../basedados/basedados.h';
      
      if(usernameValido($username,$conn)){
        $sql = "INSERT INTO utilizador ( username, palavra_passe, nome, data_nasc, nivel) VALUES ('".$username."', '".md5($password)."', '".$nome."', '".$data_nasc."', 'cliente')";
        $retval = mysqli_query($conn, $sql);
        
        if(mysqli_affected_rows($conn) == 1){//INSERT com sucesso
          echo "<script>
                  if(confirm('Conta criada com sucesso!')){
                      window.location.href = 'iniciar_sessao.php';
                  }
              </script>";
          exit();
        }
        else//INSERT falhou
          $mensagem_erro = '<font color="red">Algo correu mal!!!</font>';
      } 
      $mensagem_erro = '<font color="red">Esse nome de utilizador já foi usado!</font>';
    }
    else
      $mensagem_erro = '<font color="red">As palavras-passe não coincidem!</font>';
  }

  //valida se o username já está em uso
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
  <title>Formação Total - Criar Conta</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Estilos personalizados -->
  <link rel="stylesheet" href="pagina_inicial.css">
</head>
<body style="padding-top: 0px;">
  <!-- Cabeçalho -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
      <a class="navbar-brand" href="pagina_inicial.php">Formação Total</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a class="nav-link" aria-current="page" href="iniciar_sessao.php">Iniciar Sessão</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" aria-current="page" href="#">Criar Conta</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="sobre.php">Sobre</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Conteúdo da página-->
  <br><br><br><br><br><br><br>
  <div class="container">
    <div class="row justify-content-center mt-5">
      <div class="col-md-6">
        <div class="card" style="border: 2px solid #5a5959;">
          <div class="card-header">
            <h3 class="text-center">Criar Conta</h3>
          </div>
          <div class="card-body">
            <center><?php echo $mensagem_erro; ?></center>
            <form action="criar_conta.php" method="post">
              <div class="mb-3">
                <label for="nome" class="form-label">Nome</label>
                <input required name="nome" type="text" class="form-control" id="nome">
              </div>
              <div class="mb-3">
                <label for="email" class="form-label">Nome de Utilizador</label>
                <input required type="text"  class="form-control" id="username" name="username" aria-describedby="emailHelp">
              </div>
              <div class="mb-3">
                <label for="senha" class="form-label">Palavra-Passe</label>
                <input required type="password" class="form-control" id="palavra_passe" name="palavra_passe">
              </div>
              <div class="mb-3">
                <label for="confirmar_senha" class="form-label">Confirmar Palavra-Passe</label>
                <input required type="password" class="form-control" id="confirmar_senha" name="confirmar_senha">
              </div>
              <div class="mb-3">
                <label for="data" class="form-label">Data de Nascimento</label>
                <input required type="date" value="2000-01-01" class="form-control" name="data_nasc">
              </div>
              <button type="submit" name="submit" class="btn btn-primary btn-block">Criar Conta</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS e dependências -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
