<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['idUser']) || (int)$_SESSION['tipoUser'] !== 3) {
    http_response_code(403);
    echo json_encode(['error' => true, 'message' => 'No autorizado']);
    exit;
}

require_once('../db.php');

$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['id'])) {
    http_response_code(400);
    echo json_encode(['error' => true, 'message' => 'ID no proporcionado']);
    exit;
}

$id = intval($data['id']);

try {
    // Toggle: Si está activo (1) lo pone inactivo (0) y viceversa
    $stmt = $conn->prepare("UPDATE smoothies SET activo = IF(activo = 1, 0, 1) WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        throw new Exception('Error al cambiar estado');
    }

    $stmt->close();
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => true, 'message' => $e->getMessage()]);
}

$conn->close();
?>
