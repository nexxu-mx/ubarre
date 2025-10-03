<?php
header('Content-Type: application/json');
include 'db.php';
include 'error_log.php';
session_start();
$id = $_SESSION['idUser'];

$sql = "SELECT nombre, credit, fechaCredit, total_smoothies FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo json_encode(["error" => "Usuario no encontrado"]);
    exit;
}
$row = $result->fetch_assoc();
$credit = $row["credit"];

if((int)$credit < 32){
    $credit = "Ilimitados";
}else{
    $credit = "0";
}


echo json_encode([
    "nombre" => $row["nombre"],
    "credit" => $credit,
    "fechaCredit" => $row["fechaCredit"],
    "total_smoothies" => $row["total_smoothies"]
]);
?>
