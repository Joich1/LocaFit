<?php
include 'config.php';
session_start();
$mensagem = '';

function lUser($email, $senha)
{
    global $conn;

    $query = "SELECT * FROM locador WHERE email = '$email' ";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $email = mysqli_fetch_assoc($result);

        if (password_verify($senha, $email['senha'])) {
            $_SESSION['user_id'] = $email['id'];
            header("location: index.php");
            exit();
        } else {
            return "senha incorreta";
        }
    } else {
        return "email não encontrado";
    }
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $mensagem = lUser($email, $senha);
}
?>


<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Do usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="log.css">
    <link rel="shortcut icon" href="./haha/icone.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="main.css">

</head>

<body class="d-flex flex-column vh-100">
<header class="text-center mb-5 mt-3 d-flex justify-content-between w-100">
<button class="btn" onclick="history.back()">Voltar</button>
           
       
        <button id="toggle-theme-btn" style="width: 40px; height: 40px; border-radius: 100%;" class="btn">
            <i id="theme-icon" class="bi bi-moon-fill"></i>
        </button>
    

        </header>



    <body class="d-flex flex-column vh-100">
        <form class="mb-5" method="post" action="login.php">
            <h2 class="display-2 text-center">Faça o login</h2>
            <div class="container border border-round mt-5">
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="text" class="form-control" id="exampleInputEmail1" name="email" required>
                </div>

                <?php if ($mensagem === "email não encontrado") : ?>
                    <div style="margin-top: 5px;"><?= $mensagem ?></div>
                <?php endif; ?>

                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">Senha</label>
                    <input type="password" class="form-control" id="exampleInputPassword1" name="senha" required>
                </div>

                <?php if ($mensagem === "Senha incorreta") : ?>
                    <div style="color: red;"><?= $mensagem ?></div>
                <?php endif; ?>

                <button class="btn btn-warning mb-2" type="submit" name="Logar">Logar</button>

                <label>Não possui uma conta? cadastre já</label>
                <a href="register.php">Cadastrar</a>
        </form>
        </div>
        <footer class="mt-auto">
            <p class="text-center">&copyLocaFit - 2024 - todos os direitos reservados</p>
        </footer>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
            crossorigin="anonymous"></script>
        <script src="main.js"></script>
    </body>

</html>