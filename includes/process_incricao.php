<!-- Registro do inscricao no evento -->

<?php 
    //Conectando ao banco de dados.
    include('../includes/conecta.php');

    //Iniciando a sessão.
    session_start();

    //Recebendo dados do formulário e sanitizando-os
    

    //Usando os Prepared Statments no PHP para declarações SQL com segurança |||||| Declarações preparadas
    $stmt = $conn -> prepare("INSERT INTO () VALUES ()");

    //Defininfo o parâmetro de cada variável para a inserção de valores.
    $stmt -> bind_param("", $_COOKIE);

    //Se executado terá uma mensagem de Registro concluído.
    if ($stmt -> execute()){
        $_SESSION['mensagem'] = "Inscrito com sucesso";
        header("Location: ../public/event.php");
    }
    //Se não exibir o erro e tentar novamente.
    else{
        $_SESSION['mensagem'] = "Erro: " . $stmt -> error;
        header("Location: ../public/event.php");
    }

    $stmt -> close(); //Encerrando o $stmt (São declarações preparadas)
    $conn -> close(); //Encerrando o $conn (É a conecção com o banco de dados)