<?php
header('Content-Type: application/json');

include '../db.php';
include '../error_log.php';

try {
  
    
    // Verificar que se recibió el ID de la transacción
    if (!isset($_POST['idpago']) || empty($_POST['idpago'])) {
        echo json_encode(['success' => false, 'message' => 'ID de transacción no proporcionado']);
        exit;
    }
    
    $idPago = $_POST['idpago'];
    
    // Validar que el ID es numérico
    if (!is_numeric($idPago)) {
        echo json_encode(['success' => false, 'message' => 'ID de transacción inválido']);
        exit;
    }
    
    // Verificar si la transacción existe antes de eliminarla
        $sql1 = "SELECT user, creditos FROM transacciones WHERE id = ?";
        $stm1 = $conn->prepare($sql1);
        $stm1->bind_param("i", $idPago);
        $stm1->execute();
        $result1 = $stm1->get_result();

        if ($result1->num_rows > 0) {
            $row1 = $result1->fetch_assoc();

            $user_id = $row1['user'];
            $creditos = $row1['creditos'];

            // Verificar crédito actual del usuario
            $sql2 = "SELECT credit FROM users WHERE id = ?";
            $stm2 = $conn->prepare($sql2);
            $stm2->bind_param("i", $user_id);
            $stm2->execute();
            $result2 = $stm2->get_result();
            $row2 = $result2->fetch_assoc();

            $saldo_actual = $row2['credit'];

            if ($saldo_actual > $creditos) {
                // Restar créditos
                $sql3 = "UPDATE users SET credit = credit - ? WHERE id = ?";
                $stm3 = $conn->prepare($sql3);
                $stm3->bind_param("ii", $creditos, $user_id);
                $stm3->execute();

                // Preparar la consulta para eliminar la transacción
                    $stmt = $conn->prepare("DELETE FROM transacciones WHERE id = ?");
                    $stmt->bind_param("i", $idPago);

                    // Ejecutar la consulta
                    if ($stmt->execute()) {
                        $rowsAffected = $stmt->affected_rows; // En MySQLi es affected_rows
                        
                        if ($rowsAffected > 0) {
                            echo json_encode(['success' => true, 'message' => 'Transacción eliminada (Se restaron los créditos)']);
                        } else {
                            echo json_encode(['success' => false, 'message' => 'No se pudo eliminar la transacción']);
                        }
                    } else {
                        echo json_encode(['success' => false, 'message' => 'Error al ejecutar la consulta']);
                    }

            } else {
                    
               // Preparar la consulta para eliminar la transacción
                $stmt = $conn->prepare("DELETE FROM transacciones WHERE id = ?");
                $stmt->bind_param("i", $idPago);

                // Ejecutar la consulta
                if ($stmt->execute()) {
                    $rowsAffected = $stmt->affected_rows; // En MySQLi es affected_rows
                    
                    if ($rowsAffected > 0) {
                        echo json_encode(['success' => true, 'message' => 'Transacción eliminada (Saldo Insuficiente)']);
                    } else {
                        echo json_encode(['success' => false, 'message' => 'No se pudo eliminar la transacción']);
                    }
                } else {
                    echo json_encode(['success' => false, 'message' => 'Error al ejecutar la consulta']);
                }

            }
        } else {
            echo json_encode(['success' => false, 'message' => 'La transacción no existe']);
            exit;
        }



    
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Error de base de datos: ' . $e->getMessage()]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
}
?>