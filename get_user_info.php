<?php
header('Content-Type: application/json');
include 'db.php';
session_start();
$id = $_SESSION['idUser'];

$sql = "SELECT nombre, credit, fechaCredit FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo json_encode(["error" => "Usuario no encontrado"]);
    exit;
}

$row = $result->fetch_assoc();
echo json_encode([
    "nombre" => $row["nombre"],
    "credit" => $row["credit"],
    "fechaCredit" => $row["fechaCredit"]
]);
?>
