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
$sql = "SELECT id, alumno, clase, idClase, instructor, invitado, activo, dura, inicio, fin, fechaReserva 
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

  $qr = $row["id"] . '-' . $token . '-' . $row["alumno"] . '-' . $invitado . '-' . $row["activo"];
  $aforo = $reservados . "/" . $aforo;

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
  
  
//agregar logica para invitar solo con planes compartidos

  $estatus = '<svg xmlns="http://www.w3.org/2000/svg" class="ionicon clase-en-curso-punto" viewBox="0 0 512 512">
                <defs><style>.ionicon { fill: #986C5D; }</style></defs>
                <title>Ellipse</title>
                <path d="M256 464c-114.69 0-208-93.31-208-208S141.31 48 256 48s208 93.31 208 208-93.31 208-208 208z"></path>
              </svg>';
  $estatus = '<img class="icono-reserva" src="assets/images/svg/reservado.svg"
                                    alt="Clase reservada ícono">';
  
  $eventos[] = [
    "id" => $row["id"],
    "title" => $row["clase"],
    "instructor" => $row["instructor"],
    "invitado" => $invitado,
    "qr" => $qr,
    "aforo" => $aforo,
    "estatus" => $estatus,
    "alumno" => $row["alumno"],
    "dura" => $row["dura"],
    "cancelable" => $cancelable,
    "classID" => $row["idClase"],
    "invitable" => $invitable,
    "start" => $row["inicio"],
    "end" => $row["fin"]
  ];
}
$stmtC->close();
header('Content-Type: application/json');
echo json_encode($eventos);
?>
