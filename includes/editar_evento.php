<?php

include('../includes/conecta.php');

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_evento = $_POST['id_evento'];
    $nome_evento = $_POST['nome_evento'];
    $data_evento = $_POST['data_evento'];
    $regras_evento = $_POST['regra_evento'];

    // Dados do endereço
    $rua = $_POST['rua'];
    $numero = $_POST['numero'];
    $setor = $_POST['setor'];
    $cidade = $_POST['cidade'];
    $estado = $_POST['estado'];
    $pais = $_POST['pais'];
    
    // Primeiro, precisamos buscar o endereco_id da tabela evento
    $query = "SELECT en.id_endereco FROM endereco en JOIN evento e ON e.id_evento = en.evento_id WHERE id_evento = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id_evento);
    $stmt->execute();
    $stmt->bind_result($endereco_id);
    $stmt->fetch();
    $stmt->close();

    // Verifica se foi encontrado um endereco_id válido
    if ($endereco_id) {
        // Atualizando os dados do endereço na tabela endereco
        $queryEndereco = "
            UPDATE endereco 
            SET rua = ?, numero = ?, setor = ?, cidade = ?, estado = ?, pais = ? 
            WHERE id_endereco = ?
        ";
        $stmtEndereco = $conn->prepare($queryEndereco);
        $stmtEndereco->bind_param("ssssssi", $rua, $numero, $setor, $cidade, $estado, $pais, $endereco_id);
        $stmtEndereco->execute();
        $stmtEndereco->close();
    }

    // Atualiza o evento
    $sqlEvento = "UPDATE evento SET nome_evento = ?, data_evento = ?, regras = ? WHERE id_evento = ?";
    $stmtEvento = $conn->prepare($sqlEvento);
    $stmtEvento->bind_param("sssi", $nome_evento, $data_evento, $regras_evento, $id_evento);
    $stmtEvento->execute();

    // Redireciona de volta para a página de eventos
    header("Location: ../public/event.php");
    exit();
}
?>