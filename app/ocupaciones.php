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
    // Ejemplo: 2025-10/2025-18
    $partes = explode("/", $_GET['periodo']);
    if (count($partes) == 2) {
        $fechaInicio = $partes[0]; // primera parte
        $fechaFin = $partes[1];    // segunda parte
    } else {
        // fallback si el formato no es válido
        $fechaInicio = date("Y-m-d", strtotime("-7 days"));
        $fechaFin = date("Y-m-d");
    }
} else {
    // Última semana por defecto
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

        // === 3. Consultar clases de este coach en el periodo ===
        $sqlClases = "
            SELECT id, hora_inicio, hora_fin, reservados
            FROM clases
            WHERE id_coach = '$id_coach'
              AND DATE(hora_inicio) BETWEEN '$fechaInicio' AND '$fechaFin'
        ";
        $resClases = $conn->query($sqlClases);

        $total_clases = 0;
        $total_reservas = 0;
        $total_horas = 0;
        $idsClases = [];

        if ($resClases && $resClases->num_rows > 0) {
            while ($clase = $resClases->fetch_assoc()) {
                $total_clases++;
                $total_reservas += (int)$clase['reservados'];

                $inicio = strtotime($clase['hora_inicio']);
                $fin = strtotime($clase['hora_fin']);
                $total_horas += ($fin - $inicio) / 3600; // diferencia en horas

                $idsClases[] = $clase['id'];
            }
        }
        
        // === 4. Consultar asistencias en reservaciones ===
        $total_asistencias = 0;
        if (!empty($idsClases)) {
            $idsStr = implode(",", $idsClases);
            $sqlAsist = "
                SELECT asiste
                FROM reservaciones
                WHERE idClase IN ($idsStr)
            ";
            $resAsist = $conn->query($sqlAsist);

            if ($resAsist && $resAsist->num_rows > 0) {
                while ($res = $resAsist->fetch_assoc()) {
                    if (!is_null($res['asiste'])) {
                        $total_asistencias += (int)$res['asiste'];
                    }
                }
            }
        }

        // === 5. Guardar resultados ===
        $ocupacion[] = [
            "coach" => $nombre_coach,
            "clases" => $total_clases,
            "reservas" => $total_reservas,
            "asistencias" => $total_asistencias,
            "horas_totales" => round($total_horas, 2)
        ];
    }
} else {
    $ocupacion = [];
}

$conn->close();

// Devolver la respuesta en formato JSON
echo json_encode($ocupacion);
