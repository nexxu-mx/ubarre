<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once('../db.php');

header('Content-Type: application/json');

// Obtener el año actual
$year = date('Y');

// Consulta modificada para manejar timestamp UNIX
$query = "
    SELECT 
        MONTH(FROM_UNIXTIME(fechaReserva)) as mes,
        COUNT(*) as total
    FROM reservaciones
    WHERE 
        YEAR(FROM_UNIXTIME(fechaReserva)) = ?
    GROUP BY MONTH(FROM_UNIXTIME(fechaReserva))
    ORDER BY mes ASC
";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $year);
$stmt->execute();
$result = $stmt->get_result();

// Inicializar array con 12 meses (0 para meses sin datos)
$data = array_fill(0, 11, 0);

while ($row = $result->fetch_assoc()) {
    $data[$row['mes'] - 1] = (int)$row['total']; // -1 porque los meses van de 1 a 12
}

// Meses en español
$meses = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];

echo json_encode([
    'labels' => $meses,
    'data' => $data
]);

$stmt->close();
$conn->close();
?>