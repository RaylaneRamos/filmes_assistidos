<?php
session_start();
if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php");
    exit();
}

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
    $genero = $conn->real_escape_string($_POST['genero']);
    $duracao = $conn->real_escape_string($_POST['duracao']);
    $sinopse = $conn->real_escape_string($_POST['sinopse']);
    $nota = $conn->real_escape_string($_POST['nota']);
    $assistido = isset($_POST['assistido']) ? 1 : 0;
    $favorito = isset($_POST['favorito']) ? 1 : 0;
    
    $sql = "INSERT INTO filmes (titulo, ano, genero, duracao, sinopse, nota, assistido, favorito) VALUES ('$titulo', '$ano', '$genero', '$duracao', '$sinopse', '$nota', '$assistido', '$favorito')";
    $conn->query($sql);
    header("Location: " . $_SERVER['PHP_SELF']);
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
        <header>
            <h1>Meus Filmes Assistidos</h1>
            <div class="usuario-info">
                <span>Olá, <?php echo htmlspecialchars($_SESSION['nome_usuario']); ?>!</span>
                <a href="logout.php" class="btn-logout">Sair</a>
            </div>
        </header>
        
        <form id="form-filme" action="" method="POST">
            <div class="input-group">
                <input type="text" name="titulo" id="titulo" placeholder="Título do Filme" required>
                <input type="number" name="ano" id="ano" placeholder="Ano de Lançamento" min="1888" max="2100">
                <input type="text" name="genero" id="genero" placeholder="Gênero" required>
                <input type="number" name="duracao" id="duracao" placeholder="Duração (min)" min="1" required>
                <input type="text" name="sinopse" id="sinopse" placeholder="Sinopse curta" required>
                <select name="nota" id="nota" required>
                    <option value="">Nota</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select>
                <label><input type="checkbox" name="assistido" id="assistido"> Assistido</label>
                <label><input type="checkbox" name="favorito" id="favorito"> Favorito</label>
                <button type="submit">Adicionar Filme</button>
            </div>
        </form>

        <section id="lista-filmes" class="filmes-grid">
            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $class = $row["assistido"] ? 'assistido' : '';
                    echo "<article class='filme-card {$class}' data-id='{$row["id"]}'>";
                    echo "<div class='filme-info'>";
                    echo "<h2 class='filme-titulo'>{$row["titulo"]}</h2>";
                    echo "<span class='filme-genero'>Gênero</span>";
                    echo "<span class='filme-duracao'>120 min</span>";
                    echo "<p class='filme-sinopse'>Sinopse curta do filme para despertar interesse do usuário.</p>";
                    echo "<div class='filme-avaliacao'>";
                    echo "<span class='estrela'>&#9733;</span>";
                    echo "<span class='estrela'>&#9733;</span>";
                    echo "<span class='estrela'>&#9733;</span>";
                    echo "<span class='estrela'>&#9733;</span>";
                    echo "<span class='estrela'>&#9734;</span>";
                    echo "</div>";
                    echo "<div class='filme-tags'>";
                    echo "<span class='tag assistido'>Assistido</span>";
                    echo "<span class='tag favorito'>Favorito</span>";
                    echo "</div>";
                    echo "<button class='btn-remover' title='Remover' data-id='{$row["id"]}'>&#10006;</button>";
                    echo "</div>";
                    echo "</article>";
                }
            } else {
                echo "<p class='mensagem-vazia'>Nenhum filme cadastrado ainda.</p>";
            }
            $conn->close();
            ?>
        </section>
    </div>

    <script src="script.js"></script>
</body>
</html>