<?php
session_start();
header('Content-Type: application/json');

// Verificar sesión
if (!isset($_SESSION['idUser']) || !isset($_SESSION['tipoUser'])) {
    http_response_code(401);
    echo json_encode(['error' => true, 'message' => 'No autorizado']);
    exit;
}

// Solo admin y recepción pueden registrar ventas
if((int)$_SESSION['tipoUser'] !== 3 && (int)$_SESSION['tipoUser'] !== 4){
    http_response_code(403);
    echo json_encode(['error' => true, 'message' => 'No tiene permisos para realizar esta acción']);
    exit;
}

require_once('../db.php');

if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(['error' => true, 'message' => 'Error de conexión a la base de datos']);
    exit;
}

// Obtener datos del POST
$data = json_decode(file_get_contents('php://input'), true);

if (!$data || !isset($data['id_producto']) || !isset($data['cantidad'])) {
    http_response_code(400);
    echo json_encode(['error' => true, 'message' => 'Datos incompletos']);
    exit;
}

$id_producto = intval($data['id_producto']);
$cantidad = intval($data['cantidad']);
$metodo_pago = isset($data['metodo_pago']) ? $data['metodo_pago'] : 'efectivo';

if ($cantidad <= 0) {
    http_response_code(400);
    echo json_encode(['error' => true, 'message' => 'Cantidad inválida']);
    exit;
}

try {
    // Obtener información del producto
    $stmt = $conn->prepare("SELECT sabor, costo, activo FROM smoothies WHERE id = ?");
    $stmt->bind_param("i", $id_producto);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        throw new Exception('Producto no encontrado');
    }

    $producto = $result->fetch_assoc();

    if ($producto['activo'] != 1) {
        throw new Exception('Producto no disponible');
    }

    $nombre_producto = $producto['sabor'];
    $precio_unitario = floatval($producto['costo']);
    $total = $precio_unitario * $cantidad;

    // Registrar venta
    $stmt = $conn->prepare("INSERT INTO ventas (id_producto, nombre_producto, cantidad, precio_unitario, total, vendedor_id, vendedor_nombre, metodo_pago) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

    $vendedor_id = $_SESSION['idUser'];
    $vendedor_nombre = $_SESSION['nombre'];

    $stmt->bind_param("isiddiss",
        $id_producto,
        $nombre_producto,
        $cantidad,
        $precio_unitario,
        $total,
        $vendedor_id,
        $vendedor_nombre,
        $metodo_pago
    );

    if (!$stmt->execute()) {
        throw new Exception('Error al registrar la venta');
    }

    $venta_id = $conn->insert_id;

    echo json_encode([
        'success' => true,
        'message' => 'Venta registrada correctamente',
        'venta_id' => $venta_id,
        'total' => $total
    ]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => true, 'message' => $e->getMessage()]);
}

$conn->close();
?>
