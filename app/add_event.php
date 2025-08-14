<?php
include '../db.php';

$data = json_decode(file_get_contents("php://input"), true);
$response = ['success' => false, 'results' => []];

// Normalizamos: si viene un solo evento, lo convertimos en array
$eventos = isset($data[0]) ? $data : [$data];

foreach ($eventos as $evento) {
    $title = $conn->real_escape_string($evento['title']);
    $start = $conn->real_escape_string($evento['start']);
    $end = $conn->real_escape_string($evento['end']);
    $horaInicio = $conn->real_escape_string($evento['horain']);
    $horaFin = $conn->real_escape_string($evento['horafin']);
    $aforo = $conn->real_escape_string($evento['aforo']);
    $coach = $conn->real_escape_string($evento['coach']);
    $estatus = 1;
    $reservado = 0;

    $hora_inicio = $start . ' ' . $horaInicio . ':00';
    $hora_fin = $end . ' ' . $horaFin . ':00';

    $timestamp_inicio = strtotime($hora_inicio);
    $timestamp_fin = strtotime($hora_fin);

    if ($timestamp_fin > $timestamp_inicio) {
        $sql = "INSERT INTO clases (id_coach, hora_inicio, hora_fin, aforo, reservados, id_disciplina, estatus) 
                VALUES ('$coach', '$hora_inicio', '$hora_fin', '$aforo', '$reservado', '$title', '$estatus')";
        $result = $conn->query($sql);
        $response['results'][] = $result ? 'ok' : 'error';
    } else {
        $response['results'][] = 'hora inválida';
    }
}

// Si al menos uno se insertó correctamente
$response['success'] = in_array('ok', $response['results']);

header('Content-Type: application/json');
echo json_encode($response);
?>
