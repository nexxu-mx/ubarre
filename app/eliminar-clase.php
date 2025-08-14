<?php
include '../db.php';

// Verificar conexión
if (!$conn || $conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Leer JSON desde fetch
$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['id'])) {
    $id = $data['id'];

    // Iniciar transacción
    $conn->begin_transaction();

    // Buscar reservaciones relacionadas
    $stmtC = $conn->prepare("SELECT clase, alumno, invitado FROM reservaciones WHERE idClase = ?");
    if ($stmtC) {
        $stmtC->bind_param("i", $id);
        if ($stmtC->execute()) {
            $resultC = $stmtC->get_result();

            if ($resultC && $resultC->num_rows > 0) {
                // Hay reservaciones: devolver créditos y enviar mail
                $stmtA = $conn->prepare("SELECT mail, numero FROM users WHERE id = ?");
                $stmtUR = $conn->prepare("UPDATE users SET credit = credit + ? WHERE id = ?");

                if ($stmtA && $stmtUR) {
                    while ($rowC = $resultC->fetch_assoc()) {
                        $client = $rowC['alumno'];
                        $invitado = $rowC['invitado'];
                        $lnum = $invitado + 1;
                        $clase = $rowC['clase'];

                        $stmtUR->bind_param("ii", $lnum, $client);
                        if (!$stmtUR->execute()) {
                            $conn->rollback();
                            echo "Error al devolver créditos: " . $stmtUR->error;
                            exit;
                        }

                        $stmtA->bind_param("i", $client);
                        $stmtA->execute();
                        $resultA = $stmtA->get_result();

                        if ($rowA = $resultA->fetch_assoc()) {
                            $mail_mailing = $rowA['mail'];
                            $mail_asunto = "Reservación Cancelada";
                            $mail_motivo = "Reservación de $clase";
                            $mail_motivo2 = "Tu reservación de tu clase fue cancelada, y tus créditos serán devueltos.";
                            $mail_descripcion = "Si no reconoces esta operación, favor de reportarla al área de administración.";
                            $mail_tabla = " ";
                            include '../success_mail.php';
                        }
                    }

                    // Eliminar reservaciones
                    $stmtDelRes = $conn->prepare("DELETE FROM reservaciones WHERE idClase = ?");
                    if ($stmtDelRes) {
                        $stmtDelRes->bind_param("i", $id);
                        if (!$stmtDelRes->execute()) {
                            $conn->rollback();
                            echo "Error al eliminar reservaciones: " . $stmtDelRes->error;
                            exit;
                        }
                        $stmtDelRes->close();
                    } else {
                        $conn->rollback();
                        echo "Error al preparar DELETE reservaciones: " . $conn->error;
                        exit;
                    }

                    if ($stmtUR) $stmtUR->close();
                    if ($stmtA) $stmtA->close();

                } else {
                    $conn->rollback();
                    echo "Error al preparar consultas UPDATE o SELECT users: " . $conn->error;
                    exit;
                }
            }

            // Siempre intentamos eliminar la clase, haya o no reservas
            $stmt = $conn->prepare("DELETE FROM clases WHERE id = ?");
            if ($stmt) {
                $stmt->bind_param("i", $id);
                if ($stmt->execute()) {
                    $conn->commit();
                    echo "Clase eliminada";
                } 
                $stmt->close();
            } else {
                $conn->rollback();
                echo "Error al preparar DELETE clases: " . $conn->error;
            }

        } else {
            $conn->rollback();
            echo "Error al ejecutar consulta SELECT reservaciones: " . $stmtC->error;
        }
        $stmtC->close();
    } else {
        $conn->rollback();
        echo "Error al preparar SELECT reservaciones: " . $conn->error;
    }

} else {
    echo "ID no recibido";
}

$conn->close();
?>


