<?php
    session_start(); // Inicia a sessão para verificar o tipo de usuário logado

    include('../includes/conecta.php'); // Inclui o arquivo de conexão com o banco de dados

    $isOrganizerLogged = isset($_SESSION['orgid']);
    $isPlayerLogged = isset($_SESSION['playerid']);

    // Consulta SQL para trazer os eventos e as informações relacionadas
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
                        e.id_evento, e.nome_evento, e.data_evento, e.regras, j.nome_jogo, o.nome_org, endereco
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

    <link rel="stylesheet" href="./css/style_event.css ">

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
                            <?php if(isset($_SESSION['playerid'])): ?>
                                <li class="nav-item">
                                    <a class="nav-link" href="../public/event.php">Eventos</a>
                                </li>
                            <?php endif; ?>

                            <!-- Dropdown para Eventos -->
                            <!-- Exibe "Criar Evento" somente se o organizador estiver logado -->
                            <?php if (isset($_SESSION['orgid'])): ?>    
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="eventosDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        Eventos
                                    </a>
                                    <ul class="dropdown-menu" aria-labelledby="eventosDropdown">
                                        <li><a class="dropdown-item" href="../public/register_event.php">Criar Evento</a></li>
                                        <li><a class="dropdown-item" href="../public/event.php">Todos os Eventos</a></li>
                                    </ul>
                                </li>
                            <?php endif; ?>

                            <!-- Dropdown para Ícone de Usuário -->
                            <?php if (isset($_SESSION['orgid']) || isset($_SESSION['playerid'])): ?>
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


        <main >

            <!-- Tabela de eventos -->
            <section class="container mt-5" class="container flex-grow-1">

                <h2 class="text-center mb-4">Eventos Disponíveis</h2>

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
                                <td>
                                    <?php echo substr(htmlspecialchars($evento['data_evento']), 0, 11); ?>...
                                </td>
                                <td><?php echo htmlspecialchars($evento['nome_jogo']); ?></td>
                                <td><?php echo htmlspecialchars($evento['nome_org']); ?></td>
                                <td><?php echo $evento['qtd_participantes']; ?></td>
                                <td>
                                    <?php echo substr(htmlspecialchars($evento['regras']), 0, 10); ?>...
                                </td>
                                <td>
                                    <?php echo substr(htmlspecialchars($evento['endereco']), 0, 20); ?>...
                                </td>
                                <td>
            
                                    <!-- Verifica se o organizador está logado -->
                                    <?php if (isset($_SESSION['orgid'])): ?>

                                        <!-- Botões para visualizar, editar e excluir -->
                                        <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#modalView<?php echo $evento['id_evento']; ?>">Visualizar</button>

                                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalEdit<?php echo $evento['id_evento']; ?>">Editar</button>

                                        <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modalDelete<?php echo $evento['id_evento']; ?>">Excluir</button>

                                    <?php elseif (isset($_SESSION['playerid'])): ?>

                                        <!-- Jogador logado: Botões de visualizar e inscrever-se -->
                                        <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#modalView<?php echo $evento['id_evento']; ?>">Visualizar</button>

                                        <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#modalSubscribe<?php echo $evento['id_evento']; ?>">Inscrever-se</button>
            
                                    <?php endif; ?>

                                </td>

                            </tr>

                            <!-- Modal de Visualização -->
                            <div class="modal fade" id="modalView<?php echo $evento['id_evento']; ?>" tabindex="-1" aria-labelledby="modalViewLabel<?php echo $evento['id_evento']; ?>" aria-hidden="true">

                                <div class="modal-dialog">

                                    <div class="modal-content">

                                        <div class="modal-header">

                                            <h5 class="modal-title" id="modalViewLabel<?php echo $evento['id_evento']; ?>">Detalhes do Evento</h5>

                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                                        </div>

                                        <div class="modal-body">

                                            <p><strong>Nome do Evento:</strong> <?php echo htmlspecialchars($evento['nome_evento']); ?></p>
                                            <p><strong>Data do Evento:</strong> <?php echo htmlspecialchars($evento['data_evento']); ?></p>
                                            <p><strong>Regras:</strong> <?php echo htmlspecialchars($evento['regras']); ?></p>
                                            <p><strong>Jogo:</strong> <?php echo htmlspecialchars($evento['nome_jogo']); ?></p>
                                            <p><strong>Organizador:</strong> <?php echo htmlspecialchars($evento['nome_org']); ?></p>
                                            <p><strong>Endereço:</strong> <?php echo htmlspecialchars($evento['endereco']); ?></p>
                                            <p><strong>Quantidade de Participantes:</strong> <?php echo $evento['qtd_participantes']; ?></p>

                                        </div>

                                        <div class="modal-footer">

                                            <?php if (isset($_SESSION['playerid'])): ?>
                                                <button type="button" class="btn btn-success">Inscrever-se</button>
                                            <?php endif; ?>

                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>

                                        </div>

                                    </div>

                                </div>
            
                            </div>

                            <!-- Modal de Edição de Evento -->
                            <div class="modal fade" id="modalEdit<?php echo $evento['id_evento']; ?>" tabindex="-1" aria-labelledby="modalEditLabel<?php echo $evento['id_evento']; ?>" aria-hidden="true">

                                <?php

                                    $endereco = $evento['endereco'];

                                    // Usando explode para dividir a string nos diferentes componentes do endereço
                                    $endereco_parts = explode(', ', $endereco);

                                    // Acessando cada parte do endereço
                                    $rua = $endereco_parts[0];
                                    $numero = $endereco_parts[1];
                                    $setor = $endereco_parts[2];
                                    $cidade = $endereco_parts[3];
                                    $estado = $endereco_parts[4];
                                    $pais = $endereco_parts[5];

                                ?>

                                <div class="modal-dialog">

                                    <div class="modal-content">

                                        <form action="../includes/editar_evento.php" method="POST">

                                            <div class="modal-header">

                                                <h5 class="modal-title" id="editEventLabel">Editar Evento</h5>

                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                                            </div>

                                            <div class="modal-body">

                                                <!-- Campo oculto para o ID do evento -->
                                                <input type="hidden" name="id_evento" value="<?php echo $evento['id_evento']; ?>">

                                                <!-- Nome do Evento -->
                                                <div class="mb-3">

                                                    <label for="nome_evento" class="form-label">Nome do Evento</label>

                                                    <input type="text" class="form-control" name="nome_evento" value="<?php echo $evento['nome_evento']; ?>">

                                                </div>

                                                <!-- Data do Evento -->
                                                <div class="mb-3">

                                                    <label for="data_evento" class="form-label">Data do Evento</label>

                                                    <input type="datetime" class="form-control" name="data_evento" value="<?php echo $evento['data_evento']; ?>">

                                                </div>

                                                <!-- Regras do Evento -->
                                                <div class="mb-3">

                                                    <label for="regra_evento" class="form-label">Regras</label>

                                                    <textarea class="form-control" name="regra_evento" rows="5"><?php echo $evento['regras']; ?></textarea>
                                                    
                                                </div>

                                                <!-- Endereço (Rua) -->
                                                <div class="mb-3">
                                                    <label for="rua" class="form-label">Rua</label>
                                                    <input type="text" class="form-control" name="rua" value="<?php echo $rua; ?>" >
                                                </div>

                                                <!-- Endereço (Número) -->
                                                <div class="mb-3">
                                                    <label for="numero" class="form-label">Número</label>
                                                    <input type="text" class="form-control" name="numero" value="<?php echo $numero; ?>" >
                                                </div>

                                                <!-- Endereço (Setor) -->
                                                <div class="mb-3">
                                                    <label for="setor" class="form-label">Setor</label>
                                                    <input type="text" class="form-control" name="setor" value="<?php echo $setor ?>" >
                                                </div>

                                                <!-- Endereço (Cidade) -->
                                                <div class="mb-3">
                                                    <label for="cidade" class="form-label">Cidade</label>
                                                    <input type="text" class="form-control" name="cidade" value="<?php echo $cidade; ?>" >
                                                </div>

                                                <!-- Endereço (Estado) -->
                                                <div class="mb-3">
                                                    <label for="estado" class="form-label">Estado</label>
                                                    <input type="text" class="form-control" name="estado" value="<?php echo $estado; ?>">
                                                </div>

                                                <!-- Endereço (País) -->
                                                <div class="mb-3">
                                                    <label for="pais" class="form-label">País</label>
                                                    <input type="text" class="form-control" name="pais" value="<?php echo $pais; ?>">
                                                </div>

                                            </div>

                                            <div class="modal-footer">

                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>

                                                <button type="submit" class="btn btn-primary">Salvar Alterações</button>

                                            </div>

                                        </form>

                                    </div>

                                </div>

                            </div>
                            
                            <!-- Modal de Exclusão (somente para organizador) -->
                            <div class="modal fade" id="modalDelete<?php echo $evento['id_evento']; ?>" tabindex="-1" aria-labelledby="modalDeleteLabel<?php echo $evento['id_evento']; ?>" aria-hidden="true">

                                <div class="modal-dialog">

                                    <div class="modal-content">

                                        <div class="modal-header">

                                            <h5 class="modal-title" id="modalDeleteLabel<?php echo $evento['id_evento']; ?>">Excluir Evento</h5>

                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                                        </div>

                                        <div class="modal-body">

                                            <p>Tem certeza que deseja excluir o evento <strong><?php echo htmlspecialchars($evento['nome_evento']); ?></strong>?</p>

                                        </div>

                                        <div class="modal-footer">

                                            <form method="POST" action="../includes/delete_event.php">

                                                <input type="hidden" name="id_evento" value="<?php echo $evento['id_evento']; ?>">

                                                <button type="submit" class="btn btn-danger">Excluir</button>

                                            </form>

                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>

                                        </div>

                                    </div>

                                </div>

                            </div>

                            <!-- Modal de Inscrição (somente para jogador) -->
                            <div class="modal fade" id="modalSubscribe<?php echo $evento['id_evento']; ?>" tabindex="-1" aria-labelledby="modalSubscribeLabel<?php echo $evento['id_evento']; ?>" aria-hidden="true">

                                <div class="modal-dialog">

                                    <div class="modal-content">

                                        <div class="modal-header">

                                            <h5 class="modal-title" id="modalSubscribeLabel<?php echo $evento['id_evento']; ?>">Inscrever-se no Evento</h5>

                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                                        </div>

                                        <div class="modal-body">

                                            <p>Tem certeza que deseja se inscrever no evento <strong><?php echo htmlspecialchars($evento['nome_evento']); ?></strong>?</p>

                                        </div>

                                        <div class="modal-footer">

                                            <form method="POST" action="inscrever_evento.php">

                                                <input type="hidden" name="id_evento" value="<?php echo $evento['id_evento']; ?>">

                                                <button type="submit" class="btn btn-success">Inscrever-se</button>

                                            </form>

                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        <?php endforeach; ?>

                    </tbody>

                </table>

            </section>

        </main>

        <div class="footerEnd">

        </div>

        <!-- Importa o JS do Bootstrap 5 -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

        <?php include('../includes/footer.php'); ?>
    </div>
</body>
</html>
