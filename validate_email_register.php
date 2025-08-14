<?php
// Conexión a tu base de datos
include 'db.php';

$numero = $_POST['email'] ?? '';

$stmt = $conn->prepare("SELECT COUNT(*) FROM users WHERE mail = ?");
$stmt->bind_param("s", $numero);
$stmt->execute();
$stmt->bind_result($count);
$stmt->fetch();
$stmt->close();
if($count > 0){
    echo json_encode(['exists' => true]);
} else {
    echo json_encode(['exists' => false]);
}
?>