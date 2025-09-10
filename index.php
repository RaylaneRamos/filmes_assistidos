<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "filmes_assistidos";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Lógica para adicionar um novo filme
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['titulo'])) {
    $titulo = $conn->real_escape_string($_POST['titulo']);
    $ano = $conn->real_escape_string($_POST['ano']);
    $sql = "INSERT INTO filmes (titulo, ano, assistido) VALUES ('$titulo', '$ano', FALSE)";
    $conn->query($sql);
    header("Location: " . $_SERVER['PHP_SELF']); // Redireciona para evitar reenvio do formulário
    exit();
}

// Lógica para buscar filmes
$sql = "SELECT id, titulo, ano, assistido FROM filmes ORDER BY id DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meus Filmes Assistidos</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Meus Filmes Assistidos</h1>
        
        <form id="form-filme" action="" method="POST">
            <div class="input-group">
                <input type="text" name="titulo" id="titulo" placeholder="Título do Filme" required>
                <input type="number" name="ano" id="ano" placeholder="Ano de Lançamento" min="1888" max="2100">
                <button type="submit">Adicionar Filme</button>
            </div>
        </form>

        <div id="lista-filmes">
            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $class = $row["assistido"] ? 'assistido' : '';
                    echo "<div class='filme-item {$class}' data-id='{$row["id"]}'>";
                    echo "<span><strong>{$row["titulo"]}</strong> ({$row["ano"]})</span>";
                    echo "<button class='btn-assistido' data-assistido='{$row["assistido"]}'>" . ($row["assistido"] ? "Desmarcar" : "Assistido") . "</button>";
                    echo "</div>";
                }
            } else {
                echo "<p class='mensagem-vazia'>Nenhum filme cadastrado ainda.</p>";
            }
            $conn->close();
            ?>
            </div>
    </div>

    <script src="script.js"></script>
</body>
</html>