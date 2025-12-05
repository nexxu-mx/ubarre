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

if (!isset($data['id']) || !isset($data['nombre']) || !isset($data['tipo']) || !isset($data['costo'])) {
    http_response_code(400);
    echo json_encode(['error' => true, 'message' => 'Datos incompletos']);
    exit;
}

$id = intval($data['id']);
$nombre = trim($data['nombre']);
$descripcion = isset($data['descripcion']) ? trim($data['descripcion']) : '';
$tipo = $data['tipo'];
$costo = floatval($data['costo']);

if (empty($nombre) || $costo <= 0) {
    http_response_code(400);
    echo json_encode(['error' => true, 'message' => 'Datos inválidos']);
    exit;
}

try {
    $stmt = $conn->prepare("UPDATE smoothies SET sabor = ?, descrip = ?, tipo = ?, costo = ? WHERE id = ?");
    $stmt->bind_param("sssdi", $nombre, $descripcion, $tipo, $costo, $id);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        throw new Exception('Error al actualizar producto');
    }

    $stmt->close();
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => true, 'message' => $e->getMessage()]);
}

$conn->close();
?>
