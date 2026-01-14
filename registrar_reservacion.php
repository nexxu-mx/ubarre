<?php
include 'db.php'; // conexión a tu base de datos
include 'error_log.php'; // manejo de errores

// Obtener datos enviados
$data = json_decode(file_get_contents('php://input'), true);

if (!$data) {
    echo json_encode(['status' => 'error', 'message' => 'No se recibieron datos']);
    exit;
}
session_start();

if (empty($_SESSION['idUser']) || empty($_SESSION['nombre'])) {
    echo json_encode(["status" => "nosession"]);
    exit();
}

$alumno = $_SESSION['idUser'];
$idClase = $data['idClas'];
$instructor = $data['ncoach'];
$clase = $data['ndisciplina'];
$dura = $data['durac'];
$idInstructor = $data['idcoach'];
$sabor = isset($data['bebida']) ? $data['bebida'] : "";
$momento = isset($data['momento']) ? $data['momento'] : "";

$restarSmoothie = (!empty($sabor) && $momento !== "Sin smoothie");
/* echo $restarSmoothie; */

$invitado = 0;
$activo = "1";
date_default_timezone_set('America/Mexico_City');
$fechaReserva = time();

//----
$inicio = null;
$fin = null;



// SEGUNDO: Obtener información de la clase (TICKET 2: incluye verificación de aforo para wait list)
$stmtC = $conn->prepare("SELECT hora_inicio, hora_fin, aforo, reservados FROM clases WHERE id = ?");
$stmtC->bind_param("i", $idClase);
$stmtC->execute();
$resultC = $stmtC->get_result();

if ($resultC->num_rows === 0) {
    echo json_encode(["error" => "clase no encontrada"]);
    exit();
} else {
    $rowC = $resultC->fetch_assoc();
    $inicio = $rowC['hora_inicio'];
    $fecha_clase = $rowC['hora_inicio'];
    $fin = $rowC['hora_fin'];
    $aforo = $rowC['aforo'];
    $reservados = $rowC['reservados'];
}

// TERCERO: Verificar créditos disponibles
$stmtCredit = $conn->prepare("SELECT credit, ilimitado FROM users WHERE id = ?");
$stmtCredit->bind_param("i", $alumno);
$stmtCredit->execute();
$resultCredit = $stmtCredit->get_result();

if ($resultCredit->num_rows === 0) {
    echo json_encode(["error" => "usuario no encontrado"]);
    exit();
} else {
    $rowCredit = $resultCredit->fetch_assoc();
    $creditDisponible = $rowCredit['credit'];
    $ilimitado = $rowCredit['ilimitado'];

    if ($creditDisponible <= 0) {
        echo json_encode(["status" => "nocredit"]);
        exit();
    }
}
// SEGUNDO: Verificar si el usuario ya tiene reserva para esta clase
$stmtCheck = $conn->prepare("
    SELECT id 
    FROM reservaciones 
    WHERE alumno = ? 
      AND DATE(inicio) = ? 
      AND activo = '1'
    LIMIT 2
");

// extraer solo la parte de fecha (YYYY-MM-DD) de $fecha_clase
$fechaSolo = date("Y-m-d", strtotime($fecha_clase));

$stmtCheck->bind_param("is", $alumno, $fechaSolo);
$stmtCheck->execute();
$resultCheck = $stmtCheck->get_result();

if ($ilimitado == 1) {
    if ($resultCheck->num_rows > 1) {
        echo json_encode([
            "status" => "duplicate",
            "message" => "Con tu paquete ilimitado solo puedes reservar 2 clases por día"
        ]);
        $stmtCheck->close();
        exit();
    }
} else {
    if ($resultCheck->num_rows > 0) {
        echo json_encode([
            "status" => "duplicate",
            "message" => "Solo puedes reservar 1 clase por día con tu paquete actual"
        ]);
        $stmtCheck->close();
        exit();
    }
}


$stmtCheck->close();

// CUARTO: Verificar si la clase está llena (TICKET 2: Wait List)
$enEspera = 0;
$fechaIngresoEspera = null;

if ($reservados >= $aforo) {
    // Clase llena - agregar a wait list
    $enEspera = 1;
    $fechaIngresoEspera = date('Y-m-d H:i:s');
}

// QUINTO: Insertar la reserva (si pasó todas las validaciones)
$stmt = $conn->prepare("INSERT INTO reservaciones (clase, idClase, alumno, dura, instructor, idInstructor, invitado, activo, sabor, momento, inicio, fin, fechaReserva, en_espera, fecha_ingreso_espera) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssssssssssssss", $clase, $idClase, $alumno, $dura, $instructor, $idInstructor, $invitado, $activo, $sabor, $momento, $inicio, $fin, $fechaReserva, $enEspera, $fechaIngresoEspera);

if ($stmt->execute()) {
    // Solo incrementar reservados si NO está en wait list
    if ($enEspera == 0) {
        $stmtR = $conn->prepare("UPDATE clases SET reservados = reservados + 1 WHERE id = ?");
        $stmtR->bind_param("i", $idClase);
        $stmtR->execute();
        $stmtR->close();
    }

    // Solo descontar crédito si NO está en wait list
    if ($enEspera == 0) {
        $stmtUR = $conn->prepare("UPDATE users SET credit = credit - 1 WHERE id = ?");
        $stmtUR->bind_param("i", $alumno);

        if ($stmtUR->execute()) {
            //Descontar Smoothie si correponse
            if ($restarSmoothie) {
                $stmtSmoothie = $conn->prepare("UPDATE users SET total_smoothies = total_smoothies - 1 WHERE id = ?");
                $stmtSmoothie->bind_param("i", $alumno);

                if (!$stmtSmoothie->execute()) {
                    error_log("Error al restar Smoothie: " . $stmtSmoothie->error);
                }
                $stmtSmoothie->close();
            }
            $mail_mailing = $_SESSION['email'];
            $mail_asunto = "Reservaste $clase";
            $mail_motivo = "$clase";
            $mail_motivo2 = "Te esperamos en $clase el $inicio";
            $mail_descripcion = "Tu reservación de $clase con $instructor el $inicio, se agendó de manera exitosa! Puedes revistar los detalles de tu reserva en tu perfil.";
            $mail_tabla = "Recuerda que puedes cancelar tu reservación hasta con 6 horas de anticipación.";
            include 'success_mail.php';

            echo json_encode(["status" => "success"]);
        } else {
            echo json_encode(["status" => false, "error" => $stmtUR->error]);
        }
        $stmtUR->close();
    } else {
        // Usuario agregado a wait list
        $mail_mailing = $_SESSION['email'];
        $mail_asunto = "En Lista de Espera - $clase";
        $mail_motivo = "Lista de Espera - $clase";
        $mail_motivo2 = "Estás en lista de espera para $clase el $inicio";
        $mail_descripcion = "Has sido agregado a la lista de espera para $clase con $instructor el $inicio. Te notificaremos si se libera un lugar.";
        $mail_tabla = "Si alguien cancela su reservación, serás promovido automáticamente.";
        include 'success_mail.php';

        echo json_encode(["status" => "waitlist", "message" => "Agregado a lista de espera"]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'No se pudo registrar']);
}

// Cerrar todas las conexiones
$stmtCredit->close();
$stmtC->close();
$stmt->close();
$conn->close();
