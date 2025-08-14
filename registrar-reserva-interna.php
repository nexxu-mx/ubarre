<?php
include 'db.php'; // conexión a tu base de datos

// Obtener datos enviados
$data = json_decode(file_get_contents('php://input'), true);

if (!$data) {
    echo json_encode(['status' => 'error', 'message' => 'No se recibieron datos']);
    exit;
}

$alumno = $data['id_alumno'];
$idClase = $data['id_event'];
$instructor = $data['coach'];
$clase = $data['disciplina'];
$dura = $data['duracion'];
$idInstructor = $data['id_coach'];
$invitado = 0;
$activo = "1";
date_default_timezone_set('America/Mexico_City');
$fechaReserva = time();
//----
$inicio = null;
$fin = null;

$stmtC = $conn->prepare("SELECT hora_inicio, hora_fin FROM clases WHERE id = ?");
$stmtC->bind_param("i", $idClase);
$stmtC->execute();
$resultC = $stmtC->get_result();

if ($resultC->num_rows === 0) {
    echo json_encode(["error" => "clase no encontrada"]);
} else {
    $rowC = $resultC->fetch_assoc();
    $inicio = $rowC['hora_inicio'];
    $fin = $rowC['hora_fin'];
}
//----
$stmtCredit = $conn->prepare("SELECT credit FROM users WHERE id = ?");
$stmtCredit->bind_param("i", $alumno);
$stmtCredit->execute();
$resultCredit = $stmtCredit->get_result();
if ($resultCredit->num_rows === 0) {
    echo json_encode(["error" => "clase no encontrada"]);
} else {
    $rowCredit = $resultCredit->fetch_assoc(); // <-- aquí extraes la fila
    $creditDisponible = $rowCredit['credit'];   // ahora sí puedes acceder
    
    if ($creditDisponible <= 0) {
        echo json_encode(["status" => "nocredit"]);
        exit;
    }
}


// Insertar en la tabla reservaciones
$stmt = $conn->prepare("INSERT INTO reservaciones (clase, idClase, alumno, dura, instructor, idInstructor, invitado, activo, inicio, fin, fechaReserva) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssssssssss", $clase, $idClase, $alumno, $dura, $instructor, $idInstructor, $invitado, $activo, $inicio, $fin, $fechaReserva);

if ($stmt->execute()) {
            $stmtR = $conn->prepare("UPDATE clases SET reservados = reservados + 1 WHERE id = ?");
            $stmtR->bind_param("i", $idClase);
        if ($stmtR->execute()) {
                $stmtUR = $conn->prepare("UPDATE users SET credit = credit - 1 WHERE id = ?");
                $stmtUR->bind_param("i", $alumno);
                if ($stmtUR->execute()) {
                
                $mail_mailing = $_SESSION['email'];
                $mail_asunto = "Reservaste $clase";
                $mail_motivo = "$clase";
                $mail_motivo2 = "Te esperamos en $clase el $inicio";
                $mail_descripcion = "Tu reservación de $clase con $instructor el $inicio, se agendó de manera exitosa! Puedes revistar los detalles de tu reserva en tu perfil.";
                $mail_tabla = "Recuerda que puedes cancelar tu reservación hasta con 6 horas de anticipación.";
                include 'success_mail.php';

                    $response = ['success' => "ok"];
                    echo json_encode($response);

                } else {
                    echo json_encode(["status" => false, "error" => $stmtUR->error]);
                }
        } else {
            echo json_encode(["status" => false, "error" => $stmtR->error]);
        }
} else {
    echo json_encode(['status' => 'error', 'message' => 'No se pudo registrar']);
}
$stmtCredit->close();
$stmtC->close();
$stmt->close();
$conn->close();
?>
