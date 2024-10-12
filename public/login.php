<?php session_start(); ?>


<!DOCTYPE html>
<html lang="pt-br" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monkey Games</title>

    <!-- Importa o CSS do Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Importação dos ícones do Bootstrap Icons (para o ícone de usuário) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
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
                
                        <!-- Link para a área do organizador -->
                        <li class="nav-item">
                            <a class="nav-link" href="../public/organizadores.php">Área do Organizador</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="../public/login.php">Login</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="../public/register.php">Registre-se</a>
                        </li>

                    </ul>

                </div>
            
            </div>

        </nav>

    </header>

    <main>

        <section>
        <?php 
            if (isset($_SESSION['mensagem'])) {
                echo "<div class='alert alert-warning' role='alert'>" . $_SESSION['mensagem'] . "</div>";
                unset($_SESSION['mensagem']);
            }
?>  
            <div class="container d-flex justify-content-center align-items-center min-vh-100">

                <div class="card shadow-sm p-4" style="max-width: 400px; width: 100%;">

                    <h3 class="text-center mb-4">Login</h3>

                    <form action="../includes/login_process.php" method="POST">
                        <!-- Campo de email -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        
                        <!-- Campo de senha -->
                        <div class="mb-3">
                            <label for="password" class="form-label">Senha</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>

                        <!-- Botão de login -->
                        <button type="submit" class="btn btn-primary w-100">Entrar</button>
                    </form>

                    <!-- Link para registro -->
                    <div class="text-center mt-3">
                        <p>Não tem uma conta? <a href="../public/register.php">Registre-se</a></p>
                    </div>
                </div>
            </div>

        </section>

    </main>

    <?php include('../includes/footer.php') ?>

</body>
</html>
    