<?php
include '../db.php'; // tu conexión a la base de datos
include '../error_log.php'; // opcional si usas manejo de errores

// Recibir datos del formulario
$id = $_POST['idu'] ?? null;
$nombre = $_POST['nombre'] ?? null;
$apellido = $_POST['apellido'] ?? null;
$mail = $_POST['mail'] ?? null;
$numero = $_POST['numero'] ?? null;
$pass = $_POST['pass'] ?? null;
$fecha = $_POST['fecha'] ?? null;
$credit = $_POST['creditos'] ?? null;
$vencecreditos = $_POST['vencecreditos'] ?? null;
$tipouser = $_POST['tipouser'] ?? null;

// Si ID está vacío => INSERTAR
if (empty($id)) {
    $stmt = $conn->prepare("INSERT INTO users (tipoUser, nombre, apellido, mail, numero, pass, fecha_nacimiento, credit) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssss", $tipouser, $nombre, $apellido, $mail, $numero, $pass, $fecha, $credit);
} else {
    // Si ID tiene valor => ACTUALIZAR
    $stmt = $conn->prepare("UPDATE users SET tipoUser = ?, nombre = ?, apellido = ?, mail = ?, numero = ?, pass = ?, fecha_nacimiento = ?, credit = ?, fechaCredit = ? WHERE id = ?");
    $stmt->bind_param("sssssssssi", $tipouser, $nombre, $apellido, $mail, $numero, $pass, $fecha, $credit, $vencecreditos, $id);
}
if (!$stmt->execute()) {
    die("Error al ejecutar la consulta: " . $stmt->error);
}
if ($stmt->execute()) {
    header("Location: clientes.php?success=1&usr=$id");
    exit();
} else {
    header("Location: clientes.php?error=1");
    exit();
}
?>
