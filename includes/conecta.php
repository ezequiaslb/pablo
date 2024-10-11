<?php
    $host = 'localhost';
    $user = 'root';
    $pass = '';
    $db = 'monkeygames';

    //Conectando com o mySLQ.
    $conn = new mysqli($host, $user, $pass, $db);

    //Verificando saúde da conexão, ou seja, se está conectado ao banco.
    if ($conn -> connect_error) {
        die('Falha na Conexão: '. $conn -> connect_error);
    }

    $conn -> set_charset('utf8');
?>