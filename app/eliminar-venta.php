<?php
session_start();
header('Content-Type: application/json');

// Solo admin puede eliminar ventas
if (!isset($_SESSION['idUser']) || !isset($_SESSION['tipoUser'])) {
    http_response_code(401);
    echo json_encode(['error' => true, 'message' => 'No autorizado']);
    exit;
}

if((int)$_SESSION['tipoUser'] !== 3){
    http_response_code(403);
    echo json_encode(['error' => true, 'message' => 'Solo administradores pueden eliminar ventas']);
    exit;
}

require_once('../db.php');

if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(['error' => true, 'message' => 'Error de conexión']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['id'])) {
    http_response_code(400);
    echo json_encode(['error' => true, 'message' => 'ID no proporcionado']);
    exit;
}

$id = intval($data['id']);

try {
    $stmt = $conn->prepare("DELETE FROM ventas WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Venta eliminada']);
    } else {
        throw new Exception('Error al eliminar');
    }

    $stmt->close();
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => true, 'message' => $e->getMessage()]);
}

$conn->close();
?>
