<?php 
    include('../includes/conecta.php');
    session_start(); 
?>

<!DOCTYPE html>
<html lang="pt-br" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monkey Games</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Importação dos ícones do Bootstrap Icons (para o ícone de usuário) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>

        .carousel-cards{
            margin: auto;
            padding: 0 0;
            width: 95%;
            height: 40vh;
        }
        
        .carousel-cards div img{
            margin: 0 0;
            padding: 0 0;
            width: 100%;
            height: 40vh;
        }

        /* Deixa os indicadores do carrossel brancos */
        .carousel-indicators [data-bs-target] {
            background-color: #fff !important; /* Força os indicadores a ficarem brancos */
        }

        /* Deixa o indicador ativo com um fundo branco */
        .carousel-indicators .active {
            background-color: #fff !important; /* Cor branca no indicador ativo */
        }

        .carousel-inner h5 {
            color: #fff !important;
        }

        .carousel-control-prev-icon,
        .carousel-control-next-icon {
            filter: invert(0) !important; /* Inverte as cores para deixar os ícones brancos */
        }
    </style>
</head>
<body>
    <!-- Importa o JS do Bootstrap 5 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <header>

        <!-- Barra de navegação -->
        <nav class="navbar navbar-dark navbar-expand-lg bg-dark">

            <div class="container-fluid">

                <img src="../public/css/logo.png" alt="" width="6%" >

                <a class="navbar-brand" href="#">MONKEY GAMES</a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarNav">

                    <ul class="navbar-nav ms-auto">

                        <!-- Link para Home -->
                        <li class="nav-item">
                            <a class="nav-link" href="index.php">Home</a>
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

                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="eventosDropdown">
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
                                    <li><a class="dropdown-item" href="perfil.php">Meu Perfil</a></li>
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

        <hr style="color: rgb(173, 216, 230);">

        <section class="carousel-cards" data-bs-theme="dark">

            <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">

                <div class="carousel-indicators">

                    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
                    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
                    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="3" aria-label="Slide 4"></button>
                    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="4" aria-label="Slide 5"></button>
                    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="5" aria-label="Slide 6"></button>

                </div>

                <div class="carousel-inner">

                    <div class="carousel-item active">

                        <img src="../slide/counter-strike.jpg" class="d-block w-100" alt="...">

                        <div class="carousel-caption d-none d-md-block">
                            <h5>Jogos FPS</h5>
                        </div>

                    </div>

                    <div class="carousel-item">

                        <img src="../slide/league-of-legends.jpg" class="d-block w-100" alt="...">

                        <div class="carousel-caption d-none d-md-block">
                            <h5>Jogos Moba</h5>
                        </div>

                    </div>

                    <div class="carousel-item">

                        <img src="../slide/fortnite.jpg" class="d-block w-100" alt="...">

                        <div class="carousel-caption d-none d-md-block">
                            <h5>Jogos Battle Royal</h5>
                        </div>

                    </div>

                    <div class="carousel-item">

                        <img src="../slide/fc-24.jpg" class="d-block w-100" alt="...">

                        <div class="carousel-caption d-none d-md-block">
                            <h5>Jogos de Simuladores</h5>
                        </div>

                    </div>
                    
                    <div class="carousel-item">

                        <img src="../slide/tekken.jpg" class="d-block w-100" alt="...">

                        <div class="carousel-caption d-none d-md-block">
                            <h5>Jogos de Luta</h5>
                        </div>

                    </div>

                    <div class="carousel-item">

                        <img src="../slide/magic-the-gathering-arena.jpg" class="d-block w-100" alt="...">

                        <div class="carousel-caption d-none d-md-block">
                            <h5>Jogos de Cards</h5>
                        </div>

                    </div>

                </div>

                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>

                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>

            </div>

        </section>

        <!-- Section: Alguns Eventos -->
        <section id="featured-events" class="py-5">

            <div class="container">

                <div class="row">

                    <div class="col text-center">
                        <h2>Eventos em Destaque</h2>
                        <p>Confira alguns dos nossos principais eventos!</p>
                    </div>

                </div>

                <div class="row">

                    <?php
                    
                        // Consulta para pegar eventos aleatórios do banco de dados (limite de 3 eventos)
                        $sql = "SELECT id_evento, nome_evento, regras, data_evento FROM evento ORDER BY RAND() LIMIT 3";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {

                            while($row = $result->fetch_assoc()) {
                                echo '<div class="col-md-4">';
                                echo '  <div class="card mb-4 shadow-sm">';
                                echo '    <div class="card-body">';
                                echo '      <h5 class="card-title">' . $row["nome_evento"] . '</h5>';
                                echo '      <p class="card-text">' . substr($row["regras"], 0, 100) . '...</p>';
                                echo '      <p class="card-text"><small class="text-muted">Data: ' . date('d/m/Y', strtotime($row["data_evento"])) . '</small></p>';
                                echo '      <a href="../public/event.php?id=' . $row["id_evento"] . '" class="btn btn-primary">Ver mais detalhes</a>';
                                echo '    </div>';
                                echo '  </div>';
                                echo '</div>';
                            }

                        } else {
                            echo '<p class="text-center">Nenhum evento encontrado.</p>';
                        }
                    ?>

                </div>

                <!-- Botão para ver todos os eventos -->
                <div class="row">

                    <div class="col text-center">
                        <a href="../public/event.php" class="btn btn-secondary btn-lg">Ver todos os eventos</a>
                    </div>

                </div>

            </div>

        </section>

    </main>

    <?php include('../includes/footer.php'); ?>

</body>
</html>