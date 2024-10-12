<?php
session_start();
include('../includes/conecta.php');

if (!isset($_SESSION['orgid'])) {
    die("Acesso negado: você precisa estar logado como organizador para excluir um evento.");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['id_evento']) && is_numeric($_POST['id_evento'])) {
        $id_evento = (int)$_POST['id_evento'];

        mysqli_begin_transaction($conn);

        try {
            $queryInscricao = "DELETE FROM inscricao WHERE evento_id = ?";
            $stmtInscricao = mysqli_prepare($conn, $queryInscricao);
            mysqli_stmt_bind_param($stmtInscricao, 'i', $id_evento);
            mysqli_stmt_execute($stmtInscricao);
            mysqli_stmt_close($stmtInscricao);

            $queryEndereco = "DELETE FROM endereco WHERE evento_id = ?";
            $stmtEndereco = mysqli_prepare($conn, $queryEndereco);
            mysqli_stmt_bind_param($stmtEndereco, 'i', $id_evento);
            mysqli_stmt_execute($stmtEndereco);
            mysqli_stmt_close($stmtEndereco);

            $queryEvento = "DELETE FROM evento WHERE id_evento = ? AND organizador_id = ?";
            $stmtEvento = mysqli_prepare($conn, $queryEvento);
            mysqli_stmt_bind_param($stmtEvento, 'ii', $id_evento, $_SESSION['orgid']);
            mysqli_stmt_execute($stmtEvento);

            if (mysqli_stmt_affected_rows($stmtEvento) > 0) {
                mysqli_commit($conn);
                header('Location: ../public/event.php?delete_success=1');
                exit;
            } else {
                echo "Erro: Evento não encontrado ou você não tem permissão para excluí-lo.";
            }

            mysqli_stmt_close($stmtEvento);
        } catch (mysqli_sql_exception $exception) {
            mysqli_rollback($conn); 
            echo "Erro ao excluir o evento, endereço e inscrições: " . $exception->getMessage();
        }

    } else {
        echo "ID de evento inválido.";
    }
} else {
    echo "Requisição inválida.";
}

mysqli_close($conn);
?>
