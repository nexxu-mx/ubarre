<?php
include './db2.php';

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Obtener datos del formulario (JSON)
$data = json_decode(file_get_contents("php://input"), true);

// Recolectar los datos del formulario
$nombre = $data['nombre'];
$numero = $data['numero'];
$mail = $data['mail'];
$cont = $data['cont'];
$puesto = $data['puesto'];

// Verificar el estado de cada checkbox y asignar 1 o 0
$prod = in_array('prod', $data['values']) ? 1 : 0;
$fin = in_array('fin', $data['values']) ? 1 : 0;
$clien = in_array('cte', $data['values']) ? 1 : 0;
$admon = in_array('admon', $data['values']) ? 1 : 0;
$caja = in_array('caja', $data['values']) ? 1 : 0;

// Consulta SQL para insertar en la tabla `usr`
$sql = "INSERT INTO usr (nombre, numero, mail, pass, puesto, prod, fin, clien, admon, caja) 
        VALUES ('$nombre', '$numero', '$mail', '$cont', '$puesto', $prod, $fin, $clien, $admon, $caja)";

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
