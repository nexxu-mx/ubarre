<?php
include 'error_log.php';
include('../db.php');
date_default_timezone_set('America/Mexico_City');
header('Content-Type: application/json');

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// === 1. Obtener el periodo de fechas ===
if (!empty($_GET['periodo'])) {
    $partes = explode("/", $_GET['periodo']);
    if (count($partes) == 2) {
        $fechaInicio = $partes[0];
        $fechaFin = $partes[1];
    } else {
        $fechaInicio = date("Y-m-d", strtotime("-7 days"));
        $fechaFin = date("Y-m-d");
    }
} else {
    $fechaInicio = date("Y-m-d", strtotime("-7 days"));
    $fechaFin = date("Y-m-d");
}

// === 2. Consultar coaches ===
$sql = "SELECT id, nombre_coach FROM coaches";
$result = $conn->query($sql);

$ocupacion = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $id_coach = $row['id'];
        $nombre_coach = $row['nombre_coach'];

        if (empty($id_coach)) {
            continue;
        }

        // === 3. Consultar clases de este coach en el periodo con nombre de disciplina ===
        $sqlClases = "
            SELECT c.id, c.hora_inicio, c.hora_fin, c.reservados, d.nombre_disciplina AS disciplina
            FROM clases c
            LEFT JOIN disciplinas d ON c.id_disciplina = d.id
            WHERE c.id_coach = '$id_coach'
              AND DATE(c.hora_inicio) BETWEEN '$fechaInicio' AND '$fechaFin'
        ";
        $resClases = $conn->query($sqlClases);

        $total_clases = 0;
        $total_reservas = 0;
        $total_horas = 0;
        $total_asistencias = 0;
        $listaClases = [];

        if ($resClases && $resClases->num_rows > 0) {
            while ($clase = $resClases->fetch_assoc()) {
                $total_clases++;
                $total_reservas += (int)$clase['reservados'];

                $inicio = strtotime($clase['hora_inicio']);
                $fin = strtotime($clase['hora_fin']);
                $total_horas += ($fin - $inicio) / 3600;

                // === 4. Consultar reservaciones con datos de alumnos ===
                $alumnos = [];
                $sqlReserv = "
                    SELECT r.alumno, r.asiste, u.nombre AS nombre_alumno
                    FROM reservaciones r
                    LEFT JOIN users u ON r.alumno = u.id
                    WHERE r.idClase = '".$clase['id']."'
                ";
                $resReserv = $conn->query($sqlReserv);

                if ($resReserv && $resReserv->num_rows > 0) {
                    while ($res = $resReserv->fetch_assoc()) {
                        if (!is_null($res['asiste']) && (int)$res['asiste'] === 1) {
                            $total_asistencias++;
                        }

                        $alumnos[] = [
                            "id" => $res['alumno'],
                            "nombre" => $res['nombre_alumno'],
                            "asistencia" => ((int)$res['asiste'] === 1)
                        ];
                    }
                }

                // Agregar clase con lista de alumnos y nombre de disciplina
                $listaClases[] = [
                    "disciplina" => $clase['disciplina'],   // 👈 ahora mostramos la disciplina
                    "hora_inicio" => $clase['hora_inicio'],
                    "hora_fin" => $clase['hora_fin'],
                    "reservados" => (int)$clase['reservados'],
                    "asistentes" => $total_asistencias,
                    "alumnos" => $alumnos
                ];
            }
        }

        // === 5. Guardar resultados ===
        $ocupacion[] = [
            "coach" => $nombre_coach,
            "clases" => $total_clases,
            "reservas" => $total_reservas,
            "asistencias" => $total_asistencias,
            "horas_totales" => round($total_horas, 2),
            "detalle_clases" => $listaClases
        ];
    }
} else {
    $ocupacion = [];
}

$conn->close();

// Devolver la respuesta en formato JSON
echo json_encode($ocupacion, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
