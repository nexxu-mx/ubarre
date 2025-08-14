<?php
include '../db.php';

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Obtener el filtro de fecha enviado desde el frontend
$fechaFiltro = isset($_GET['fecha']) ? $_GET['fecha'] : '';

// Si se ha enviado un filtro de fecha, ajustar la consulta SQL
if ($fechaFiltro) {
    // Filtrar por mes (en formato yyyy-mm)
    $sql = "SELECT id, fecha, concepto, tipo, monto FROM egr WHERE DATE_FORMAT(fecha, '%Y-%m') = '$fechaFiltro'";
} else {
    // Si no hay filtro, traer todos los registros
    $sql = "SELECT id, fecha, concepto, tipo, monto FROM egr";
}

$result = $conn->query($sql);

// Verificar si hay resultados
$egresos = [];

if ($result->num_rows > 0) {
    // Recorrer los resultados y almacenarlos en un array
    while ($row = $result->fetch_assoc()) {
        $egresos[] = $row;
    }
} else {
    $egresos = [];
}

$conn->close();

// Devolver la respuesta en formato JSON
echo json_encode($egresos);
?>
