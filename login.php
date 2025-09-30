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
                    <input type="email" name="email" placeholder="Email" required>
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
    session_start();

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "filmes_assistidos";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Conexão falhou: " . $conn->connect_error);
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = $_POST['email'];
        $senha = $_POST['senha'];

        // Buscar usuário pelo email
        $sql = "SELECT id, nome, senha FROM usuarios WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            if (password_verify($senha, $row['senha'])) {
                // Login válido → guardar sessão
                $_SESSION['id_usuario'] = $row['id'];
                $_SESSION['nome_usuario'] = $row['nome'];

                header("Location: index.php");
                exit();
            } else {
                echo "<p style='color:red; text-align:center;'>Senha incorreta.</p>";
            }
        } else {
            echo "<p style='color:red; text-align:center;'>Usuário não encontrado.</p>";
        }
        $stmt->close();
    }
    $conn->close();
    ?>
</body>
</html>
