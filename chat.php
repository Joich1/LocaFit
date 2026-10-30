<?php
session_start();
include 'config.php';
// eu acho que ta funcionando
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_SESSION['user_id'])) {
        $remetente_id = (int)$_SESSION['user_id'];
        $destinatario_id = (int)$_POST['destinario_id'];
        $mensagem = $_POST['mensagem'];

        $resultado = enviarMensagem($remetente_id, $destinario_id, $mensagem);
        echo '<p style="color:black;">' . htmlspecialchars($resultado) . "</p>";
    } else {
        "<p style='color:red;'> Você precisa estar logado para enviar uma mensagem.</p>";
    }
}
function enviarMensagem($remetente_id, $destinatario_id, $mensagem){
    global $conn;

    if (empty($mensagem)) {
        return "Você deve preencher a mensagem para enviar.";
    }
    $mensagem = addslashes(trim($mensagem));
    $sql = "INSERT INTO mensagens (id_remetente, id_destinatario, mensagem, data_envio) VALUES ('$remetente_id', '$destinatario_id', '$mensagem', NOW())";

    if(mysqli_query($conn, $sql)){
        return "Mensagem enviada.";
    }else{
        return "Erro ao enviar mensagem";
    }
}
function exibirMensagem($usuario_id, $destinatario_id){
    global $conn;
    $destinario_id = (int)$_POST['destinario_id'];

    $sql = "SELECT m.mensagem, m.data_envio, u.nome 
            FROM mensagens m
            JOIN usuarios u ON u.id = m.id_remetente
            WHERE (m.id_remetente = $usuario_id AND m.id_destinatario = $destinatario_id) 
               OR (m.id_remetente = $destinatario_id AND m.id_destinatario = $usuario_id)
            ORDER BY m.data_envio ASC";

    $result = mysqli_query($conn, $sql);

    if($result && mysqli_num_rows($result) > 0 ){
        while($row = mysqli_fetch_assoc($result)){
            echo '<div>';
            echo '<strong>' . htmlspecialchars($row['nome']) . ':</strong>';
            echo '<p>' . htmlspecialchars($row['mensagem']) . '</p>';
            echo '<small>Enviado em: ' . $row['data_envio'] . '</small>';
            echo '</div><hr>';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat privado</title>
</head>
<body>
    <h1>Ainda precisa de um codigo aqui para informar o nome do destinario</h1>    

    <form action="chat.php" method="post">
        <input type="hidden" name="destinario_id" value="<?php echo $destinario_id; ?>">
        <textarea name="mensagem" placeholder="Envie uma mensagem" required></textarea>
        <button type="submit">Enviar mensagem</button>
    </form>
    
    <div>
        <?php
        $usuario_id = $_SESSION['user_id'];
        $destinario_id = $_GET['destinario_id'];
        exibirMensagem($usuario_id, $destinario_id);
        ?>
    </div>
</body>
</html>