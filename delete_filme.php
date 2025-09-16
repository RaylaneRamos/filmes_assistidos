<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "filmes_assistidos";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    http_response_code(500);
    die("Conexão falhou: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $id = $_POST['id'];

    $sql = "DELETE FROM filmes WHERE id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("i", $id);
        $stmt->execute();
        
        if ($stmt->affected_rows > 0) {
            http_response_code(200); // OK
            echo json_encode(["message" => "Filme removido com sucesso"]);
        } else {
            http_response_code(404);
            echo json_encode(["message" => "Nenhum filme encontrado com o ID fornecido"]);
        }
        $stmt->close();
    } else {
        http_response_code(500);
        echo json_encode(["message" => "Erro na preparação da query: " . $conn->error]);
    }
} else {
    http_response_code(400); // Bad Request
    echo json_encode(["message" => "Requisição inválida"]);
}

$conn->close();
?>