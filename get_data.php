<?php
include 'db.php';
session_start();
$id = $_SESSION['idUser'];

$stmt = $conn->prepare("SELECT nombre, apellido, mail, numero, fecha_nacimiento FROM users WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo json_encode(["error" => "Usuario no encontrado"]);
} else {
    $row = $result->fetch_assoc();
    $fecha = explode("-", $row["fecha_nacimiento"]);
    $nombre = $row["nombre"] . " " . $row["apellido"];
    echo json_encode([
        "nombre" => $nombre,
        "mail" => $row["mail"],
        "numero" => $row["numero"],
        "dia" => $fecha[0],
        "mes" => $fecha[1],
        "anio" => $fecha[2]
    ]);
}
?>
