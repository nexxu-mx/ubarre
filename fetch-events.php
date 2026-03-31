<?php
include 'db.php';

if ($conn->connect_error) {
  die("Conexión fallida: " . $conn->connect_error);
}

session_start();
$id = $_SESSION['idUser'];
date_default_timezone_set('America/Mexico_City');

// Obtener y formatear los parámetros de la URL
$start = isset($_GET['start']) ? date('Y-m-d H:i:s', strtotime($_GET['start'])) : null;
$end = isset($_GET['end']) ? date('Y-m-d H:i:s', strtotime($_GET['end'])) : null;

// Validar fechas
if (!$start || !$end) {
  http_response_code(400);
  echo json_encode(["error" => "Fechas inválidas"]);
  exit;
}

function generarToken16Digitos() {
  $token = '';
  for ($i = 0; $i < 32; $i++) {
      $token .= random_int(0, 9);
  }
  return $token;
}

// CONSULTA CON FILTRO DE FECHAS  
$sql = "SELECT id, alumno, clase, idClase, instructor, invitado, activo, dura, inicio, fin, fechaReserva, sabor, momento, en_espera
        FROM reservaciones 
        WHERE alumno = ? AND inicio BETWEEN ? AND ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iss", $id, $start, $end);
$stmt->execute();
$result = $stmt->get_result();
$stmtC = $conn->prepare("SELECT aforo, reservados FROM clases WHERE id = ?");
$eventos = [];

while ($row = $result->fetch_assoc()) {
  $token = generarToken16Digitos();
  $invitado = $row["invitado"] ?? "0";
  $idClase = $row["idClase"];
  $en_espera = $row["en_espera"]; 

  $cancelable = (strtotime($row["inicio"]) - time()) > 21600 ? true : false;


  $stmtC->bind_param("i", $idClase);
  $stmtC->execute();
  $resultC = $stmtC->get_result();

  if ($resultC->num_rows === 0) {
      echo json_encode(["error" => "clase no encontrada"]);
  } else {
      $rowC = $resultC->fetch_assoc();
      $aforo = $rowC['aforo'];
      $reservados = $rowC['reservados'];
  }

  $aforo_str = $reservados . "/" . $aforo;
  $res = intval(trim($reservados));
  $af = intval(trim($rowC['aforo']));
  //logica para invitar solo con planes


  $sqlU = "SELECT maxInvitados FROM users WHERE id = ?";
  $stmtU = $conn->prepare($sqlU);
  $stmtU->bind_param("i", $id);
  $stmtU->execute();
  $resultU = $stmtU->get_result();
  
  if($resultU->num_rows > 0){
      $rowU = $resultU->fetch_assoc();
      $mi = $rowU['maxInvitados'];
    
      if(empty($mi)){
          $invitable = false;
      }else{
         if($invitado < $mi){
           $invitable = $res < $af ? true : false;
          }else{
              $invitable = false;
          } 
      }
      
  }else{
      $invitable = false;
  }
  
  //LÓGICA DE LISTA DE ESPERA
  if ($en_espera == 1) {
      // Si está en espera: NO hay QR y no puede invitar
      $qr = ""; 
      $invitable = false; 
      // Puedes poner un ícono de reloj o texto naranja para que el usuario entienda
      $estatus = '<span style="color: #d97706; font-weight: bold; font-size: 12px; line-height: 12px; display: flex; align-items: center; gap: 5px;"><img src="assets/images/wait.svg" style="width: 15px;"> En espera</span>';
  } else {
      // Si está confirmado: Generamos el QR 
      $qr = $row["id"] . '-' . $token . '-' . $row["alumno"] . '-' . $invitado . '-' . $row["activo"];
      $estatus = '<img class="icono-reserva" src="assets/images/svg/reservado.svg" alt="Clase reservada ícono">';
  }
  
  $eventos[] = [
    "id" => $row["id"],
    "title" => $row["clase"],
    "instructor" => $row["instructor"],
    "invitado" => $invitado,
    "qr" => $qr, 
    "aforo" => $aforo_str,
    "estatus" => $estatus, 
    "alumno" => $row["alumno"],
    "dura" => $row["dura"],
    "cancelable" => $cancelable,
    "classID" => $row["idClase"],
    "invitable" => $invitable,
    "start" => $row["inicio"],
    "end" => $row["fin"],
    "sabor"=> $row["sabor"],
    "momento"=> $row["momento"],
    "en_espera" => $en_espera 
  ];
}
$stmtC->close();
header('Content-Type: application/json');
echo json_encode($eventos);
?>
