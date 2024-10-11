<?php
    include('../includes/conecta.php');

    session_start();


    if (!isset($_SESSION['orgid']) || !isset($_SESSION['playerid'])) {
        header('../public/login.php');
        exit();
    }

?>

<!DOCTYPE html>
<html lang="pt-br" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monkey Games</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <header>

        <div class="logo_header">

            <div class="logo">
                <img src="" alt="">
            </div>

            <div class="logo_name">
                <h2>Monkey Games</h2>
            </div>

        </div>

        <nav class="navbar navbar-expand-lg bg-body-tertiary">

            <div class="container-fluid">

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarNavDropdown">

                    <ul class="navbar-nav" >

                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="../public/index.php">Home</a>
                        </li>

                        <?php if (isset($_SESSION['orgid'])): ?>

                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Eventos</a>

                                <ul class="dropdown-menu">

                                    <li><a class="dropdown-item" href="../public/event.php">Todos os eventos</a></li>
                                    <li><a class="dropdown-item" href="">Criar evento</a></li>
                                    <li><a class="dropdown-item" href="../public/">Meus eventos</a></li>

                                </ul>

                            </li>

                        <?php endif; ?>
                        
                        <?php if (isset($_SESSION['playerid'])): ?>

                            <li class="nav-item ">
                                <a class="nav-link" href="../public/event.php">Eventos</a>
                            </li>
                            
                        <?php endif; ?>

                        <?php if (isset($_SESSION['orgid']) || isset($_SESSION['playerid'])): ?>

                            <li class="nav-item dropdown">

                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" >
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-fill" viewBox="0 0 16 16" >
                                        <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6"/>
                                    </svg>
                                </a>

                                <ul class="dropdown-menu">

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
            <div>
                
                    
            </div>
        </section>
    </main>
</body>
</html>