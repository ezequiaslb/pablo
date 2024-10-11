<!-- Registro do jogo -->

<?php 
    //Conectando ao banco de dados.
    include('../includes/conecta.php');

    //Iniciando a sessão.
    session_start();

    //Recebendo dados do formulário e sanitizando-os
    $gamename = $_POST['name'];
    $monthYear = $_POST['year'];
    $data = DateTime::createFromFormat('Y-m', $monthYear);
    $gameyear = $data->format('Y'); // Extrai o ano
    $gender = $_POST['genero'];

    //Usando os Prepared Statments no PHP para declarações SQL com segurança |||||| Declarações preparadas
    $stmt = $conn -> prepare("INSERT INTO jogo (nome_jogo, ano_lancamento, genero_id) VALUES (?, ?, ?)");

    //Defininfo o parâmetro de cada variável para a inserção de valores.
    $stmt -> bind_param("sii", $gamename, $gameyear, $gender);

    //Se executado terá uma mensagem de Registro concluído.
    if ($stmt -> execute()){
        $_SESSION['mensagem'] = "Novo jogo adicionado";
        header("Location: ../includes/adm.php");
    }
    //Se não exibir o erro e tentar novamente.
    else{
        $_SESSION['mensagem'] = "Erro: " . $stmt -> error;
        header("Location: ../includes/adm.php");
    }

    $stmt -> close(); //Encerrando o $stmt (São declarações preparadas)
    $conn -> close(); //Encerrando o $conn (É a conecção com o banco de dados)