<?php
session_start();
header('Content-Type: application/json');

// Solo admin puede ver todos los productos
if (!isset($_SESSION['idUser']) || (int)$_SESSION['tipoUser'] !== 3) {
    http_response_code(403);
    echo json_encode(['error' => true, 'message' => 'No autorizado']);
    exit;
}

require_once('../db.php');

try {
    $query = "SELECT id, sabor as nombre, descrip as descripcion, costo, tipo, activo
              FROM smoothies
              ORDER BY tipo, sabor ASC";

    $stmt = $conn->prepare($query);
    $stmt->execute();
    $result = $stmt->get_result();

    $productos = [];
    while ($row = $result->fetch_assoc()) {
        $productos[] = [
            'id' => $row['id'],
            'nombre' => $row['nombre'],
            'descripcion' => $row['descripcion'],
            'costo' => floatval($row['costo']),
            'tipo' => $row['tipo'],
            'activo' => $row['activo']
        ];
    }

    echo json_encode(['success' => true, 'productos' => $productos]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => true, 'message' => $e->getMessage()]);
}

$conn->close();
?>
