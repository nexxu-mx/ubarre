<?php
include 'db.php';

$data = json_decode(file_get_contents("php://input"), true);
session_start();
$id = $_SESSION['idUser'];

$name = $data['nombre'];
$mail = $data['mail'];
$numero = $data['numero'];
$fecha_nac = $data['dia'] . '-' . $data['mes'] . '-' . $data['anio'];

$partes = explode(" ", $name);

$nombre = "";
$apellido = "";

// Si hay más de 2 palabras
if (count($partes) === 4) {
    $nombre = $partes[0] . " " . $partes[1];
    $apellido = $partes[2] . " " . $partes[3];
} elseif (count($partes) === 3) {
    $nombre = $partes[0];
    $apellido = $partes[1] . " " . $partes[2];
} elseif (count($partes) === 2) {
    $nombre = $partes[0];
    $apellido = $partes[1];
} else {
    $nombre = $partes[0];
    $apellido = "";
}

$stmt = $conn->prepare("UPDATE users SET nombre = ?, apellido = ?, mail = ?, numero = ?, fecha_nacimiento = ? WHERE id = ?");
$stmt->bind_param("sssssi", $nombre, $apellido, $mail, $numero, $fecha_nac, $id);

if ($stmt->execute()) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "error" => $stmt->error]);
}
?>
