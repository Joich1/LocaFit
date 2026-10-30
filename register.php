<?php
include 'config.php';
function rUser($username, $email, $senha, $photo)
{
    global $conn;

    $hashePass = password_hash($senha, PASSWORD_DEFAULT);
    $query = "SELECT * FROM locador WHERE nome = '$username'";

    $cUser = mysqli_query($conn, "SELECT * FROM locador WHERE nome = '$username' ");
    if (mysqli_num_rows($cUser) > 0) {
        return "<h1 id='ixistente'> Já existe um usuario com esse nome." . "</h1>";
    }
    $cEmail = mysqli_query($conn, "SELECT * FROM locador WHERE email = '$email'");
    if (mysqli_num_rows($cEmail) > 0) {
        echo "<h1 id='ixistente'> Email já cadastrado." . "</h1>";
    }

    $upload = 'uploads/';
    $nPhoto = $_FILES['photo']['name'];
    $tmpnamephoto = $_FILES['photo']['tmp_name'];
    $photo_size = $_FILES['photo']['size'];
    $photo_error = $_FILES['photo']['error'];

    if ($photo_error === 0) {
        if ($photo_size <= 2 * 1024 * 1024) {
            $Newnamephoto = uniqid('', true) . "." . pathinfo($nPhoto, PATHINFO_EXTENSION);
            $photopath = $upload . $Newnamephoto;

            if (move_uploaded_file($tmpnamephoto, $photopath)) {
                $query = "INSERT INTO locador(nome, senha, email, imagem) VALUES ('$username','$hashePass','$email', '$photopath') ";
                if (mysqli_query($conn, $query)) {
                    header("location: login.php");
                    exit();
                } else {
                    echo "Tente novamente mais tarde.";
                    return false;
                }
            } else {
                echo "Erro ao fazer upload.";
            }
        } else {
            echo "Arquivo grande.";
        }
    } else {
        echo "";
    }
}

if (isset($_POST['register'])) {
    $username = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    rUser($username, $email, $senha, $_FILES['photo']);
    header("Location: login.php");
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
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


    <form class="mb-5" method="post" action="register.php" enctype="multipart/form-data">
        <h2 class="display-2 text-center">Crie sua conta</h2>
        <div class="container border border-round mt-5">
            <div class="mb-3">
                <div class="mb-3">
                    <label for="photo" class="form-label">Foto de Perfil</label>
                    <input type="file" class="form-control" id="file-input" name="photo" accept="image/*" required>
                    <div class="container border d-flex justify-content-center mt-2" id="preview">
                        <img class="img text-center" src="#" alt="Prévia da foto de perfil" id="file-preview">
                    </div>
                </div>

            </div>
            <div class="mb-3">
                <label for="name" class="form-label">Nome</label>
                <input type="text" class="form-control" id="exampleInputEmail1" name="nome" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="text" class="form-control" id="exampleInputEmail1" name="email" required>
            </div>
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Senha</label>
                <input type="password" class="form-control" id="exampleInputPassword1" name="senha" required>
           </div>
            <div class="row d-flex justify-content-around">
            </div>
            <div class="mb-3 form-check mt-3">
                <input type="checkbox" class="form-check-input" id="exampleCheck1" required>
                <label class="form-check-label" for="exampleCheck1">Concordo com os termos e condições</label>
            </div>

            <button type="submit" name="register" class="btn btn-warning mb-2">Criar conta</button>
        </div>
    </form>
    <footer class="mt-auto">
        <p class="text-center">&copyLocaFit - 2024 - todos os direitos reservados</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <script src="main.js"></script>
</body>

</html>