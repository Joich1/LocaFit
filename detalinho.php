<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Detalhes - <?php echo htmlspecialchars($prod['nome'] ?? 'Produto'); ?></title>
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
    <h1 class="display-3 mb-3 text-center">Detalhes do Produto</h1>
    <section class="container py-5">
    <div class="row justify-content-center">
        <?php
        session_start();
        include 'config.php';

        if (isset($_GET['idprod']) && is_numeric($_GET['idprod'])) {
            $prodid = $_GET['idprod'];

            $sql = "SELECT p.idprod, p.iduser, p.nome, p.descricao, p.preco, p.imagem, p.categoria, u.nome AS user_nome, u.imagem AS user_imagem
        FROM produtos p
        JOIN locador u ON p.iduser = u.id
        WHERE p.idprod = $prodid";

            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $prod = $result->fetch_assoc();
                ?>
                <div class="col-md-6">
                    <?php
                    if (!empty($prod['imagem'])) {
                        echo "<img src='uploads/" . htmlspecialchars($prod['imagem']) . "' alt='" . htmlspecialchars($prod['nome']) . "' class='img-fluid rounded shadow-sm'>";
                    }
                    ?>
                </div>
                <div class="col-md-6">
                    <div class="d-flex flex-column justify-content-between h-100">
                        <h1 class="display-4 font-weight-bold mb-3"><?php echo htmlspecialchars($prod['nome']); ?></h1>
                        <p class="fs-5"><strong>Postado por:</strong> <?php echo htmlspecialchars($prod['user_nome']); ?></p>
                        <p class="fs-4 text-success mb-4"><strong>Preço:</strong> R$ <?php echo number_format($prod['preco'], 2, ',', '.'); ?></p>
                        <p class="fs-5 mb-3"><strong>Descrição:</strong></p>
                        <p class="text-muted mb-3"><?php echo nl2br(htmlspecialchars($prod['descricao'])); ?></p>
                        <p class="fs-5"><strong>Categoria:</strong> <?php echo htmlspecialchars($prod['categoria']); ?></p>
                        <button class="btn btn-warning mt-4 w-100">Alugar</button>
                    </div>
                </div>
                <?php
            } else {
                echo "<p class='text-center text-danger'>Produto não encontrado.</p>";
            }
        } else {
            echo "<p class='text-center text-danger'>Produto não especificado ou ID inválido.</p>";
        }
        ?>
    </div>
</section>

    <div class="container text-center">
        <?php
        function addComment($prodid)
        {
            global $conn;

            if (!isset($_SESSION['user_id'])) {
                die("Você precisa estar logado para enviar comentários.");
            }

            $user_id = $_SESSION['user_id'];

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $comment = trim($_POST['comentario']);
                $evaluation = intval($_POST['avaliacao']);

                if ($evaluation < 1 || $evaluation > 5 || empty($comment)) {
                    echo "Preencha os campos corretamente.";
                } else {
                    $query = "INSERT INTO comentarios (idprod, iduser, comentario, avaliacao, data_criacao)
                      VALUES ('$prodid', '$user_id', '$comment', '$evaluation', NOW())";

                    if (mysqli_query($conn, $query)) {
                        echo "Comentário enviado com sucesso!";
                    } else {
                        echo "Erro ao enviar comentário: " . mysqli_error($conn);
                    }
                }
            }

            $query_media = "SELECT AVG(avaliacao) AS media_avaliacao FROM comentarios WHERE idprod = $prodid" ;
            $result_media = mysqli_query($conn, $query_media);
            $media_avaliacao = 0;
            if($result_media && $media = mysqli_fetch_assoc($result_media)){
                $media_avaliacao = $media['media_avaliacao'];
            }

            $query_comentarios = "SELECT comentarios.comentario, comentarios.avaliacao, comentarios.data_criacao, locador.nome
                          FROM comentarios
                          JOIN locador ON comentarios.iduser = locador.id
                          WHERE comentarios.idprod = $prodid
                          ORDER BY comentarios.data_criacao DESC";
            $result_comentarios = mysqli_query($conn, $query_comentarios);

            $query_produto = "SELECT nome, descricao FROM produtos WHERE idprod = $prodid";
            $result_produto = mysqli_query($conn, $query_produto);
            $produto = mysqli_fetch_assoc($result_produto);

            return ['produto' => $produto, 'comentarios' => $result_comentarios, 'media_avaliacao' => $media_avaliacao];
        }

        if (!isset($_GET['idprod'])) {
            die("Produto não especificado, verifique se a variável está correta.");
        }

        $prodid = intval($_GET['idprod']);
        $data = addComment($prodid);
        $produto = $data['produto'];
        $result_comentarios = $data['comentarios'];
        ?>
    </div>

    <form method="post" action="detalinho.php">
    <div class="container py-5">
        <h2 class="text-center display-4 mb-4 font-weight-bold">Deixe seu comentário</h2>
        <div class="text-center">
        <h4>Média de Avaliações: <?php echo number_format($data['media_avaliacao'], 1); ?> ⭐ </h4>
        </div>
        <div class="form-floating mb-4">
            <textarea class="form-control shadow-sm" name="comentarios" rows="4" placeholder="Digite seu comentário" style="height: 150px; resize: none;"></textarea>
        </div>
        
        <div class="mb-4">
            <label class="form-label fs-5" for="avaliacao">Avaliação:</label>
            <select class="form-control shadow-sm" name="avaliacao">
                <option value="1">1 Estrela</option>
                <option value="2">2 Estrelas</option>
                <option value="3">3 Estrelas</option>
                <option value="4">4 Estrelas</option>
                <option value="5">5 Estrelas</option>
            </select>
        </div>
        
        <button class="btn btn-warning mt-3 w-100" type="submit">Enviar</button>
    </div>
</form>

<h2 class="text-center display-4 mt-5">Comentários</h2>
<div class="container rounded py-4 mt-4">
    <?php
    $counter = 0;
    $max = 3;
    if (mysqli_num_rows($result_comentarios) > 0): ?>
        <?php while ($comentario = mysqli_fetch_assoc($result_comentarios)): 
        ?>
            <div class="mt-4">
                <p><strong><?php echo htmlspecialchars($comentario['nome']); ?></strong> - <?php echo htmlspecialchars($comentario['data_criacao']); ?></p>
                <p>Avaliação: <?php echo str_repeat('⭐', $comentario['avaliacao']); ?></p>
                <p><?php echo nl2br(htmlspecialchars($comentario['comentario'])); ?></p>
            </div>
            <hr>
        <?php endwhile; ?>
    <?php else: ?>
        <p class="text-center">Não há comentários ainda.</p>
    <?php endif; ?>
</div>



<section>
    <?php while ($comentario = mysqli_fetch_assoc($result_comentarios)): ?>
        <div class="mt-4">
            <p><strong><?php echo htmlspecialchars($comentario['nome']); ?></strong> - <?php echo htmlspecialchars($comentario['data_criacao']); ?></p>
            <p>Avaliação: <?php echo str_repeat('⭐', $comentario['avaliacao']); ?></p>
            <p><?php echo nl2br(htmlspecialchars($comentario['comentario'])); ?></p>
        </div>
        <hr>
    <?php endwhile; ?>
</section>

    <footer class="mt-auto">
        <p class="text-center">&copyLocaFit - 2024 - todos os direitos reservados</p>
    </footer>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <script src="main.js"></script>  
  
</body>

</html>