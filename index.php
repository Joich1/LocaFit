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

?>

<!DOCTYPE html>
<html lang="pt-BR" data-bs-theme="light">

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
    
    <div class="coverer-fluid d-flex justify-content-between py-2">
 
        <a class="navbar-brand bi bi-strava fw-bold" href="index.php" style="font-size: 3rem;" id="title">LocaFit</a>
        
    
        <nav class="d-flex align-items-center text-center">
            <ul class="nav nav-tabs me-3">
                <li class="nav-item">
                    <a class="nav-link active text-warning" aria-current="page" href="index.php">Home</a>
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
                    <a class="nav-link text-warning" href="adicionarprodutos.php">Adicionar Produto</a>
                </li>
            </ul>
        </nav>

       
        <div class="dropdown">
    <a class="dropdown-toggle d-flex align-items-center" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
        <img style="border-radius: 100%;" height="50px" width="50px" src="<?php echo htmlspecialchars($pfp); ?>" alt="Imagem de perfil" class="profile-img me-2">
    </a>
    <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
        <?php  
        include 'config.php';
        global $conn;
        
        if (isset($_SESSION['user_id'])) {
            $user_id = $_SESSION['user_id'];
            echo '<li><a class="dropdown-item" href="userdetails.php">Detalhes da conta</a></li>
        <li><a class="dropdown-item" href="adicionarprodutos.php">Postar produto</a></li>
        <li><a class="dropdown-item" href="productEdit.php">Ver meus produtos</a></li>
        <li><button class="dropdown-item" id="toggle-theme-btn">Alterar tema</button></li>
        <li><a class="dropdown-item" href="contato.php">Contato</a></li>
        <li><a class="dropdown-item text-danger" href="logout.php">Deslogar</a></li>';
            }else{
                echo '<li><a class="dropdown-item" href="login.php">Logar</a></li>
                <li><a class="dropdown-item" href="register.php">Cadastrar</a></li>
                ';
            }
        
        ?>
        
    </ul>
</div>

    </div>
</header>
 <!--NAO TIRA ESSE BOTAO PQ SE NAO O TEMA NAO FICA SALVO-->
<button style="display: none;" class="dropdown-item" id="toggle-theme-btn">
    <i id="theme-icon" class="bi bi-moon-fill"></i>
</button>
   

    <div id="carouselExampleAutoplaying" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="./img/gaemes.jpg" class="d-block w-100" height="450px" width="1920" alt="...">
            </div>
            <div class="carousel-item">
                <img src="./img/tenis.jpg" class="d-block w-100"height="450px" width="1920" alt="...">
            </div>
            <div class="carousel-item">
                <img src="./img/predeiro.jpg" class="d-block w-100"height="450px" width="1920"  alt="...">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleAutoplaying"
            data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleAutoplaying"
            data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
  
            <h2 class="display-2 text-center mt-5"><strong>Ofertas da semana!</strong></h2>
            <div class="container-fluid py-5">
            <div class="row row-cols-2 row-cols-md-3 g-4">
            <div class="col mb-4">
                <div class="card h-100 shadow-sm align-items-center">
                    <img src="img/furadeira.jpg" alt="Furadeira" class="card-img-top"
                        style="object-fit: cover; height: 300px; width: 100%;">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">Furadeira</h5>
                        <p class="card-text">R$30</p>
                        <div class="d-flex justify-content-between align-items-center mt-auto">
                            <button class="btn btn-warning btn-sm">Alugar</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col mb-4">
                <div class="card h-100 shadow-sm align-items-center">
                    <img src="./img/vr.jpg" alt="VR" class="card-img-top img-fluid"
                        style="object-fit: cover; height: 300px; width: 100%;">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">VR</h5>
                        <p class="card-text">R$3000</p>
                        <div class="d-flex justify-content-between align-items-center mt-auto">
                            <button class="btn btn-warning btn-sm">Alugar</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col mb-4">
                <div class="card h-100 shadow-sm align-items-center">
                    <img src="./img/preystation.jpg" alt="Playstation 5" class="card-img-top"
                        style="object-fit: cover; height: 300px; width: 100%;">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">Playstation 5</h5>
                        <p class="card-text">R$150</p>
                        <div class="d-flex justify-content-between align-items-center mt-auto">
                            <button class="btn btn-warning btn-sm">Alugar</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col mb-4">
                <div class="card h-100 shadow-sm align-items-center">
                    <img src="./img/berco.jpg" alt="Berço" class="card-img-top"
                        style="object-fit: cover; height: 300px; width: 100%;">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">Berço</h5>
                        <p class="card-text">R$60</p>
                        <div class="d-flex justify-content-between align-items-center mt-auto">
                            <button class="btn btn-warning btn-sm">Alugar</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col mb-4">
                <div class="card h-100 shadow-sm align-items-center">
                    <img src="./img/escada.jpg" alt="Escada" class="card-img-top"
                        style="object-fit: cover; height: 300px; width: 100%;">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">Escada</h5>
                        <p class="card-text">R$40</p>
                        <div class="d-flex justify-content-between align-items-center mt-auto">
                            <button class="btn btn-warning btn-sm">Alugar</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col mb-4">
                <div class="card h-100 shadow-sm align-items-center">
                    <img src="./img/bicicreta.jpg" alt="Bicicleta" class="card-img-top"
                        style="object-fit: cover; height: 300px; width: 100%;">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">Bicicleta</h5>
                        <p class="card-text">R$90</p>
                        <div class="d-flex justify-content-between align-items-center mt-auto">
                            <button class="btn btn-warning btn-sm">Alugar</button>
                        </div>
                    </div>
                </div>
            </div>
                </div>
            </div>
<footer class="mt-auto">
    <p class="text-center">&copyLocaFit - 2024 - todos os direitos reservados.</p>
</footer>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
                integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
                crossorigin="anonymous"></script>
            <script src="main.js"></script>
</body>

</html>