<?php
    session_start();
    //confirmcao de nivel

    $utilizador = $_GET['utilizador'];

    if(isset($_POST['submit'])){
        $password=$_POST['pass'];
        $confirmacao=$_POST['confirmacao'];
        if($password == $confirmacao){
            // Ligar à base de dados
            include '../basedados/basedados.h';

            $sql = "UPDATE utilizador SET  palavra_passe='".md5($password)."' WHERE username='".$utilizador."'";
            if ($conn->query($sql) === TRUE) {
                echo" <script>alert('Atualizado com sucesso!');</script>";
            } 
            else {
                echo" <script>alert('Atualizado sem sucesso :(!');</script>";
            }
        }
        else{
            echo"<script>
                    if(confirm('As palavras-passe não coincidem!')){
                        window.location.href = 'mudar_pass.php?utilizador=".$utilizador."';
                    }
                </script>";
                
        }
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
            <div class="caixa" style="min-width: 30%;">
                <div id="cabecalho" style="display: flex;justify-content: center;align-items: center;">
                    <div class="caixa" style="width: 100%; text-align: center;border: none;margin-top:20px;margin-bottom:20px;">
                        <h1>Alterar Palavra-Passe</h1>
                    </div>
                </div>

                <form action="mudar_pass.php?<?php echo "utilizador=".$utilizador?>" method="post" style="text-align: center; padding: 100px;">
                    Nova palavra-passe:
                    <input type="password" name="pass" required minlength="8">
                    <br><br>
                    Confirmar palavra-passe:
                    <input type="password" name="confirmacao" required minlength="8">
                    <br><br><br><br>
                    <div><button class="botao" name="submit" type="submit">Atualizar</button></div>
                </form>   
            </div>
        </div>
        
        <!-- Bootstrap JS e dependências -->
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
    </body>
</html>
