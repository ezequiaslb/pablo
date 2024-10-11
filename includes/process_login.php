<!-- Processo de login do organizador -->

<?php

    //Conectando ao banco de dados e recebendo os dados.
    include('../includes/conecta.php');
    //Recebendo as informações armazenadas em $_SESSION.
    session_start();

    $email = $_POST['email']; //Recebendo o email do login.
    $password = $_POST['password']; //Recebendo a senha do login.
     
    $stmt = $conn->prepare("SELECT nome_org, id_organizador, senha_org FROM organizador WHERE email_org = ?"); //Fazendo a busca de usuários no banco como o email.
    $stmt->bind_param("s", $email);//Dando parâmetro do item que será buscado no caso é do email para fazer login.
    $stmt->execute();//executa a verificação.
    $stmt->store_result();//fazendo o armazenamento da busca dos dados.
       
    //contando as linhas do resultado e verificando a existência de email
    if($stmt->num_rows > 0){
        
        $stmt->bind_result($orgname, $orgid, $passwordhash);
        $stmt->fetch();
            //Descriptografia da senha do banco e compara com a que ele colocou.
            if(password_verify($password, $passwordhash)){

                //$_SESSION é um armazenamento de dados globais com suas devidas posições.
                //Inserindo na posição 'orgname' o valor de nome do usuário.
                $_SESSION['orgname'] = $orgname;

                //Inserindo na posição 'orgid' o valor de id do usuário para verificações futuras.
                $_SESSION['orgid'] = $orgid;

                //Redirecionando o usuário para página inicial, após está com informações corretas.
                header("Location: ../public/index.php");
                //Parando o código.
                exit(); 
            
    }else{
                //Exibindo uma mensagem de erro, usuário não encontrado. Será para o caso de senha não coincidente
                $_SESSION['mensagem'] = "Dados não encontrados, tente novamente";
                
                //Fazer com que o usuário insira os dados de login corretos.
                header("Location: ../public/organizadores.php");
            }
    } else{
        //Exibindo mensagem de erro, email inexistente.
        $_SESSION['mensagem'] = "E-mail não cadastro. Verifique novamente ou faça seu cadastro.";

        //Fazer com que o usuário insira os dados de login corretos.
        header("Location: ../public/organizadores.php");
    }

    $stmt -> close(); //Encerrando o $stmt (São declarações preparadas)
    $conn -> close(); //Encerrando o $conn (É a conecção com o banco de dados)
?>