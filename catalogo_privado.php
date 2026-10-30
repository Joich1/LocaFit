<?php
session_start();
include 'config.php';
global $conn;
$user_id = $_SESSION['user_id'];

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meus Produtos</title>

</head>
<body>
    <header>
    </header>
    <div class="container mt-5">
        <h1 class="mb-4">Meus Produtos</h1>
        <div class="row row-cols-1 row-cols-md-3 g-4">
            <?php
            // Buscar produtos do usuário logado
            $sql = "SELECT idprod, nome, descricao, preco, imagem, categoria 
                    FROM produtos 
                    WHERE iduser = ?";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "i", $user_id); // Vincula o ID do usuário logado
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
    
            if (mysqli_num_rows($result) > 0) {
                while ($prod = mysqli_fetch_assoc($result)) {
                    echo '<div class="col">';
                    echo '<div class="card h-100">';
                    echo "<img src='uploads/" . htmlspecialchars($prod['imagem']) . "' alt='" . htmlspecialchars($prod['nome']) . "' class='card-img-top' style='height: 200px; object-fit: cover;'>";
                    echo '<div class="card-body">';
                    echo "<h5 class='card-title'>" . htmlspecialchars($prod['nome']) . "</h5>";
                    echo "<p class='card-text'><strong>Categoria:</strong> " . htmlspecialchars($prod['categoria']) . "</p>";
                    echo "<p class='card-text'><strong>Preço:</strong> R$" . number_format($prod['preco'], 2, ',', '.') . "</p>";
                    echo "<p class='card-text'>" . htmlspecialchars($prod['descricao']) . "</p>";
                    echo "<a href='status_produto.php?idprod=" . $prod['idprod'] . "' class='btn btn-primary'>Ver Status</a>";
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo "<p>Nenhum produto cadastrado ainda.</p>";
            }
    
            mysqli_stmt_close($stmt);
            mysqli_close($conn);
            ?>
        </div>
    </div>
</body>
</html>

