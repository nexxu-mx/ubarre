<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["evento"])) {
    $id = intval($_POST["evento"]);
    $classID = intval($_POST['classID']);
        $usuario = intval($_POST['usuario']);
        $invitado = intval($_POST['invitado']);
        $clase = $_POST['title'];
    include("db.php"); 
    ///info de smoothies
    $sqs = ("SELECT sabor FROM reservaciones WHERE id = ?");
    $sms = $conn->prepare($sqs);
    $sms->bind_param("i", $id);
    $sms->execute();
    $res = $sms->get_result();
    if($res->num_rows > 0){
        $ros = $res->fetch_assoc();
        if(empty($ros['sabor'])){
            $smoothie = 0;
        }else{
            $smoothie = 1;
        }
        
    }else{
        $smoothie = 0;
    }

    
    ///elimina reservaciones
    $sql = "DELETE FROM reservaciones WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        $lnum = $invitado + 1;
        //logica para aumentar aforo en clases y aumentar creditos al usuario
        $stmtR = $conn->prepare("UPDATE clases SET reservados = reservados - $lnum WHERE id = ?");
        $stmtR->bind_param("i", $classID);
    if ($stmtR->execute()) {
            $stmtUR = $conn->prepare("UPDATE users SET credit = credit + $lnum, total_smoothies = total_smoothies + $smoothie WHERE id = ?");
            $stmtUR->bind_param("i", $usuario);
            if ($stmtUR->execute()) {

                // TICKET 2: PROMOCIÓN AUTOMÁTICA DESDE WAIT LIST
                // Buscar el primer usuario en wait list para esta clase
                $stmtWait = $conn->prepare("SELECT id, alumno, sabor, momento FROM reservaciones WHERE idClase = ? AND en_espera = 1 AND activo = '1' ORDER BY fecha_ingreso_espera ASC LIMIT 1");
                $stmtWait->bind_param("i", $classID);
                $stmtWait->execute();
                $resultWait = $stmtWait->get_result();

                if ($resultWait->num_rows > 0) {
                    $waitUser = $resultWait->fetch_assoc();
                    $waitReservId = $waitUser['id'];
                    $waitUserId = $waitUser['alumno'];
                    $waitSabor = $waitUser['sabor'];
                    $waitMomento = $waitUser['momento'];

                    // Promover usuario de wait list a confirmado
                    $stmtPromote = $conn->prepare("UPDATE reservaciones SET en_espera = 0, fecha_ingreso_espera = NULL WHERE id = ?");
                    $stmtPromote->bind_param("i", $waitReservId);
                    $stmtPromote->execute();

                    // Incrementar reservados
                    $stmtIncr = $conn->prepare("UPDATE clases SET reservados = reservados + 1 WHERE id = ?");
                    $stmtIncr->bind_param("i", $classID);
                    $stmtIncr->execute();

                    // Descontar crédito del usuario promovido
                    $restarSmoothieWait = (!empty($waitSabor) && $waitMomento !== "Sin smoothie") ? 1 : 0;
                    $stmtDeduct = $conn->prepare("UPDATE users SET credit = credit - 1, total_smoothies = total_smoothies - $restarSmoothieWait WHERE id = ?");
                    $stmtDeduct->bind_param("i", $waitUserId);
                    $stmtDeduct->execute();

                    // Obtener email del usuario promovido
                    $stmtEmail = $conn->prepare("SELECT mail, nombre FROM users WHERE id = ?");
                    $stmtEmail->bind_param("i", $waitUserId);
                    $stmtEmail->execute();
                    $resultEmail = $stmtEmail->get_result();
                    if ($userEmail = $resultEmail->fetch_assoc()) {
                        $mail_mailing = $userEmail['mail'];
                        $mail_asunto = "¡Confirmado! - $clase";
                        $mail_motivo = "Promovido de Lista de Espera";
                        $mail_motivo2 = "¡Buenas noticias! Tu reservación ha sido confirmada";
                        $mail_descripcion = "Has sido promovido de la lista de espera. Tu lugar en $clase está confirmado. ¡Te esperamos!";
                        $mail_tabla = "Recuerda que puedes cancelar tu reservación hasta con 6 horas de anticipación.";
                        include 'success_mail.php';
                    }

                    $stmtPromote->close();
                    $stmtIncr->close();
                    $stmtDeduct->close();
                    $stmtEmail->close();
                }
                $stmtWait->close();
                // FIN TICKET 2

                echo "Reservación cancelada con éxito.";

                session_start();
                $mail_mailing = $_SESSION['email'];
                $mail_asunto = "Reservación Cancelada";
                $mail_motivo = "Reservación de $clase";
                $mail_motivo2 = "Tu reservación de la clase fue cancelada con éxito, y tus créditos serán devueltos.";
                $mail_descripcion = "Si no reconoces esta operación, favor de reportarla al area de administración";
                $mail_tabla = " ";
                include 'success_mail.php';
            } else {
                echo "Error al cancelar la reservación.";
            }
    }
       
    } else {
        echo "Error al cancelar la reservación.";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Reintentar mas tarde.";
}
