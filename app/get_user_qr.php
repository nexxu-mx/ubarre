<?php
header('Content-Type: application/json');

$input = json_decode(file_get_contents("php://input"), true);
$token_id = $input['cadena'] ?? null;

if (!$token_id) {
  echo json_encode(["error" => "user_id no proporcionado"]);
  exit;
}
$partes = explode("-", $token_id);

$id_event = $partes[0]; // id
$token = $partes[1]; // token
$id_user = $partes[2]; // id user
$invitados = $partes[3]; // invitado
$activo = $partes[4]; // activo
require '../db.php'; // aquí incluyes tu conexión con $conn

$stmt = $conn->prepare("SELECT nombre, apellido FROM users WHERE id = ?");
$stmt->bind_param("i", $id_user);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    $name = $row['nombre'] . " " . $row['apellido'];
    $stmtC = $conn->prepare("SELECT clase, dura, instructor, invitado, activo, inicio FROM reservaciones WHERE id = ?");
    $stmtC->bind_param("i", $id_event);
    $stmtC->execute();
    $resultC = $stmtC->get_result();
    if ($rowC = $resultC->fetch_assoc()) {
        $stmtR = $conn->prepare("UPDATE reservaciones SET asiste = 1 WHERE id = ?");
        $stmtR->bind_param("i", $id_event);
    
        if ($stmtR->execute()) {
            if($rowC['activo'] == 1){
                $asisten = [
                    "id" => $id_event,
                    "name" => $name,
                    "clase" => $rowC["clase"],
                    "duracion" => $rowC["dura"],
                    "instructor" => $rowC["instructor"],
                    "invitados" => $rowC["invitado"],
                    "inicia" => $rowC["inicio"]
                  ];
            }
        }
        

        

        echo json_encode($asisten);
    } else {
        echo json_encode(["error" => "Reserva no registrada"]);
    }
  
} else {
  echo json_encode(["error" => "Usuario no encontrado"]);
}
?>
