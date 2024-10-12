<?php
    session_start(); // Inicia a sessão para verificar o tipo de usuário logado

    include('../includes/conecta.php'); // Inclui o arquivo de conexão com o banco de dados

    $isOrganizerLogged = isset($_SESSION['orgid']);
    $isPlayerLogged = isset($_SESSION['playerid']);

    // Consulta SQL otimizada para trazer os eventos e as informações relacionadas
    $queryEventos = "SELECT 
                        e.id_evento,
                        e.nome_evento,
                        e.data_evento,
                        e.regras,
                        j.nome_jogo,
                        o.nome_org,
                        COUNT(i.id_inscricao) AS qtd_participantes,
                        CONCAT(end.rua, ' - ', end.numero, ' - ', end.setor, ' - ', end.cidade, ' - ', end.estado, ' - ', end.pais) AS endereco
                    FROM
                        evento e
                    JOIN
                        jogo j ON e.jogo_id = j.id_jogo
                    JOIN
                        organizador o ON e.organizador_id = o.id_organizador
                    LEFT JOIN
                        inscricao i ON i.evento_id = e.id_evento
                    JOIN 
                        endereco end ON end.evento_id = e.id_evento
                    WHERE
                        e.data_evento >= CURDATE()
                    GROUP BY
                        e.id_evento
                    ORDER BY 
                        e.data_evento ASC";

    // Executa a consulta
    $resultEventos = mysqli_query($conn, $queryEventos);

    // Verifica se a consulta retornou resultados
    if (mysqli_num_rows($resultEventos) > 0) {
        // Armazena os eventos em um array
        $eventos = mysqli_fetch_all($resultEventos, MYSQLI_ASSOC);
    } else {
        $eventos = [];
    }
?>

<!DOCTYPE html>
<html lang="pt-BR" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Monkey Games</title>

    <link rel="stylesheet" href="./css/style_event.css">

    <!-- Importa o CSS do Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Importação dos ícones do Bootstrap Icons (para o ícone de usuário) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        .footerEnd{
            flex-grow: 1;
        }
    </style>
</head>
<body>
    <div class="content-wrapper">
        <header>
            <!-- Barra de navegação -->
            <nav class="navbar navbar-dark navbar-expand-lg bg-dark">
                <div class="container-fluid">
                    <a class="navbar-brand" href="../public/index.php">MONKEY GAMES</a>

                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav ms-auto">
                            <!-- Link para Home -->
                            <li class="nav-item">
                                <a class="nav-link" href="../public/index.php">Home</a>
                            </li>

                            <!-- Link para Eventos caso o jogador esteja logado -->
                            <?php if($isPlayerLogged): ?>
                                <li class="nav-item">
                                    <a class="nav-link" href="../public/event.php">Eventos</a>
                                </li>
                            <?php endif; ?>

                            <!-- Dropdown para Eventos -->
                            <?php if ($isOrganizerLogged): ?>    
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="eventosDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Eventos</a>
                                    <ul class="dropdown-menu" aria-labelledby="eventosDropdown">
                                        <li><a class="dropdown-item" href="../public/register_event.php">Criar Evento</a></li>
                                        <li><a class="dropdown-item" href="../public/event.php">Todos os Eventos</a></li>
                                    </ul>
                                </li>
                            <?php endif; ?>

                            <!-- Dropdown para Ícone de Usuário -->
                            <?php if ($isOrganizerLogged || $isPlayerLogged): ?>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bi bi-person-circle"></i> <!-- Ícone de usuário do Bootstrap Icons -->
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                        <li><a class="dropdown-item" href="../public/myperson.php">Meu Perfil</a></li>
                                        <li><a class="dropdown-item" href="../includes/logout.php">Sair</a></li>
                                    </ul>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
            </nav>
        </header>

        <main>
            <!-- Tabela de eventos -->
            <section class="container mt-5">
                <h2 class="text-center mb-4">Eventos Disponíveis</h2>
                <?php 
                    if (isset($_SESSION['mensagem'])){
                        echo "<p class='alert alert-primary' role='alert' >" . $_SESSION["mensagem"] . "</p>";
                        unset ($_SESSION['mensagem']);
                    }
                ?>

                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Nome do Evento</th>
                            <th>Data do Evento</th>
                            <th>Jogo</th>
                            <th>Organizador</th>
                            <th>Qtd. Participantes</th>
                            <th>Regras</th>
                            <th>Endereço</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($eventos as $evento): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($evento['nome_evento']); ?></td>
                                <td><?php echo date('d/m/Y H:i', strtotime($evento['data_evento'])); ?></td>
                                <td><?php echo htmlspecialchars($evento['nome_jogo']); ?></td>
                                <td><?php echo htmlspecialchars($evento['nome_org']); ?></td>
                                <td><?php echo $evento['qtd_participantes']; ?></td>
                                <td><?php echo substr(htmlspecialchars($evento['regras']), 0, 10); ?>...</td>
                                <td><?php echo substr(htmlspecialchars($evento['endereco']), 0, 20); ?>...</td>
                                <td>
                                    <!-- Verifica se o organizador está logado -->
                                    <?php if ($isOrganizerLogged): ?>
                                        <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#modalView<?php echo $evento['id_evento']; ?>">Visualizar</button>
                                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalEdit<?php echo $evento['id_evento']; ?>">Editar</button>
                                        <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modalDelete<?php echo $evento['id_evento']; ?>">Excluir</button>
                                    <?php elseif ($isPlayerLogged): ?>
                                        <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#modalView<?php echo $evento['id_evento']; ?>">Visualizar</button>
                                        <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#modalSubscribe<?php echo $evento['id_evento']; ?>">Inscrever-se</button>
                                    <?php endif; ?>
                                </td>
                            </tr>

                            <!-- Modais para visualizar, editar, excluir e inscrever-se -->
                            <?php include('modals_event.php'); ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </section>
        </main>

        <div class="footerEnd"></div>

        <!-- Importa o JS do Bootstrap 5 -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

        <?php include('../includes/footer.php'); ?>
    </div>
</body>
</html>
