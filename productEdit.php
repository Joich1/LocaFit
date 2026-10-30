<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Mostra os produtos cadastrados
$user_id = $_SESSION['user_id'];
$sql = "SELECT idprod, nome, descricao, preco, imagem, categoria FROM produtos WHERE iduser = $user_id";
$result = $conn->query($sql);

// Edita os produtos cadastrados
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['editID'])) {
    $editID = $_POST['editID'];
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $preco = $_POST['preco'];

    $SqlUpdate = "UPDATE produtos SET nome = '$nome', descricao = '$descricao', preco = '$preco' WHERE idprod = '$editID'";

    if (mysqli_query($conn, $SqlUpdate)) {
        header("Location: productEdit.php");
        exit;
    } else {
        echo "Erro ao atualizar seu produto. Tente novamente mais tarde.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meus Produtos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="main.css">
</head>
<body class="d-flex flex-column vh-100">

<header class="text-center mb-4 mt-3">
    <h1 class="display-3">Meus Produtos</h1>
    <a href="index.php" class="btn btn-secondary">Voltar para a Home</a>
</header>
 <!--NAO TIRA ESSE BOTAO PQ SE NAO O TEMA NAO FICA SALVO-->
 <button style="display: none;" class="dropdown-item" id="toggle-theme-btn">
    <i id="theme-icon" class="bi bi-moon-fill"></i>
</button>
<div class="container-fluid py-5">
<div class="row row-cols-1 row-cols-md-3 g-4">
    <?php if ($result->num_rows > 0): ?>

            <?php while ($produto = $result->fetch_assoc()): ?>
                <div class="col mb-4">
                    <div class="card h-100 shadow-sm align-items-center">
                        <?php if (!empty($produto['imagem'])): ?>
                            <img src="uploads/<?php echo htmlspecialchars($produto['imagem']); ?>" class="card-img-top" style="object-fit: cover;" height="300px" alt="<?php echo htmlspecialchars($produto['nome']); ?>">
                        <?php else: ?>
                            <img src="uploads/default.jpg" class="card-img-top" alt="Imagem padrão">
                        <?php endif; ?>
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title"><?php echo htmlspecialchars($produto['nome']); ?></h5>
                            <p class="card-text"><?php echo nl2br(htmlspecialchars($produto['descricao'])); ?></p>
                            <p class="text-muted">Preço: R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?></p>
                            <p class="text-muted">Categoria: <?php echo htmlspecialchars($produto['categoria']); ?></p>
                            <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editModal<?php echo $produto['idprod']; ?>">Editar</button>
                        </div>
                    </div>
                </div>

                <!-- Modal de Edição -->
                <div class="modal fade" id="editModal<?php echo $produto['idprod']; ?>" tabindex="-1" aria-labelledby="editModalLabel<?php echo $produto['idprod']; ?>" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editModalLabel<?php echo $produto['idprod']; ?>">Editar Produto</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form method="post" action="">
                                    <input type="hidden" name="editID" value="<?php echo $produto['idprod']; ?>">
                                    <div class="mb-3">
                                        <label for="nome" class="form-label">Nome</label>
                                        <input type="text" class="form-control" name="nome" value="<?php echo htmlspecialchars($produto['nome']); ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="descricao" class="form-label">Descrição</label>
                                        <textarea class="form-control" name="descricao" required><?php echo htmlspecialchars($produto['descricao']); ?></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="preco" class="form-label">Preço</label>
                                        <input type="number" step="0.01" class="form-control" name="preco" value="<?php echo $produto['preco']; ?>" required>
                                    </div>
                                    <button type="submit" class="btn btn-warning">Salvar alterações</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    <?php else: ?>
        <p class="text-center">Você ainda não postou nenhum produto.</p>
    <?php endif; ?>
</div>

<footer class="mt-auto">
    <p class="text-center">&copy; LocaFit - 2024 - Todos os direitos reservados</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="main.js"></script>
</body>
</html>