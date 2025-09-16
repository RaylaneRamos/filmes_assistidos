<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "filmes_assistidos";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    // Para depuração, você pode exibir um erro, mas em produção, é melhor registrar em log.
    http_response_code(500);
    die("Conexão falhou: " . $conn->connect_error);
}

// Garante que a requisição é um POST e que os dados foram enviados
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id']) && isset($_POST['assistido'])) {
    $id = $_POST['id'];
    $assistido = $_POST['assistido'];

    // Converte o valor para o formato booleano que o MySQL entende
    $novo_status = ($assistido === 'true') ? 1 : 0;
    
    // Usando prepared statements para evitar SQL injection (melhor prática)
    $sql = "UPDATE filmes SET assistido = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("ii", $novo_status, $id);
        $stmt->execute();
        
        if ($stmt->affected_rows > 0) {
            http_response_code(200); // OK
            echo json_encode(["message" => "Status atualizado com sucesso"]);
        } else {
            http_response_code(404); // Not Found ou nenhum registro afetado
            echo json_encode(["message" => "Nenhum filme encontrado com o ID fornecido ou status já estava atualizado"]);
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