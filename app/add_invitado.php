<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["evento"])) {
    include("../db.php"); 

    $id = intval($_POST["evento"]);
    $classID = intval($_POST['classID']);
    $alumno = intval($_POST["usuario"]);

    // Verificar créditos
    $stmtCredit = $conn->prepare("SELECT credit FROM users WHERE id = ?");
    $stmtCredit->bind_param("i", $alumno);
    $stmtCredit->execute();
    $resultCredit = $stmtCredit->get_result();

    if ($resultCredit->num_rows === 0) {
        echo "Error al verificar créditos.";
        exit;
    } else {
        $rowCredit = $resultCredit->fetch_assoc();
        $creditDisponible = $rowCredit['credit'];

        if ($creditDisponible <= 0) {
            echo json_encode(["status" => "nocredit"]);
            exit;
        }
    }

    // Aumentar aforo de la clase
    $stmtR = $conn->prepare("UPDATE clases SET reservados = reservados + 1 WHERE id = ?");
    $stmtR->bind_param("i", $classID);

    if ($stmtR->execute()) {
        // Disminuir crédito y aumentar invitado
        $stmtUR = $conn->prepare("UPDATE users SET credit = credit - 1 WHERE id = ?");
        $stmtUR->bind_param("i", $alumno);

        
        if ($stmtUR->execute()) {
            $stmtUI = $conn->prepare("UPDATE reservaciones SET invitado = invitado + 1 WHERE id = ?");
            $stmtUI->bind_param("i", $id);
            if ($stmtUI->execute()) {
                echo json_encode(['status' => "success"]);

            }
        } else {
            echo "Error Fx002994";
        }

        $stmtUR->close();
    } else {
        echo "Error Fx002994";
    }

    // Cerrar statements y conexión
    $stmtCredit->close();
    $stmtR->close();
    $conn->close();
} else {
    echo "Reintentar más tarde.";
}
?>
