<?php
header('Content-Type: application/json');

function sendJsonError($message, $code = 500) {
    http_response_code($code);
    echo json_encode([
        'error' => true,
        'message' => $message
    ]);
    exit;
}

$dbFile = '../db.php';
if (!file_exists($dbFile)) {
    sendJsonError("Error de configuración: archivo de base de datos no encontrado.");
}

require_once($dbFile);

if (!isset($conn)) {
    sendJsonError("Error de configuración: conexión a la base de datos no disponible.");
}

try {
    $query = "SELECT id, sabor as nombre, descrip, costo, tipo, activo
              FROM smoothies
              WHERE activo = 1
              ORDER BY tipo, sabor ASC";

    $stmt = $conn->prepare($query);

    if (!$stmt) {
        throw new Exception("Error preparando la consulta: " . $conn->error);
    }

    $executionSuccess = $stmt->execute();

    if (!$executionSuccess) {
        throw new Exception("Error ejecutando la consulta: " . $stmt->error);
    }

    $result = $stmt->get_result();

    if (!$result) {
        throw new Exception("Error obteniendo el resultado de la consulta.");
    }

    $productos = [];

    while ($row = $result->fetch_assoc()) {
        $defaultImage = "../assets/images/smoothies/default.png";
        $imagePath = $defaultImage;

        $possibleImagePath = "../assets/images/smoothies/" . $row['id'] . ".*";
        $imageFiles = glob($possibleImagePath);

        if (!empty($imageFiles)) {
            $imagePath = $imageFiles[0];
        }

        $productos[] = [
            'id' => $row['id'],
            'nombre' => $row['nombre'],
            'descripcion' => $row['descrip'],
            'costo' => floatval($row['costo']),
            'tipo' => $row['tipo'],
            'imagen' => $imagePath
        ];
    }

    echo json_encode(['success' => true, 'productos' => $productos]);

} catch (Exception $e) {
    sendJsonError("Excepción capturada: " . $e->getMessage());
}

if (isset($conn) && $conn instanceof mysqli) {
    $conn->close();
}
?>
