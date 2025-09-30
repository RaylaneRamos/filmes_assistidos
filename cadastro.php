<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro - Filmes Assistidos</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <main class="container login-container">
        <header>
            <h1>Cadastro</h1>
        </header>
        <section>
            <form class="form-login" method="POST" action="cadastro.php">
                <div class="input-group">
                    <input type="text" name="nome" placeholder="Nome" required>
                </div>
                <div class="input-group">
                    <input type="email" name="email" placeholder="E-mail" required>
                </div>
                <div class="input-group">
                    <input type="password" name="senha" placeholder="Senha" required>
                </div>
                <button type="submit" class="btn-adicionar">Cadastrar</button>
            </form>
            <p class="form-link">Já tem conta? <a href="login.php">Entrar</a></p>
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
        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);

        $sql = "INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $nome, $email, $senha);

        if ($stmt->execute()) {
            echo "<p style='color:green; text-align:center;'>Cadastro realizado com sucesso!</p>";
        } else {
            echo "<p style='color:red; text-align:center;'>Erro ao cadastrar: " . $conn->error . "</p>";
        }
        $stmt->close();
    }
    $conn->close();
    ?>
</body>
</html>
