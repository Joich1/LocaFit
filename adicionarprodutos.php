<?php
session_start();
include 'config.php';
global $conn;

if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
$sqlUser = "SELECT nome, email, imagem FROM locador WHERE id = $user_id";
$result = mysqli_query($conn, $sqlUser);
$user = mysqli_fetch_assoc($result);
    $pfp = $user['imagem'];
}     else{
    $pfp = 'https://via.placeholder.com/150';

}





$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  
    $pName = $_POST['pName'];
    $des = $_POST['description'];
    $price = $_POST['price'];
    $cat = $_POST['categoria'];
    $image = $_FILES['imagem'];

    if (!$pName || !$price) {
        die("Nome e preço obrigatórios");

        
    }
    
    $imageName = '';
    if ($image && $image['error'] === UPLOAD_ERR_OK) {
        $imageName = uniqid() . "-" . basename($image['name']);
        $caminho = "uploads/" . $imageName;

        if (!move_uploaded_file($image['tmp_name'], $caminho)) {
            die("Erro ao fazer upload da imagem.");
        }
    }

             $gammybear = "INSERT INTO produtos (nome, descricao, preco, imagem, categoria, iduser) 
                  VALUES ('$pName', '$des', '$price', '$imageName', '$cat', '$user_id')";

#se der erro é daqui até o proximo comentario menos o query do gammybear, e adicionar imagem no produto

                  #até agui pode apagarD menus o gammybear
                  
                  

    if ($conn->query($gammybear) === TRUE) {
        echo "<h2 class='produto'>Produto cadastrado com sucesso!</h2>";
        echo "Redirecionando para o índice...";
        header("location: catalogo.php");
        exit;
    } else {
        echo "Erro ao cadastrar o produto: " . $conn->error;
    }
}



?>



<!DOCTYPE html>
<html lang="pt-br" data-bs-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="main.css">


</head>

<body class="d-flex flex-column vh-100">
<header>
    <div class="container-fluid d-flex justify-content-between py-2">
 
        <a class="navbar-brand bi bi-strava fw-bold" href="index.php" style="font-size: 3rem;" id="title">LocaFit</a>
        
    
        <nav class="d-flex align-items-center text-center">
            <ul class="nav nav-tabs me-3">
                <li class="nav-item">
                    <a class="nav-link text-warning" aria-current="page" href="index.php">Home</a>
                </li>
                <?php
                include 'config.php';
                global $conn;

                if (isset($_SESSION['user_id'])) {
                    $user_id = $_SESSION['user_id'];
                    echo '';
                } else {
                    echo '
                        <li class="nav-item">
                            <a class="nav-link text-warning" href="register.php">Cadastrar</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-warning" href="login.php">Login</a>
                        </li>
                    ';
                }
                ?>
                <li class="nav-item">
                    <a class="nav-link text-warning" href="catalogo.php">Catálogo de Produtos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-warning active" href="adicionarprodutos.php">Adicionar Produto</a>
                </li>
            </ul>
        </nav>

       
        <div class="dropdown">
            <a class="dropdown-toggle d-flex align-items-center" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                <img style="border-radius: 100%;" height="50px" width="50px" src="<?php echo htmlspecialchars($pfp); ?>" alt="Imagem de perfil" class="profile-img me-2">
             
            </a>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                <li><a class="dropdown-item" href="userdetails.php">Detalhes da conta</a></li>
                <li><a class="dropdown-item" href="adicionarprodutos.php">Postar produto</a></li>
                <li><a class="dropdown-item" href="productEdit.php">Ver meus produtos</a></li>
                <li><button class="dropdown-item" id="toggle-theme-btn">Alterar tema</button></li>
                <li><a class="dropdown-item" href="contato.php">Contato</a></li>
                <li><a class="dropdown-item text-danger" href="logout.php">Deslogar</a></li>
            </ul>
        </div>
    </div>
</header>
 <!--NAO TIRA ESSE BOTAO PQ SE NAO O TEMA NAO FICA SALVO-->
<button style="display: none;" class="dropdown-item" id="toggle-theme-btn">
    <i id="theme-icon" class="bi bi-moon-fill"></i> 
</button>
   

        <h2 class="display-2 text-center">Postar Novo Produto</h2>
        <form class="mb-5" action="adicionarprodutos.php" method="POST" enctype="multipart/form-data">


            <div class="container border rounded">
                <div class="mb-3">
                    <label class="form-label" for="nome">Nome do Produto:</label>
                    <input class="form-control" type="text" id="nome" name="pName" required><br>
                </div>

                <div class="mb-3">
                    <label class="form-label" for="descricao">Descrição:</label>
                    <textarea class="form-control" id="descricao" name="description"></textarea><br>
                </div>

                <div class="mb-3">
                    <label class="form-label" for="preco">Preço (R$):</label>
                    <input class="form-control" type="number" step="0.01" id="price" name="price" required><br>
                </div>

                <div class="mb-3">
                    <label class="form-label" for="imagem">Imagem:</label>
                    <input class="form-control" type="file" name="imagem" accept="image/*"><br>
                </div>

                <div class="mb-3">
                    <label class="form-label" for="categoria">Categoria:</label>
                    <select class="form-select" name="categoria" id="categoria">
                        <option value="eletronicos">eletronicos</option>
                        <option value="moda">moda</option>
                        <option value="construcao">construçao</option>
                        <option value="veiculo">veiculo</option>
                        <option value="casa">casa</option>
                    </select><br>
                </div>

                <button class="btn btn-warning mb-2" type="submit">Postar Produto</button>
            </div>

        </form>
        <footer class="mt-auto">
            <p class="text-center ">&copyLocaFi - 2024 - todos os direitos reservados</p>
        </footer>



        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
            crossorigin="anonymous"></script>
        <script src="main.js"></script>
    </body>

</html>