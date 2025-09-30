<?php
header('Content-Type: application/json');
require '../db.php'; // aquí incluyes tu $conn de mysqli
require '../error_log.php';
// leer el JSON que envía fetch
$input = json_decode(file_get_contents("php://input"), true);

$id = intval($input['id']);
$estado = intval($input['estado']); // 0 o 1

// convertir a null o 1
$valor = ($estado === 1) ? 1 : null;

$stmt = $conn->prepare("UPDATE descuentos SET activo = ? WHERE id = ?");
$stmt->bind_param("ii", $valor, $id);

// ⚠️ si $valor es null hay que tratarlo como entero NULL
if ($valor === null) {
    // con bind_param "i" manda 0, no null → se hace así:
    $stmt->bind_param("ii", $valor, $id); 
    $valor = null;
}

$ok = $stmt->execute();

echo json_encode([
    "success" => $ok,
    "id" => $id,
    "estado_recibido" => $estado,
    "valor_guardado" => $valor
]);
