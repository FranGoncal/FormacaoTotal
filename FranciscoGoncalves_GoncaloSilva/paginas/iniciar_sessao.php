<?php
    $username = isset($_POST["username"]) ? $_POST["username"] : "";
    $password = isset($_POST["palavra_passe"]) ? $_POST["palavra_passe"] : "";
    
    if( isset($_POST["submit"]) ) {
        // Ligar à base de dados
        include '../basedados/basedados.h';
        
        $sql = "SELECT nivel FROM utilizador WHERE username = '$username' AND palavra_passe = '".md5($password)."'";
        
        $retval = mysqli_query($conn, $sql);
        if(!$retval ){
        die('Could not get data: ' . mysqli_error($conn));
        }

        if(mysqli_num_rows($retval) > 0) {
        $row = mysqli_fetch_assoc($retval);
        if($row) {
            // Password correcta
            ob_start();
            session_start();
            $_SESSION['username']=$username;
            $_SESSION['nivel']=$row['nivel'];
            if($row['nivel']=="aluno")
                header("Location: pagina_inicial.php");
            else if($row['nivel']=="admin" || $row['nivel']=="docente")
                header("Location: pagina_inicial_adm.php");
            else{
                echo"<script>
                        if(confirm('Este acesso não foi autorizado!')){
                            window.location.href = 'logout.php';
                        }
                    </script>";
            }
        } else {
            //Se a $row não contiver um valor 
            echo" <script>alert('Erro ao obter os dados do utilizador! :(');</script>";
        }
        } else {
            //Se não encontrou o username na base de dados com a password correta
            echo" <script>alert('Credenciais incorretas! :(');</script>";
        }
        mysqli_close($conn);
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formação Total - Iniciar Sessão</title>
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
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="#">Iniciar Sessão</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="criar_conta.php">Criar Conta</a>
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
                            <h3 class="text-center">Iniciar Sessão</h3>
                        </div>
                        <div class="card-body">
                            <form action="iniciar_sessao.php" method="post">
                                <div class="mb-3">
                                    <label for="username" class="form-label">Nome de Utilizador</label>
                                    <input required type="username" name="username" class="form-control" id="email" aria-describedby="emailHelp">
                                </div>
                                <div class="mb-3">
                                    <label for="palavra_passe" class="form-label">Palavra Passe</label>
                                    <input required type="password" name="palavra_passe" class="form-control" id="senha">
                                </div>
                                <button type="submit" name="submit" class="btn btn-primary btn-block">Iniciar Sessão</button>
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