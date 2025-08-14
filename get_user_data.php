<?php
header('Content-Type: application/json');
include './db.php';

$data = json_decode(file_get_contents('php://input'), true);
session_start();
$idusrv = $_SESSION['idUser'];


if (!$idusrv) {
    http_response_code(400);
    echo json_encode(['error' => 'ID de usuario no proporcionado']);
    exit;
}

try {
    $stmt = $conn->prepare("SELECT mail, customer_id FROM users WHERE id = ?");
    $stmt->bind_param("i", $idusrv);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        http_response_code(404);
        echo json_encode(['error' => 'Usuario no encontrado']);
        exit;
    }

    $user = $result->fetch_assoc();
    echo json_encode([
        'success' => true,
        'mail' => $user['mail'],
        'customer_id' => $user['customer_id']
    ]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
?>