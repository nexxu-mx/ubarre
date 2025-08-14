<?php
include 'db.php';

$numero = $_POST['numero'] ?? '';

$stmt = $conn->prepare("SELECT COUNT(*) FROM users WHERE numero = ?");
$stmt->bind_param("s", $numero);
$stmt->execute();
$stmt->bind_result($count);
$stmt->fetch();
$stmt->close();
if($count > 0){
    echo json_encode(['exists' => true, 'nume' => $numero]);
} else {
    echo json_encode(['exists' => false, 'nume' => $numero]);
}
?>