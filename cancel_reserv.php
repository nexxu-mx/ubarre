<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["evento"])) {
    $id = intval($_POST["evento"]);
    $classID = intval($_POST['classID']);
        $usuario = intval($_POST['usuario']);
        $invitado = intval($_POST['invitado']);
        $clase = $_POST['title'];
    include("db.php"); 
    $sql = "DELETE FROM reservaciones WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        $lnum = $invitado + 1;
        //logica para aumentar aforo en clases y aumentar creditos al usuario 
        $stmtR = $conn->prepare("UPDATE clases SET reservados = reservados - $lnum WHERE id = ?");
        $stmtR->bind_param("i", $classID);
    if ($stmtR->execute()) {
            $stmtUR = $conn->prepare("UPDATE users SET credit = credit + $lnum WHERE id = ?");
            $stmtUR->bind_param("i", $usuario);
            if ($stmtUR->execute()) {
                echo "Reservación cancelada con éxito.";

                session_start();
                $mail_mailing = $_SESSION['email'];
                $mail_asunto = "Reservación Cancelada";
                $mail_motivo = "Reservación de $clase";
                $mail_motivo2 = "Tu reservación de tu clase fue cancelada con éxito, y tus créditos serán devueltos.";
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
