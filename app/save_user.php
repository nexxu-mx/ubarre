<?php
include '../db.php'; // tu conexión a la base de datos
include '../error_log.php'; // opcional si usas manejo de errores

// Recibir datos del formulario
$id = $_POST['idu'] ?? null;
$nombre = trim($_POST['nombre'] ?? '');
$apellido = $_POST['apellido'] ?? null;
$mail = trim($_POST['mail'] ?? '');
$numero = trim($_POST['numero'] ?? '');
$pass = $_POST['pass'] ?? '';
$fecha = $_POST['fecha'] ?? null;
$credit = $_POST['creditos'] ?? '0';
if(empty($credit)){
    $credit = 0;
}
$vencecreditos = $_POST['vencecreditos'] ?? null;
$tipouser = $_POST['tipouser'] ?? '1';
$smoothies = $_POST['smoothies'] ?? null;
if($smoothies == 0){
    $smoothies = null;
}


// Si ID está vacío => INSERTAR
if (empty($id)) {
    $stmt = $conn->prepare(
        "INSERT INTO users (tipoUser, nombre, apellido, mail, numero, pass, fecha_nacimiento, total_smoothies, credit) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)"
        );
    $stmt->bind_param("sssssssss", $tipouser, $nombre, $apellido, $mail, $numero, $pass, $fecha, $smoothies, $credit);
} else {
    // Si ID tiene valor => ACTUALIZAR
    $stmt = $conn->prepare(
        "UPDATE users SET tipoUser = ?, nombre = ?, apellido = ?, mail = ?, numero = ?, pass = ?, fecha_nacimiento = ?, total_smoothies = ?, credit = ?, fechaCredit = ? 
        WHERE id = ?");
    $stmt->bind_param("ssssssssssi", $tipouser, $nombre, $apellido, $mail, $numero, $pass, $fecha, $smoothies, $credit, $vencecreditos, $id);
}
/* if (!$stmt->execute()) {
    die("Error al ejecutar la consulta: " . $stmt->error);
} */
if ($stmt->execute()) {
    header("Location: clientes.php?success=1&usr=" . ($id ?? 'new'));
    exit();
} else {
    error_log("Error SQL: " . $stmt->error); 
    header("Location: clientes.php?error=1"); 
    exit();
}
?>
