<?php
session_start();
include('../includes/conecta.php');

if (!isset($_SESSION['playerid'])) {
    die("Acesso negado: você precisa estar logado como jogador para se inscrever em eventos.");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['id_evento']) && is_numeric($_POST['id_evento'])) {
        $id_evento = (int)$_POST['id_evento'];
        $id_jogador = (int)$_SESSION['playerid'];

        $queryVerifica = "SELECT id_inscricao FROM inscricao WHERE jogador_id = ? AND evento_id = ?";
        $stmtVerifica = mysqli_prepare($conn, $queryVerifica);
        mysqli_stmt_bind_param($stmtVerifica, 'ii', $id_jogador, $id_evento);
        mysqli_stmt_execute($stmtVerifica);
        mysqli_stmt_store_result($stmtVerifica);

        if (mysqli_stmt_num_rows($stmtVerifica) > 0) {
            
            $_SESSION['mensagem']= "Você já está inscrito nesse Evento";
            header("Location: ../public/event.php");            
            
            mysqli_stmt_close($stmtVerifica);
            exit;
        }
        mysqli_stmt_close($stmtVerifica);

        $queryInscrever = "INSERT INTO inscricao (jogador_id, evento_id) VALUES (?, ?)";
        $stmtInscrever = mysqli_prepare($conn, $queryInscrever);
        mysqli_stmt_bind_param($stmtInscrever, 'ii', $id_jogador, $id_evento);

        if (mysqli_stmt_execute($stmtInscrever)) {
            $_SESSION['mensagem'] = "Inscrição Realizada, para mais informações acesse a área Meus Eventos";
            header('Location: ../public/event.php?inscricao_sucesso=1');
            exit;
        } else {
            $_SESSION['mensagem']= "Erro ao inscrever no evento: " . mysqli_error($conn);
            header("Location: ../public/event.php");
        }

        mysqli_stmt_close($stmtInscrever);
    } else {
        echo "ID do evento inválido.";
    }
} else {
    echo "Requisição inválida.";
}

mysqli_close($conn);
?>
