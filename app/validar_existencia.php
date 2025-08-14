<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include '../db.php'; // Tu conexión

    $campo = $_POST['campo']; // debe ser 'mail' o 'numero'
    $valor = $_POST['valor'];

    // Seguridad: Solo permitir campos válidos
    $camposValidos = ['mail', 'numero'];
    if (!in_array($campo, $camposValidos)) {
        echo json_encode(['existe' => false]);
        exit;
    }

    $stmt = $conn->prepare("SELECT id FROM users WHERE $campo = ? LIMIT 1");
    $stmt->bind_param("s", $valor);
    $stmt->execute();
    $stmt->store_result();

    echo json_encode(['existe' => $stmt->num_rows > 0]);

    $stmt->close();
    $conn->close();
}
