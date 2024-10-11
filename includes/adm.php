<?php include('../includes/conecta.php'); ?>
<?php session_start(); ?>

<!DOCTYPE html>
<html lang="pt-br" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monkey Games</title>
    <link rel="stylesheet" href="../public/css/form_adm.css">

    <!-- Importa o CSS do Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Importação dos ícones do Bootstrap Icons (para o ícone de usuário) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
    <!-- Importa o JS do Bootstrap 5 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


    <header>
        <div class="logo_header">
            <div class="logo">
                <img src="" alt="">
            </div>
            <div class="logo_name">
                <h2>Monkey Games</h2>
            </div>
        </div>
    </header>

    <main>

        <?php if(!isset($_SESSION['admid'])): ?>
            <form action="adm_login.php" method="post">
                <label for="iname">Nome de Adm</label>
                <input type="text" name="name" id="iname" require>

                <label for="ipassword">Senha</label>
                <input type="password" name="password" id="ipassword">

                <button type="submit">Entrar</button>
            </form>
        <?php endif; ?>

        <?php if(isset($_SESSION['admid'])): ?>
            <button class="btn" onclick="openFormOrg()">Cadastrar Organizador</button>

            <div class="form-popup" >
                <form action="../includes/process_register.php" method="post" class="form-container" id="formOrg">
                    <h4>Resgistrar novo organizador</h4>

                    <label for="iname">Nome Organizador</label>
                    <input type="text" name="name" id="iname" required>

                    <label for="iemail">Email</label>
                    <input type="email" name="email" id="iemail" required>

                    <label for="itelefone">Telefone</label>
                    <input type="tel" name="telefone" id="itelefone" required>

                    <label for="icpf">CPF</label>
                    <input type="number" name="cpf" id="icpf" required>

                    <label for="ipassword">Senha</label>
                    <input type="password" name="password" id="ipassword" required>

                    <button type="submit" class="btn">Cadastrar</button>
                    <button type="button" class="btn cancel" onclick="closeFormOrg()">Cancelar</button>
                </form>
            </div>

            <button class="btn" onclick="openFormGame()">Cadastrar Jogo</button>

            <div class="form-popup">
                <form action="../includes/process_register_game.php" method="post" class="form-container" id="formGame">
                    <h4>Resgistrar novo jogo</h4>

                    <label for="iname">Nome Jogo</label>
                    <input type="text" name="name" id="iname" required>

                    <label for="iyear">Ano Lançamento</label>
                    <input type="month" name="year" id="iyear" required>

                    <label for="igenero">Gênero</label>
                    <select name="genero" id="igenero"  required>
                        <option selected disabled value="">Selecione</option>
                        <option value="1">FPS</option>
                        <option value="2">Moba</option>
                        <option value="3">Battle Royal</option>
                        <option value="4">Simulador</option>
                        <option value="5">Luta</option>
                        <option value="6">Card</option>
                    </select>

                    <button type="submit" class="btn">Cadastrar</button>
                    <button type="button" class="btn cancel" onclick="closeFormGame()">Cancelar</button>
                </form>
            </div> 

            <script>
                function openFormGame() {
                    document.getElementById("formGame").style.display = "block";
                }

                function closeFormGame() {
                    document.getElementById("formGame").style.display = "none";
                }
                function openFormOrg() {
                    document.getElementById("formOrg").style.display = "block";
                }

                function closeFormOrg() {
                    document.getElementById("formOrg").style.display = "none";
                }
            </script>
            
            <a href="../includes/logout.php">Sair</a>

        <?php endif; ?>

       
    </main>
    
</body>
</html>