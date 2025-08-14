<?php
include 'db.php';

$search = $_GET['search'] ?? '';
$clases = $_GET['clases'] ?? '';
$disciplina = $_GET['disciplina'] ?? '';

$sql = "SELECT * FROM paquetes WHERE 1=1";

if (!empty($search)) {
    $sql .= " AND nombre LIKE ?";
    $params[] = "%$search%";
}
if (!empty($clases) && $clases !== 'CLASES POR SEMANA') {
    $sql .= " AND clases = ?";
    $params[] = $clases;
}
if (!empty($disciplina) && $disciplina !== 'DISCIPLINA') {
    $sql .= " AND nombre = ?";
    $params[] = $disciplina;
}

$stmt = $conn->prepare($sql);

if (!empty($params)) {
    $types = str_repeat('s', count($params));
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$result = $stmt->get_result();
$paquetes = [];

while ($row = $result->fetch_assoc()) {
    $paquetes[] = $row;
}

echo json_encode($paquetes);
?>
