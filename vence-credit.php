<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set('America/Mexico_City'); 

$mysqli = new mysqli("127.0.0.1", "u379047759_sencia", "Sencia25*", "u379047759_studio");

if ($mysqli->connect_error) {
    die("Error de conexión: " . $mysqli->connect_error);
}

$sql = "SELECT id, credit, fechaCredit FROM users WHERE fechaCredit IS NOT NULL";
$result = $mysqli->query($sql);

$hoy = new DateTime();

while ($row = $result->fetch_assoc()) {
    $id = $row['id'];
    $credit = (int)$row['credit'];
    $fechaCredit = new DateTime($row['fechaCredit']);

    // CORREGIDO: si la fecha ya pasó o es hoy
    if ($fechaCredit <= $hoy) {
        $fechaVencimiento = $fechaCredit->format('Y-m-d');

        // Insertar en creditos_vencidos
        $stmtLog = $mysqli->prepare("
            INSERT INTO creditos_vencidos (user_id, creditos_vencidos, fecha_vencimiento) 
            VALUES (?, ?, ?)
        ");
        $stmtLog->bind_param("iis", $id, $credit, $fechaVencimiento);
        $stmtLog->execute();
        $stmtLog->close();

        // Actualizar tabla users de forma segura
        $stmtUpdate = $mysqli->prepare("
            UPDATE users 
            SET fechaCredit = NULL, venceCredit = NULL, credit = 0, maxInvitados = NULL
            WHERE id = ?
        ");
        $stmtUpdate->bind_param("i", $id);
        $stmtUpdate->execute();
        $stmtUpdate->close();

        echo "Usuario ID $id vencido el $fechaVencimiento<br>";
    }
}

$mysqli->close();
