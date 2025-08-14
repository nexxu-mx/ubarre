<?php
include '../error_log.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include '../db.php';

    $idusrv = $_POST['iden'];
    $paquete = $_POST['paquete'];
    $method = $_POST['metod'];
    
    // Obtener información del paquete
    $sqlP = "SELECT clases, costo, vigencia, invitados FROM paquetes WHERE id = ?";
    $stmtP = $conn->prepare($sqlP);
    $stmtP->bind_param("i", $paquete);
    $stmtP->execute();
    $resultP = $stmtP->get_result();

    if ($resultP->num_rows === 0) {
        ob_end_clean();
        http_response_code(400);
        die(json_encode(['error' => 'Paquete no encontrado']));
    }

    $rowP = $resultP->fetch_assoc();
    $credits = $rowP['clases'];
    $vigencia = $rowP['vigencia'];
    $invitados = $rowP['invitados'];
    $cargo1 = (float) $rowP['costo'];

    // Datos del usuario
    $sql = "SELECT nombre, apellido, mail, numero, credit, claseBienvenida, customer_id FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $idusrv);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        ob_end_clean();
        http_response_code(404);
        die(json_encode(['error' => 'Usuario no encontrado']));
    }

    $row = $result->fetch_assoc();
    if($row['claseBienvenida'] == 1 && $paquete == 1){
        ob_end_clean();
        echo json_encode(['error' => "CLASE BIENVENIDA UTILIZADA"]);
        exit;
    }

    $nombre = $row['nombre'];
    $apellido = $row['apellido'];
    $numero = $row['numero'];
    $creditos = $row['credit'];
    $mail = $row['mail'];
    $customer_id = $row['customer_id'];

    if($credits == "ILIMITADO"){
        $credits = 9999;
    }
    $new_credit = $credits;
    $status = "approved";
    $idpago = str_pad(random_int(0, 99999999), 8, '0', STR_PAD_LEFT);
    date_default_timezone_set('America/Mexico_City');
        $dateHoy = date('Y-m-d H:i:s', time());
        $fecha = new DateTime($dateHoy);

// Sumar los días almacenados en $fvencimiento
    $fechaCredit = date('Y-m-d');
    $dias = (int)$vigencia; // si vigencia viene como número de días

    $fvencimiento = date('Y-m-d', strtotime("+{$dias} days"));
        $bienvenida = ($paquete == 1 || $row['claseBienvenida'] == 1) ? 1 : null;
        
        // Actualizar usuario
        $sql_update = "UPDATE users SET credit = ?, venceCredit = ?, fechaCredit = ?, maxInvitados = ?, claseBienvenida = ?, statu = ?, idpago = ?, montoPagado = ? WHERE id = ?";
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bind_param("ssssssssi", $credits, $vigencia, $fvencimiento, $invitados, $bienvenida, $status, $idpago, $cargo1, $idusrv);
        $stmt_update->execute();
        
        // Registrar transacción
        $dateNow = date('Y-m-d H:i:s', time());
        $stmt_trans = $conn->prepare("INSERT INTO transacciones (user, monto, creditos, numero, metodo, idpago, mrecibido, fecha) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt_trans->bind_param("ssssssss", $idusrv, $cargo1, $credits, $numero, $method, $idpago, $cargo1, $dateNow);
        $stmt_trans->execute();
    
        header("Location: edit-user.php?id=" . $idusrv);
        exit();
}else{
    header("Location: clientes.php");
    exit();
}
?>