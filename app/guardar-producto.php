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

if (!isset($data['nombre']) || !isset($data['tipo']) || !isset($data['costo'])) {
    http_response_code(400);
    echo json_encode(['error' => true, 'message' => 'Datos incompletos']);
    exit;
}

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
    $stmt = $conn->prepare("INSERT INTO smoothies (sabor, descrip, tipo, costo, activo) VALUES (?, ?, ?, ?, 1)");
    $stmt->bind_param("sssd", $nombre, $descripcion, $tipo, $costo);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'id' => $conn->insert_id]);
    } else {
        throw new Exception('Error al guardar producto');
    }

    $stmt->close();
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => true, 'message' => $e->getMessage()]);
}

$conn->close();
?>
