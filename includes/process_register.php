<!-- Registro do organizador -->

<?php 
    //Conectando ao banco de dados.
    include('../includes/conecta.php');

    //Iniciando a sessão.
    session_start();

    //Recebendo dados do formulário e sanitizando-os
    $username = $_POST['name']; //Recebendo o nome do jogador
    $email = $_POST['email']; //Recebendo o email do jogador
    $phone = $_POST['telefone']; //Telefone do jogador
    $cpf = $_POST['cpf']; //CPF do jogador
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); //Recebendo a senha e criptografando


    //Usando os Prepared Statments no PHP para declarações SQL com segurança |||||| Declarações preparadas
    $stmt = $conn -> prepare("INSERT INTO organizador (nome_org, email_org, telefone_org, cpf_org, senha_org) VALUES (?, ?, ?, ?, ?)");

    //Defininfo o parâmetro de cada variável para a inserção de valores.
    $stmt -> bind_param("ssiis", $username, $email, $phone, $cpf, $password);

    //Se executado terá uma mensagem de Registro concluído.
    if ($stmt -> execute()){
        $_SESSION['mensagem'] = "Registro efetuado com sucesso, seja bem vindo!";
        header("Location: ../includes/adm.php");
    }
    //Se não exibir o erro e tentar novamente.
    else{
        $_SESSION['mensagem'] = "Erro: " . $stmt -> error;
        header("Location: ../includes/adm.php");
    }

    $stmt -> close(); //Encerrando o $stmt (São declarações preparadas)
    $conn -> close(); //Encerrando o $conn (É a conecção com o banco de dados)
?>