<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Filmes Assistidos</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <main class="container login-container">
        <header>
            <h1>Entrar</h1>
        </header>
        <section>
            <form class="form-login" method="POST" action="login.php">
                <div class="input-group">
                    <input type="text" name="usuario" placeholder="Usuário" required>
                </div>
                <div class="input-group">
                    <input type="password" name="senha" placeholder="Senha" required>
                </div>
                <button type="submit" class="btn-adicionar">Entrar</button>
            </form>
            <p class="form-link">Não tem conta? <a href="cadastro.php">Cadastre-se</a></p>
        </section>
    </main>

    <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "filmes_assistidos";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Conexão falhou: " . $conn->connect_error);
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $usuario = $_POST['usuario'];
        $senha = $_POST['senha'];

        $sql = "SELECT senha FROM usuarios WHERE usuario = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $usuario);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($senha_hash);
            $stmt->fetch();
            if (password_verify($senha, $senha_hash)) {
                session_start();
                $_SESSION['usuario'] = $usuario;
                header("Location: index.php");
                exit();
            } else {
                echo "<p style='color:red;'>Senha incorreta.</p>";
            }
        } else {
            echo "<p style='color:red;'>Usuário não encontrado.</p>";
        }
        $stmt->close();
    }
    $conn->close();
    ?>
</body>
</html>
