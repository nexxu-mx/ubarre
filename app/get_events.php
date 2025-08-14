<?php
include '../db.php';
include '../error_log.php';

$sql = "SELECT id, id_coach, aforo, reservados, id_disciplina, hora_inicio, hora_fin FROM clases";
$result = $conn->query($sql);
$stmtD = $conn->prepare("SELECT nombre_disciplina FROM disciplinas WHERE id = ?");
$stmtC = $conn->prepare("SELECT nombre_coach FROM coaches WHERE id = ?");
$sqlA = "SELECT 
            users.nombre, 
            reservaciones.id AS reservacion_id, 
            reservaciones.alumno, 
            reservaciones.invitado
         FROM reservaciones 
         INNER JOIN users ON reservaciones.alumno = users.id 
         WHERE reservaciones.idClase = ?";


$events = [];
while ($row = $result->fetch_assoc()) {

    $stmtD->bind_param("i", $row['id_disciplina']);
    $stmtD->execute();
    $resultD = $stmtD->get_result();
    if ($rowD = $resultD->fetch_assoc()) {
        $disciplina = $rowD['nombre_disciplina'];
    } else {
        $disciplina = "Sin Disciplina";
    }
    $stmtC->bind_param("i", $row['id_coach']);
    $stmtC->execute();
    $resultC = $stmtC->get_result();
    if ($rowC = $resultC->fetch_assoc()) {
        $coach = $rowC['nombre_coach'];
    } else {
        $coach = "Sin Coach";
    }
    $aforo = $row['reservados'] . "/" . $row['aforo'];
         $start = new DateTime($row['hora_inicio']);
        $end = new DateTime($row['hora_fin']);
        $diff = $start->diff($end);

    if($row['reservados'] > $row['aforo']){
        $open = false;
    }else{
        $open = true;
    }
    // Convertir la duración a minutos totales
    $minutosTotales = ($diff->h * 60) + $diff->i;

    // Formatear la duración
    if ($minutosTotales <= 60) {
        $dura = $minutosTotales . " min";
    } else {
        $horas = floor($minutosTotales / 60);
        $minutos = $minutosTotales % 60;
        $dura = $horas . ":" . str_pad($minutos, 2, "0", STR_PAD_LEFT) . " h";
    }   
// lista de alumnos
    $stmtA = $conn->prepare($sqlA);
    $stmtA->bind_param("i", $row['id']);
    $stmtA->execute();
    $resultA = $stmtA->get_result();
    // Imprimir lista
    $alumnos = "<ul>";
   
    while ($rowA = $resultA->fetch_assoc()) {
        $name = htmlspecialchars($rowA['nombre']);
        $idEvent = $row['id'];
        $Ndisciplina = "'$disciplina'";
        $a1 = $rowA['reservacion_id'];
        $a2 = $rowA['alumno'];
        $a3 = $rowA['invitado'];
    
        $onclick = "cancelReserv($a1,$a2,$idEvent,$a3,'$disciplina')";
        $onclick2 = "addInvitado($a1,$a2,$idEvent)";
        $asistencia = 1 + $rowA['invitado'];
        $alumnos.= '<li style="display: flex;justify-content: space-between;"><p>' . $name . ' (x' . $asistencia . ')</p><div style="display: flex;gap: 10px;"><i class="fas fa-trash-alt trash" onclick="' . $onclick . '"></i> <i class="fas fa-user-plus add" onclick="' . $onclick2 . '"></i></div></li>';
    }
    $alumnos .= "</ul>";

  $events[] = [
    'id' => $row['id'],
    'title' => $disciplina,
    'coach' => $coach,
    'aforo' => $aforo,
    'dura' => $dura,
    'alumnos' => $alumnos,
    'start' => $row['hora_inicio'],
    'end' => $row['hora_fin'],
    'idcoach' => $row['id_coach'],
    'open' => $open
    
  ];
}

header('Content-Type: application/json');
echo json_encode($events);
?>
