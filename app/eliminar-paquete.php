<?php

$data = json_decode(file_get_contents("php://input"), true);

include '../db.php';

$paquete = $data['paquete'];

if (isset($paquete)) {
    $eliminarPaquete = $conn->prepare("DELETE FROM paquetes WHERE id = ?");
    $eliminarPaquete->bind_param("i", $paquete);
    $success = $eliminarPaquete->execute();

    echo json_encode(['success' => $success]);
} else {
    echo json_encode(['error' => false]);
}