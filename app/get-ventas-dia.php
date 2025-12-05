<?php
session_start();
header('Content-Type: application/json');

// Verificar sesión
if (!isset($_SESSION['idUser']) || !isset($_SESSION['tipoUser'])) {
    http_response_code(401);
    echo json_encode(['error' => true, 'message' => 'No autorizado']);
    exit;
}

// Solo admin y recepción pueden ver ventas
if((int)$_SESSION['tipoUser'] !== 3 && (int)$_SESSION['tipoUser'] !== 4){
    http_response_code(403);
    echo json_encode(['error' => true, 'message' => 'No tiene permisos']);
    exit;
}

require_once('../db.php');

if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(['error' => true, 'message' => 'Error de conexión a la base de datos']);
    exit;
}

try {
    // Obtener ventas del día actual
    $fecha_hoy = date('Y-m-d');

    $query = "SELECT
                id,
                DATE_FORMAT(fecha_venta, '%H:%i') as hora,
                nombre_producto,
                cantidad,
                precio_unitario,
                total,
                vendedor_nombre,
                metodo_pago
              FROM ventas
              WHERE DATE(fecha_venta) = ?
              ORDER BY fecha_venta DESC";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $fecha_hoy);
    $stmt->execute();
    $result = $stmt->get_result();

    $ventas = [];
    $total_dia = 0;
    $total_efectivo = 0;
    $total_tarjeta = 0;

    while ($row = $result->fetch_assoc()) {
        $ventas[] = $row;
        $total_dia += floatval($row['total']);

        if ($row['metodo_pago'] === 'efectivo') {
            $total_efectivo += floatval($row['total']);
        } else if ($row['metodo_pago'] === 'tarjeta') {
            $total_tarjeta += floatval($row['total']);
        }
    }

    echo json_encode([
        'success' => true,
        'ventas' => $ventas,
        'total' => $total_dia,
        'por_metodo' => [
            'efectivo' => $total_efectivo,
            'tarjeta' => $total_tarjeta
        ]
    ]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => true, 'message' => $e->getMessage()]);
}

$conn->close();
?>
