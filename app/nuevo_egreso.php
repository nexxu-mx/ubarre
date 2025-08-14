<?php
include '../db.php';

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Obtener datos del formulario (JSON)
$data = json_decode(file_get_contents("php://input"), true);

// Recolectar los datos del formulario
$fecha = $data['fecha'];
$concepto = $data['concepto'];
$tipo = $data['tipo'];
$monto = $data['monto'];



// Consulta SQL para insertar en la tabla `usr`
$sql = "INSERT INTO egr (fecha, concepto, tipo, monto) 
        VALUES ('$fecha', '$concepto', '$tipo', '$monto')";


// Ejecutar la consulta y devolver respuesta en formato JSON
$response = [];

if ($conn->query($sql) === TRUE) {
    $response['status'] = 'success';
    $response['message'] = 'Nuevo registro creado exitosamente';
} else {
    $response['status'] = 'error';
    $response['message'] = 'Error al crear el registro: ' . $conn->error;
}

$conn->close();

// Devolver la respuesta en formato JSON
echo json_encode($response);
?>
