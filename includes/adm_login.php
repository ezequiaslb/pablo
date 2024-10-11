<!-- Processo de login do adm -->

<?php

    //Conectando ao banco de dados e recebendo os dados.
    include('../includes/conecta.php');
    //Recebendo as informações armazenadas em $_SESSION.
    session_start();

    $name = $_POST['name']; //Recebendo o name do login.
    $password = $_POST['password']; //Recebendo a senha do login.
     
    $stmt = $conn->prepare("SELECT nome_adm, id_adm, senha_adm FROM adm WHERE nome_adm = ?"); //Fazendo a busca de usuários no banco como o nome.
    $stmt->bind_param("s", $name);//Dando parâmetro do item que será buscado no caso é do name para fazer login.
    $stmt->execute();//executa a verificação.
    $stmt->store_result();//fazendo o armazenamento da busca dos dados.
       
    //contando as linhas do resultado e verificando a existência de name
    if($stmt->num_rows > 0){
        
        $stmt->bind_result($admname, $admid, $passwordhash);
        $stmt->fetch();
            //Descriptografia da senha do banco e compara com a que ele colocou.
            if($password == $passwordhash){

                //$_SESSION é um armazenamento de dados globais com suas devidas posições.
                //Inserindo na posição 'admname' o valor de nome do usuário.
                $_SESSION['admname'] = $admname;

                //Inserindo na posição 'admid' o valor de id do usuário para verificações futuras.
                $_SESSION['admid'] = $admid;

                //Redirecionando o usuário para página inicial, após está com informações corretas.
                header("Location: ../includes/adm.php");
                //Parando o código.
                exit(); 
            
    }else{
                //Exibindo uma mensagem de erro, usuário não encontrado. Será para o caso de senha não coincidente
                $_SESSION['mensagem'] = "Dados não encontrados, tente novamente";
                
                //Fazer com que o usuário insira os dados de login corretos.
                header("Location: ../includes/adm.php");
            }
    } else{
        //Exibindo mensagem de erro, name inexistente.
        $_SESSION['mensagem'] = "Dados não encontrados, tente novamente";

        //Fazer com que o usuário insira os dados de login corretos.
        header("Location: ../includes/adm.php");
    }

    $stmt -> close(); //Encerrando o $stmt (São declarações preparadas)
    $conn -> close(); //Encerrando o $conn (É a conecção com o banco de dados)
?>