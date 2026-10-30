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
                    <a class="nav-link text-warning active" href="catalogo.php">Catálogo de Produtos</a>
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
   
    <h2 class="display-2 text-center fw-semibold">Novos Produtos</h2>

    <div class="container-fluid py-5">
    <div class="row row-cols-1 row-cols-md-3 g-4">


    

        <?php
       include 'config.php';
        

       $sql = "SELECT idprod, iduser, nome, descricao, preco, imagem, categoria FROM produtos";
       $result = $conn->query($sql);

       if ($result->num_rows > 0) {
           while ($prod = $result->fetch_assoc()) {
               echo '<div class="col mb-4">';
               echo '<div class="card h-100 shadow-sm align-items-center">';
               echo "<h2 class='card-title'>" . htmlspecialchars($prod['nome']) . "</h2>";
               echo '<div class="card-body d-flex flex-column">';
               echo "<p class='card-text'><strong>Categoria:</strong> " . htmlspecialchars($prod['categoria']) . "</p>";
               echo "<p class='card-text'><strong>Preço:</strong> R$ " . number_format($prod['preco'], 2, ',', '.') . "</p>";
               if (!empty($prod['imagem'])) {
                   echo "<img class='card-img-top' style='object-fit: contain; height: 300px;' src='uploads/" . htmlspecialchars($prod['imagem']) . "' alt='" . htmlspecialchars($prod['nome']) . "' style='max-width: 150px; height: auto;'>";
               }
               echo '<br><a class="icon-link icon-link-hover" style="--bs-link-hover-color-rgb: 25, 135, 84;"  href="detalinho.php?idprod='. $prod['idprod'] .'">Ver detalhes</a>';
               echo "</div>";
               echo "</div>";
               echo "</div>";
           }
       } else {
           echo "<p>Nenhum produto disponível no momento.</p>";
       }
//trabalha msm piranha
        $conn->close(); 
        ?>

    </div>
    </div>

    <footer class="mt-auto">
    <p class="text-center ">&copyLocaFit - 2024 - todos os direitos reservados</p>
</footer>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
                integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
                crossorigin="anonymous"></script>
            <script src="main.js"></script>
</body>
</html>
