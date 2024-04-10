<?php 
  session_start();

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
        //Validação de que a Sessao esta iniciada, caso não esteja tamos o valor do nivel vazio.
        $nivel = isset($_SESSION['nivel']) ? $_SESSION['nivel'] : "";
        if($nivel =='cliente')
          echo '<a class="navbar-brand" href="pagina_inicial.php">Formação Total</a>';
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
            <a class="nav-link" href="#">Sobre</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Conteúdo da página-->
  <div class="contorno">
    <div class="caixa" style="padding-bottom: 10px; padding-right: 10px; padding-left: 10px; ">
        <br>
        <center>
            <h1>Sobre o Centro de Formações</h1>
        </center>
        <br>
        <div class="descricao">
            <p>Bem-vindo ao Centro de Formações, onde o aprendizado ganha vida!</p>
            <p>Estamos comprometidos em fornecer educação excepcional e oportunidades de desenvolvimento para todos.</p>
            <p>Aqui, você encontrará uma ampla gama de cursos e treinamentos em diversas áreas, incluindo:</p>
            <ul>
                <li>Tecnologia e Desenvolvimento de Software</li>
                <li>Negócios e Empreendedorismo</li>
                <li>Saúde e Bem-Estar</li>
                <li>Artes e Criatividade</li>
            </ul>
            <p>Nossa missão é capacitar indivíduos e empresas com as habilidades necessárias para prosperar em um mundo em constante mudança.</p>
            <p>Seja você um estudante ávido por conhecimento ou uma empresa em busca de aprimoramento profissional para a sua equipe, temos tudo o que você precisa para alcançar seus objetivos.</p>
            <p>Junte-se a nós e embarque nesta jornada emocionante de aprendizado e crescimento!</p>
        </div>
    </div>
</div>


  <!-- Bootstrap JS e dependências -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>