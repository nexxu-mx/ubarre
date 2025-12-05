<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['idUser']) || (int)$_SESSION['tipoUser'] !== 3) {
    http_response_code(403);
    echo json_encode(['error' => true, 'message' => 'No autorizado']);
    exit;
}

require_once('../db.php');

if (!isset($_GET['id'])) {
    http_response_code(400);
    echo json_encode(['error' => true, 'message' => 'ID no proporcionado']);
    exit;
}

$id = intval($_GET['id']);

try {
    $stmt = $conn->prepare("SELECT id, sabor, descrip, costo, tipo, activo FROM smoothies WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        echo json_encode(['success' => true, 'producto' => $row]);
    } else {
        http_response_code(404);
        echo json_encode(['error' => true, 'message' => 'Producto no encontrado']);
    }

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => true, 'message' => $e->getMessage()]);
}

$conn->close();
?>
