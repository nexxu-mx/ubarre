<?php
include './db2.php';

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Consulta SQL para obtener los datos de los empleados
$sql = "SELECT id, nombre, puesto FROM usr";
$result = $conn->query($sql);

// Verificar si hay resultados
$empleados = [];

if ($result->num_rows > 0) {
    // Recorrer los resultados y almacenarlos en un array
    while ($row = $result->fetch_assoc()) {
        $empleados[] = $row;
    }
} else {
    $empleados = [];
}

$conn->close();

// Devolver la respuesta en formato JSON
echo json_encode($empleados);
?>
