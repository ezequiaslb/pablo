<?php
    session_start();
    include('../includes/conecta.php'); 

// Verifica se o organizador está logado
if (!isset($_SESSION['orgid'])) {
    die("Você precisa estar logado como organizador para criar eventos.");
}

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $nome_evento = $_POST['nome_evento'];
    $data_evento =$_POST['data_evento'];
    $regras = $_POST['regras'];
    $jogo_id = (int) $_POST['jogo_id'];
    $organizador_id = (int) $_SESSION['orgid'];

    // Inserir o evento na tabela 'evento'
    $query_evento = "INSERT INTO evento (nome_evento, data_evento, regras, jogo_id, organizador_id) 
                     VALUES ('$nome_evento', '$data_evento', '$regras', '$jogo_id', '$organizador_id')";

    if (mysqli_query($conn, $query_evento)) {
        // Obtém o ID do evento recém-criado
        $evento_id = mysqli_insert_id($conn);

        // Inserir o endereço relacionado ao evento
        $rua = $_POST['rua'];
        $numero = $_POST['numero'];
        $setor = $_POST['setor'];
        $cidade = $_POST['cidade'];
        $estado = $_POST['estado'];
        $pais =$_POST['pais'];

        $query_endereco = "INSERT INTO endereco (rua, numero, setor, cidade, estado, pais, evento_id) 
                           VALUES ('$rua', '$numero', '$setor', '$cidade', '$estado', '$pais', '$evento_id')";

        if (mysqli_query($conn, $query_endereco)) {
            // Redireciona para a página de sucesso ou eventos
            header('Location: ../public/event.php?success=1');
            exit;
        } else {
            echo "Erro ao inserir o endereço: " . mysqli_error($conn);
        }
    } else {
        echo "Erro ao inserir o evento: " . mysqli_error($conn);
    }
} else {
    echo "Método inválido.";
}
?>
