<?php
include 'db.php';

$numero = $_POST['numero'] ?? '';
$code = $_POST['code'] ?? '';

$stmt = $conn->prepare("SELECT COUNT(*), dlogin FROM users WHERE numero = ? AND tlogin = ?");
$stmt->bind_param("ss", $numero, $code);
$stmt->execute();
$stmt->bind_result($count, $dlogin);
$stmt->fetch();
$stmt->close();
//valida duracion de codigo
date_default_timezone_set('America/Mexico_City');
$timestamp = time();
if((time() - $dlogin) > 900){
    echo json_encode(['valid' => false]);
    exit;  
}

echo json_encode(['valid' => $count > 0]);  
?>
