<?php
// Habilitar reporte de errores para desarrollo (descomenta en local)
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

header('Content-Type: application/json');

// Función para enviar un error en formato JSON y terminar la ejecución
function sendJsonError($message, $code = 500) {
    http_response_code($code);
    echo json_encode([
        'error' => true,
        'message' => $message
    ]);
    exit;
}

// 1. Verificar si el archivo de conexión existe y puede ser requerido
$dbFile = '../db.php';
if (!file_exists($dbFile)) {
    sendJsonError("Error de configuración: archivo de base de datos no encontrado.");
}

// 2. Requerir el archivo de conexión
require_once($dbFile);

// 3. Verificar si la conexión a la base de datos se estableció correctamente
// (Asumiendo que en db.php la variable de conexión se llama $conn)
if (!isset($conn)) {
    sendJsonError("Error de configuración: conexión a la base de datos no disponible.");
}

try {
    $query = "SELECT id, sabor FROM smoothies ORDER BY id DESC";
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

    $smoothies = []; 
    
    while ($row = $result->fetch_assoc()) {
        $defaultImage = "../assets/images/smoothies/default.png";
        $imagePath = $defaultImage;

        //Ruta para buscar la imagen requerida
        $possibleImagePath = "../assets/images/smoothies/" . $row['id'] . ".*";

        //Usar glob para encontrar cualquier archivo que coincida con el patron 
        $imageFiles = glob($possibleImagePath);

        if (!empty($imageFiles)) {
            $imagePath = $imageFiles[0];
        }

        $smoothies[] = [
            'id' => $row['id'],
            'sabor' => $row['sabor'],
            'imagen' => $imagePath
        ];
        
    }

    // Enviar respuesta de éxito con los datos
    echo json_encode(['smoothies' => $smoothies]);

} catch (Exception $e) {
    sendJsonError("Excepción capturada: " . $e->getMessage());
}

// Cerrar la conexión si está abierta
if (isset($conn) && $conn instanceof mysqli) {
    $conn->close();
}
?>