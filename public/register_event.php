<?php 
    include('../includes/conecta.php');
    session_start(); 

    $listjogos = "SELECT id_jogo, nome_jogo FROM jogo;";
    $result_jogos = mysqli_query($conn, $listjogos);
?>

<!DOCTYPE html>
<html lang="pt-BR" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Monkey Games</title>
    <!-- Importa o CSS do Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Importação dos ícones do Bootstrap Icons (para o ícone de usuário) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

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

    <main>
        <section>

            <div class="container d-flex justify-content-center align-items-center min-vh-100">

                <div class="card shadow-sm p-4" style="max-width: 500px; width: 100%;">

                    <h3 class="text-center mb-4">Criar Evento</h3>

                    <form action="../includes/process_register_event.php" method="POST">

                        <input type="hidden" name="id_organizador" value="<?php $_SESSION['orgid'];?>">
                        
                        <!-- Campo de nome -->
                        <div class="mb-3">
                            <label for="name" class="form-label">Nome do Evento</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>

                        <!-- Campo de data -->
                        <div class="mb-3">
                            <label for="data" class="form-label">Data e hora do evento</label>
                            <input type="datetime" class="form-control" id="data" name="data" required>
                        </div>

                        <!-- Campo de regras -->
                        <div class="mb-3">
                            <label for="regras" class="form-label">Regras</label>
                            <textarea class="form-control" id="regras" name="regras" required maxlength="2000"></textarea>
                        </div>
                        
                        <!-- Campo de jogo -->
                        <div class="mb-3">
                            <label for="jogo" class="form-label">Jogo</label>
                                <select class="form-select bg-dark text-light border-secondary" id="selectOption" required>
                                    <option selected>Selecione um jogo</option>
                                    <?php 
                                        if (mysqli_num_rows($result_jogos) > 0) {
                                            while ($jogo = mysqli_fetch_assoc($result_jogos)) {
                                                echo "<option value=\"{$jogo['id_jogo']}\">{$jogo['nome_jogo']}</option>";
                                            }
                                        } else {
                                            echo "<option value=\"\">Nenhum jogo existente</option>";
                                        }
                                    ?>
                                </select>
                        </div>

                        <!-- Endereço (Rua) -->
                        <div class="mb-3">
                            <label for="rua" class="form-label">Rua</label>
                            <input type="text" class="form-control" name="rua" >
                        </div>

                        <!-- Endereço (Número) -->
                        <div class="mb-3">
                            <label for="numero" class="form-label">Número</label>
                            <input type="text" class="form-control" name="numero" >
                        </div>

                        <!-- Endereço (Setor) -->
                        <div class="mb-3">
                            <label for="setor" class="form-label">Setor</label>
                            <input type="text" class="form-control" name="setor" >
                        </div>

                        <!-- Endereço (Cidade) -->
                        <div class="mb-3">
                            <label for="cidade" class="form-label">Cidade</label>
                            <input type="text" class="form-control" name="cidade" >
                        </div>

                        <!-- Endereço (Estado) -->
                        <div class="mb-3">
                            <label for="estado" class="form-label">Estado</label>
                            <input type="text" class="form-control" name="estado" >
                        </div>

                        <!-- Endereço (País) -->
                        <div class="mb-3">
                            <label for="pais" class="form-label">País</label>
                            <input type="text" class="form-control" name="pais" required>
                        </div>

                        <!-- Botão de registro -->
                        <button type="submit" class="btn btn-primary w-100">Registrar</button>
                    </form>

                </div>
                
            </div>

        </section>
    </main>
    
    <?php include('../includes/footer.php') ?>

</body>
</html>