<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["evento"])) {
    $id = intval($_POST["evento"]);
    $classID = intval($_POST['classID']);
    $usuario = intval($_POST['usuario']);
    $invitado = intval($_POST['invitado']);
    $clase = $_POST['title'];
    
    include("db.php"); 

    //Verificar si la reserva que se cancela era "En Espera" o "Confirmada" y obtener info de smoothies
    $stmtCheck = $conn->prepare("SELECT sabor, en_espera FROM reservaciones WHERE id = ?");
    $stmtCheck->bind_param("i", $id);
    $stmtCheck->execute();
    $resCheck = $stmtCheck->get_result();
    
    if($resCheck->num_rows > 0){
        $rowCheck = $resCheck->fetch_assoc();
        $eraEspera = $rowCheck['en_espera'];
        $smoothie = empty($rowCheck['sabor']) ? 0 : 1;
    } else {
        echo "Error: Reservación no encontrada.";
        exit;
    }
    $stmtCheck->close();

    //Eliminar la reservación
    $sql = "DELETE FROM reservaciones WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        $lnum = $invitado + 1;

        // El usuario que cancela ESTABA EN ESPERA
        if ($eraEspera == 1) {
            // No devolvemos créditos, ni restamos de la tabla clases 
            echo "Reservación en lista de espera cancelada.";
        } 
        // El usuario que cancela ESTABA CONFIRMADO y Liberó un lugar
        else {
            // Devolvemos créditos y smoothies al usuario que cancela
            $stmtUR = $conn->prepare("UPDATE users SET credit = credit + $lnum, total_smoothies = total_smoothies + $smoothie WHERE id = ?");
            $stmtUR->bind_param("i", $usuario);
            $stmtUR->execute();
            $stmtUR->close();

            // PROMOCIÓN AUTOMÁTICA
            $stmtWait = $conn->prepare("SELECT id, alumno, sabor, momento FROM reservaciones WHERE idClase = ? AND en_espera = 1 ORDER BY fecha_ingreso_espera ASC LIMIT 1");
            $stmtWait->bind_param("i", $classID);
            $stmtWait->execute();
            $resultWait = $stmtWait->get_result();

            if ($resultWait->num_rows > 0) {
                // si hay alguien esperando: Lo metemos en el lugar que quedó libre
                $waitUser = $resultWait->fetch_assoc();
                $waitReservId = $waitUser['id'];
                $waitUserId = $waitUser['alumno'];
                $waitSabor = $waitUser['sabor'];
                $waitMomento = $waitUser['momento'];

                // Promover usuario (en_espera = 0)
                $stmtPromote = $conn->prepare("UPDATE reservaciones SET en_espera = 0, fecha_ingreso_espera = NULL WHERE id = ?");
                $stmtPromote->bind_param("i", $waitReservId);
                $stmtPromote->execute();

                // Cobrar crédito al promovido
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
                include 'success_mail.php';
                
            } else {
                // si no hay nadie en espera: Restamos el cupo de la tabla clases
                $stmtR = $conn->prepare("UPDATE clases SET reservados = reservados - $lnum WHERE id = ?");
                $stmtR->bind_param("i", $classID);
                $stmtR->execute();
                $stmtR->close();
            }
            $stmtWait->close();
        }

        // Mail de confirmación de cancelación para el usuario que canceló
        session_start();
        $mail_mailing = $_SESSION['email'];
        $mail_asunto = "Reservación Cancelada";
        $mail_motivo = "Cancelación Exitosa";
        $mail_motivo2 = "Tu reservación de $clase fue cancelada.";
        $mail_descripcion = "Tus créditos han sido actualizados en tu perfil.";
        $mail_tabla = " ";
        include 'success_mail.php';

        echo "Cancelación procesada correctamente.";
    } else {
        echo "Error al cancelar la reservación.";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Acceso no autorizado.";
}
?>