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
$sql = "SELECT id, alumno, clase, instructor, invitado, activo, dura, inicio, fin, fechaReserva 
        FROM reservaciones 
        WHERE idInstructor = ? AND inicio BETWEEN ? AND ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iss", $id, $start, $end);
$stmt->execute();
$result = $stmt->get_result();

$eventos = [];

while ($row = $result->fetch_assoc()) {
  $token = generarToken16Digitos();
  $invitado = $row["invitado"] ?? "0";

  $cancelable = (time() - $row["fechaReserva"]) > 7200 ? false : true;

  $aforo = "9/14";
  $estatus = '<svg xmlns="http://www.w3.org/2000/svg" class="ionicon clase-en-curso-punto" viewBox="0 0 512 512">
                <defs><style>.ionicon { fill: #986C5D; }</style></defs>
                <title>Ellipse</title>
                <path d="M256 464c-114.69 0-208-93.31-208-208S141.31 48 256 48s208 93.31 208 208-93.31 208-208 208z"></path>
              </svg>'; 

    $alumnos = '
                <ul class="al1">
                <p class="al">Asistentes</p>
                    <li class="al2">Andrea</li>
                    <li class="al2">Jimena</li>
                    <li class="al2">Marcela</li>
                    <li class="al2">Andrea</li>
                    <li class="al2">Jimena</li>
                    <li class="al2">Marcela</li>
                    <li class="al2">Andrea</li>
                </ul>';
                
  $eventos[] = [
    "id" => $row["id"],
    "title" => $row["clase"],
    "instructor" => $row["instructor"],
    "invitado" => $invitado,
    "aforo" => $aforo,
    "estatus" => $estatus,
    "alm" => $alumnos,
    "dura" => $row["dura"],
    "cancelable" => $cancelable,
    "start" => $row["inicio"],
    "end" => $row["fin"]
  ];
}

header('Content-Type: application/json');
echo json_encode($eventos);
?>
