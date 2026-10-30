<?php
session_start();
include 'config.php';

$user_id = $_SESSION['user_id'];

if(!isset($_SESSION['user_id'])){
    echo "<p style='color:red;'> Você precisa estar logado para acessar essa página.";
    header("location: login.php");
    exit;
}

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    if(isset($_POST['email']) && !empty($_POST['email'])){
        $newEmail = $_POST['email'];
        if(!filter_var($newEmail, FILTER_VALIDATE_EMAIL)){
            echo "Insira um e-mail válido.";
        }else{
            $sqlEmail = "UPDATE locador SET email = '$newEmail' WHERE id = $user_id";
            if(mysqli_query($conn, $sqlEmail)){
                echo "Seu E-mail foi alterado com sucesso.";
            }else{
                echo "Erro ao alterar o E-mail";
            }
        }
    }

    if(isset($_POST['senha']) && !empty($_POST['senha'])){
        $newPass = $_POST['senha'];
        if(strlen($newPass) < 6){
            echo "A senha deve ter no mínimo 6 caracteres";
        }else{
            $passHash = password_hash($newPass, PASSWORD_DEFAULT);

            $sqlPass = "UPDATE locador SET senha = '$passHash' WHERE id = $user_id"; 
            if(mysqli_query($conn, $sqlPass)){
                echo "Sua senha foi alterada com sucesso.";
            }else{
                echo "Erro ao alterar a senha.";
            }
        }
    }
    if(isset($_POST['name']) && !empty($_POST['name'])){
        $newName = mysqli_real_escape_string($conn, $_POST['name']);
        $sqlName = "UPDATE locador SET nome = '$newName' WHERE id = $user_id";
        if(mysqli_query($conn, $sqlName)){
            echo "Seu nome foi alterado com sucesso.";
        }else{
            echo "Erro ao alterar o nome.";
        }
    }
}


if (isset($_FILES['photo']) && $_FILES['photo']['error'] === 0) {
    $uploadDir = 'uploads/';
    $photoName = $_FILES['photo']['name'];
    $photoTmpName = $_FILES['photo']['tmp_name'];
    $photoSize = $_FILES['photo']['size'];

    if ($photoSize <= 2 * 1024 * 1024) {
        $photoNewName = uniqid('', true) . "." . pathinfo($photoName, PATHINFO_EXTENSION);
        $photoPath = $uploadDir . $photoNewName;

        if (move_uploaded_file($photoTmpName, $photoPath)) {
            $sqlPhoto = "UPDATE locador SET imagem = '$photoPath' WHERE id = $user_id";
            if (mysqli_query($conn, $sqlPhoto)) {
                echo "Foto alterada com sucesso!";
            } else {
                echo "Erro ao atualizar a foto no banco de dados.";
            }
        } else {
            echo "Erro ao fazer upload da nova imagem.";
        }
    } else {
        echo "A imagem deve ter no máximo 2 MB.";
    }
}


$sqlUser = "SELECT nome, email, imagem, data_criacao FROM locador WHERE id = $user_id";
$result = mysqli_query($conn, $sqlUser);
$user = mysqli_fetch_assoc($result);
?>



<!DOCTYPE html>
<html data-bs-theme="light" lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes do Usuário</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="main.css">
</head>

<body class="d-flex flex-column vh-100">
    <div class="container py-5">
    
        <header class="text-center mb-5 d-flex justify-content-between w-100">
            <a href="index.php" class="btn h-25">Voltar</a>
            <h1 class="display-4 fw-bold">
                Perfil de <?php echo htmlspecialchars($user['nome']); ?>
            </h1>
            
       
        <button id="toggle-theme-btn" style="width: 40px; height: 40px; border-radius: 100%;" class="btn">
            <i id="theme-icon" class="bi bi-moon-fill"></i>
        </button>
    

        </header>
        <section class="row justify-content-center align-items-center mb-5">
            <div class="col-md-4 text-center">
                <img src="<?php echo htmlspecialchars($user['imagem'] ?? 'https://via.placeholder.com/150'); ?>" alt="Foto do usuário"
                    class="img-fluid rounded-circle border shadow" style="width: 200px; height: 200px; object-fit: cover;">
            </div>
            <div class="col-md-6">
                <div class="card shadow p-4">
                    <h2><?php echo htmlspecialchars($user['nome']); ?></h2>
                    <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
                    <p><strong>Data de Cadastro:</strong>
                        <p><?php echo date('d / F / y', strtotime($user['data_criacao'])); ?></p>
                    </p>
                    <p><strong>Senha:</strong> ****</p>
                    <button class="btn btn-warning" onclick="toggleEdit()">Editar Perfil</button>
                </div>
            </div>
        </section>
        <div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editProfileModalLabel">Alterar Dados do Perfil</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="userdetails.php" method="POST" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="name" class="form-label">Alterar Nome</label>
                                <input type="text" id="name" name="name" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Novo E-mail</label>
                                <input type="email" id="email" name="email" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="senha" class="form-label">Nova Senha</label>
                                <input type="password" id="senha" name="senha" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="photo" class="form-label">Alterar Foto</label>
                                <input type="file" id="photo" name="photo" accept="image/*" class="form-control">
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-warning">Alterar Dados</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-center mt-4">
            <a href="logout.php" class="btn btn-danger">Deslogar</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleEdit() {
            const editProfileModal = new bootstrap.Modal(document.getElementById('editProfileModal'));
            editProfileModal.toggle();
        }
    </script>
</body>

</html>

<footer class="mt-auto">
        <p class="text-center">&copyLocaFit - 2024 - todos os direitos reservados</p>
    </footer>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <script src="main.js"></script>
</body>
</html>