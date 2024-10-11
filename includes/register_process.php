<!-- Registro de jogador -->

<?php 
    //Conectando ao banco de dados.
    include('../includes/conecta.php');

    //Iniciando a sessão.
    session_start();


    //Confirmação de senha
    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        //Pegando as senhas inseridas para verificação
        $password = $_POST['password'];
        $confirmpassword = $_POST['confirmpassword'];

        if ($password !== $confirmpassword){ //Verificando se as duas senhas são as mesmas
            //SESSION recebendo uma definição na parte mensagem.
            $_SESSION['mensagem'] = "Senhas não combinam, tente novamente"; 
            header("Location: ../public/register.php"); //Redirecionando novamente para se registrar
            exit(); //Faz com que não continue o script, não irá mandar os dados para o banco de dados
        }
    }


    //Recebendo dados do formulário e sanitizando-os
    $username = $_POST['name']; //Recebendo o nome do jogador
    $email = $_POST['email']; //Recebendo o email do jogador
    $phone = $_POST['telefone']; //Telefone do jogador
    $cpf = $_POST['cpf']; //CPF do jogador
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); //Recebendo a senha e criptografando


    //Usando os Prepared Statments no PHP para declarações SQL com segurança |||||| Declarações preparadas
    $stmt = $conn -> prepare("INSERT INTO jogador (nome_jogador, email_jogador, telefone_jogador, cpf_jogador, senha_jogador) VALUES (?, ?, ?, ?, ?)");

    //Defininfo o parâmetro de cada variável para a inserção de valores.
    $stmt -> bind_param("ssiis", $username, $email, $phone, $cpf, $password);

    //Se executado terá uma mensagem de Registro concluído.
    if ($stmt -> execute()){
        $_SESSION['mensagem'] = "Registro efetuado com sucesso, seja bem vindo!";
        header("Location: ../public/login.php");
    }
    //Se não exibir o erro e tentar novamente.
    else{
        $_SESSION['mensagem'] = "Erro: " . $stmt -> error;
        header("Location: ../public/register.php");
    }

    $stmt -> close(); //Encerrando o $stmt (São declarações preparadas)
    $conn -> close(); //Encerrando o $conn (É a conecção com o banco de dados)
?>