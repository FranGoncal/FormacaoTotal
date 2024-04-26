<?php 
    session_start();
    if( $_SESSION['nivel'] != "docente" && $_SESSION['nivel'] != "admin" ){
        header("Location: logout.php");
    }
  
    if(isset($_GET['nome'])){
        $_SESSION['nome']=$_GET['nome'];
    }
    
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
        $descricao = $row["descricao"];
    } 
    else {
        echo "Nenhum utilizador encontrado!";
        exit();
    }
  
    //Só antes do fecho das inscrições
    if (isset($_POST['submit'])) {
        $vagas  = $_POST['num_maximo'];
        $data_fecho = $_POST['data_fecho'];
        $criterio = $_POST['criterio_selecao'];
        $descricao = $_POST['descricao'];
        
        if(nVagasValido($vagas)){
            $sql = "UPDATE formacao SET num_maximo='".$vagas."',descricao ='".$descricao."' ,data_fecho='".$data_fecho."', criterio_selecao='".$criterio."' WHERE nome='".$nome."'";
            if ($conn->query($sql) === TRUE) {
                //echo "Dados atualizados com sucesso!";
                echo" <script>alert('Atualizado com sucesso!');</script>";
            } else {
                //echo "Erro ao atualizar os dados: " . $conn->error;
                echo" <script>alert('Atualizado sem sucesso :(!');</script>";
            }
        }
        else {
            echo" <script>alert('Número de vagas inválido!');</script>";
        }
    }

    function nVagasValido($vagas){
        if ($vagas > 0){
            return true;
        }
        return false;
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
        <div class="contorno">
            <div class="caixa" style="min-width: 80%;">
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

                                    Nome da Formação: <th>'.$nome.'<br><br>
                                    Vagas: <input type="text" style="margin-left: 95px;" name="num_maximo" value="'.$vagas.'"><br><br>
                                    Esta Fechado: <th>'.$estadoFormacao.'<br><br>
                                    Data Fecho: <input type="date" style="margin-left: 65px;" name="data_fecho" value="'.$data_fecho.'"><br><br>

                                    Critério Seleção:
                                    <select id="opcoes" name="criterio_selecao" style="margin-left: 35px;">';
                                        
                            if($criterio == "Data Inscrição"){
                                echo'
                                        <option value="Data Inscrição">Data Inscrição</option>
                                        <option value="Ordem Alfabética">Ordem Alfabética</option>
                                        <option value="Maior Idade">Maior Idade</option>
                                        <option value="Menor Idade">Menor Idade</option>';
                            }
                            else if($criterio == "Ordem Alfabética"){
                                echo'
                                        <option value="Ordem Alfabética">Ordem Alfabética</option>
                                        <option value="Data Inscrição">Data Inscrição</option>
                                        <option value="Maior Idade">Maior Idade</option>
                                        <option value="Menor Idade">Menor Idade</option>';
                            }
                            else if($criterio == "Maior Idade"){
                                echo'
                                        <option value="Maior Idade">Maior Idade</option>
                                        <option value="Data Inscrição">Data Inscrição</option>
                                        <option value="Ordem Alfabética">Ordem Alfabética</option>
                                        <option value="Menor Idade">Menor Idade</option>';
                            }
                            else if($criterio == "Menor Idade"){
                                echo'
                                        <option value="Menor Idade">Menor Idade</option>
                                        <option value="Data Inscrição">Data Inscrição</option>
                                        <option value="Ordem Alfabética">Ordem Alfabética</option>
                                        <option value="Maior Idade">Maior Idade</option>';
                            }
                                
                            echo '  </select><br><br>
                                    Docente: <th>'.$responsavel.'
                                    <div style="width: 50%; margin-right: 10px; margin-top: 45px;">
                                        <h5>
                                            Descrição:
                                        </h5>
                                        <textarea id="texto" name="descricao" rows="7" cols="45">'.$descricao.'</textarea>
                                        <br><br>       
                                    </div> 
                                
                                <div style="margin-left: 130px;"><button class="botao" name="submit" type="submit">Atualizar</button></div>
                                <br>
                                </form>';

                            if($data_fecho < date('Y-m-d')){//Caso a dataFecho tenha passado
                                echo '<a href="fechar_formacao.php?nome='.$nome.'&criterio='.$criterio.'&vagas='.$vagas.'"><div style="margin-left: 100px;"><button class="botao" name="fechar">Fechar Formação</button></div></a>';
                            }
                            else{//Caso a dataFecho não tenha passado (cinzento)
                                echo '<div style="margin-left: 100px;"><button class="botao_off" type="submit" onclick="alert(\'A Data limite ainda não passou\')">Fechar Formação</button></div>';
                            }
                                echo '<br>
                                <a href="apagar_formacao.php?nome='.$nome.'"><div style="margin-left: 100px;"><button class="botao_vermelho" name="apagar">Apagar Formação</button></div></a>
                            </div>';
                        }         
                        else{
                            echo '
                            <div id="direita" style="width: 400px; max-width: 450px;padding-top: 60px;padding-bottom: 60px; padding-left: 60px;text-align: left;margin: 6%;">
                                <div>
                                    Nome da Formação: <th>'.$nome.'<br><br>
                                    Vagas: '.$vagas.'<br><br>
                                    Esta Fechado: <th>'.$estadoFormacao.'<br><br>
                                    Data Fecho:'.$data_fecho.'<br><br>
                                    Critério Seleção: '.$criterio.'<br><br>
                                    Docente: <th>'.$responsavel.'<br><br>

                                    <h5>
                                        Descrição:
                                    </h5>
                                    <div style="border: 1px solid #07416b;">'.$descricao.'</div>
                                </div>
                            </div>';

                            echo "<div style='padding: auto;' ><table border='1' style='text-align:center; width: 450px; height: auto; margin: 6%; margin-top:17%'><tr><th>Username</th><th>Nome</th><br><th>Data Nascimento</th></tr>";
                            // Liga a tabela na base de dados
                            $sql = 'SELECT u.username, u.nome, u.data_nasc
                                    FROM utilizador u
                                    JOIN inscricao i ON u.username = i.username
                                    JOIN formacao f ON i.nome = f.nome
                                    WHERE f.nome = "'.$nome.'" AND i.estado = "aceite";';
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
                            
                            echo "</table><br/><div/>";
                            mysqli_close($conn);

                            echo '<br>
                                        <a href="apagar_formacao.php?nome='.$nome.'"><div style="margin-left: 150px;"><button class="botao_vermelho" name="apagar">Apagar Formação</button></div></a>';
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
