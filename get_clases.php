<?php
header('Content-Type: application/json');
date_default_timezone_set('America/Mexico_City');
include 'error_log.php';
include 'db.php';
session_start();
if (isset($_SESSION['idUser'])) {
    $idUser = $_SESSION['idUser'];
}

$day = $_GET['day'] ?? '';
if ($day) {
    // Separar el día y el mes
    list($d, $mesTexto) = explode("-", strtolower($day));

    // Mapeo manual de meses en español a números
    $meses = [
        "enero" => "01",
        "febrero" => "02",
        "marzo" => "03",
        "abril" => "04",
        "mayo" => "05",
        "junio" => "06",
        "julio" => "07",
        "agosto" => "08",
        "septiembre" => "09",
        "octubre" => "10",
        "noviembre" => "11",
        "diciembre" => "12"
    ];

    // Obtener el número del mes
    $mesNumero = $meses[$mesTexto] ?? "00"; // por si no coincide
    // Armar la fecha completa
    $fecha = "2025-$mesNumero-" . str_pad($d, 2, "0", STR_PAD_LEFT);
    $dia = "$fecha%";
    $stmt = $conn->prepare("SELECT id, id_coach, hora_inicio, hora_fin, aforo, reservados, id_disciplina, estatus FROM clases WHERE hora_inicio LIKE ? ORDER BY hora_inicio ASC");
    $stmt->bind_param("s", $dia);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmtC = $conn->prepare("SELECT nombre_coach FROM coaches WHERE id = ?");
    $stmtD = $conn->prepare("SELECT nombre_disciplina FROM disciplinas WHERE id = ?");
    $stmtU = $conn->prepare("SELECT activo FROM reservaciones WHERE alumno = ? AND idClase = ?");
    $clases = [];
    while ($row = $result->fetch_assoc()) {
        $id_coach = $row['id_coach'];
        $stmtC->bind_param("i", $id_coach);
        $stmtC->execute();
        $resultC = $stmtC->get_result();

        if ($coach = $resultC->fetch_assoc()) {
            $nombre_coach =  $coach['nombre_coach'];
        } else {
            $nombre_coach = "-";
        }

        $id_disciplina = $row['id_disciplina'];
        $stmtD->bind_param("i", $id_disciplina);
        $stmtD->execute();
        $resultD = $stmtD->get_result();

        if ($disciplina = $resultD->fetch_assoc()) {
            $nombre_disciplina =  $disciplina['nombre_disciplina'];
        } else {
            $nombre_disciplina = "-";
        }



        $abierta = 1;

        //estatus clase en abierta para reserva
        $estatus = '<svg xmlns="http://www.w3.org/2000/svg" class="ionicon clase-en-curso-punto"
                viewBox="0 0 512 512">
                <defs>
                    <style>
                        .ionicon {
                            fill:rgb(0, 175, 6);
                        }
                    </style>
                </defs>
                <title>Ellipse</title>
                <path
                    d="M256 464c-114.69 0-208-93.31-208-208S141.31 48 256 48s208 93.31 208 208-93.31 208-208 208z" />
            </svg>';

        $aforo = $row['reservados'] . '/' . $row['aforo'];

        if ($row['aforo'] <= $row['reservados']) {
            //estatus clase cerrada para reserva por cupo complet 
            $estatus = '<img class="icono-reserva" src="assets/images/svg/full_class.svg" alt="Clase llena ícono"><p>Clase llena</p>';
            $abierta = 0;
        }
        // Crear objetos DateTime
        $start = new DateTime($row['hora_inicio']);
        $end = new DateTime($row['hora_fin']);
        $now = new DateTime();

        // Calcular diferencia
        $diff = $start->diff($end);
        $duracionMin = ($diff->h * 60) + $diff->i;

        // Mostrar duración en formato deseado
        if ($duracionMin <= 60) {
            $duracionTexto = "$duracionMin min";
        } else {
            $horas = floor($duracionMin / 60);
            $minutos = $duracionMin % 60;
            $duracionTexto = $minutos > 0 ? "$horas:$minutos h" : "$horas:00 h";
        }

        $esPasado = $start < $now;
        if ($now >= $start && $now <= $end) {
            //estatus clase en curso
            $estatus = '<svg class="icono-clase-en-curso" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 213.35 311.78">
                                        <defs>
                                            <style>
                                                .cls-1 {
                                                    fill: #8B976A;
                                                }
                                            </style>
                                        </defs>
                                        <g id="Capa_2" data-name="Capa 2">
                                            <g id="Capa_1-2" data-name="Capa 1">
                                                <path class="cls-1" d="M95.34,0c20.12,0,35.81,16.09,35.81,34.2S119.08,64.78,103,64.78c-19.72,0-35.41-15.69-35.41-34.6C67.58,12.07,79.65,0,95.34,0" />
                                                <path class="cls-1" d="M21.88,95C7,99.84-3.27,112.79,1,130.26c2.61,10.79,9.24,20.43,27.62,26.75,6,2.05,8.77,2.77,15.92,5,33.8,10.57,76.18,23.15,101.93,38.31,32.41,19.11,39.27,35.47,34.28,46.83a.07.07,0,0,1,0,0c-5.74,9-15.28,6.47-24.7,2.91-8.26-3.86-78.44-36-101.92-33.35C32.75,219.16,23.82,232.7,26,253.25A50.23,50.23,0,0,0,41,282l.19.18C55.16,296.64,75.45,310,75.45,310a16.4,16.4,0,0,0,21-5.46l.08-.11a17,17,0,0,0,2.73-12.18,16.81,16.81,0,0,0-5.68-10.11L62.89,258.29a3.81,3.81,0,0,1-1.74-2.91l0-.16a3.66,3.66,0,0,1,3-4.05c5.88-1.15,45.56,16,82.21,33.17a97.9,97.9,0,0,0,13.43,5.16c4.71,1.41,16.06,3.59,27.26-.81,13.5-5.3,20-17.58,20.29-18.05,5.37-8.86,7.16-21,5.35-36,0,0-2.32-32.22-26.75-52.64a147.28,147.28,0,0,0-31.49-19.62c-13.58-6.43-59.28-20.23-78.33-25.87-5-1.23-18.74-5.79-19.22-6.1a1.25,1.25,0,0,1-.4-1.85c.22-.26.78-.4,1.75-.35l11.17.74s0,0,0,0l117.11,3.72a2.22,2.22,0,0,0,1.7-.83,2,2,0,0,0,.41-1.66l-7-35.47a2.08,2.08,0,0,0-2.1-1.65c-5.17,0-124.19.08-142.47.09A56.91,56.91,0,0,0,21.88,95" />
                                            </g>
                                        </g>
                                    </svg>
                                    <p>Clase en Curso</p>';
        } elseif ($now < $start) {
            if ($abierta == 1) {
                //estatus clase en abierta para reserva
                $estatus = '<div style="width: 10px;height: 10px;border-radius: 50%;background: green;"></div>';
            }
        } elseif ($start < $now) {
            $estatus = '<img src="./assets/images/svg/full_class.svg">
                        <p>Clase llena</p>';
            $abierta = 0;
            continue;
        }

        // Formatear horario en formato AM/PM
        $horario = $start->format("g:i A") . " - " . $end->format("g:i A");
        $duracion = $duracionTexto;

        if (isset($idUser)) {
            //validara la reserva del usuario
            $idClase = $row['id'];
            $stmtU->bind_param("ii", $idUser, $idClase);
            $stmtU->execute();
            $resultU = $stmtU->get_result();

            if ($Alumno = $resultU->fetch_assoc()) {
                $estatus = '<img class="icono-reserva" src="assets/images/svg/reservado.svg" alt="Clase reservada ícono"><p>Clase reservada</p>';
                $abierta = 0;
            }
        }
        if ($row['estatus'] == 2) {
            //estatus clase en lista de espera
            $estatus = '<img class="icono-reserva" src="assets/images/svg/waiting_list.svg" alt="Wait List ícono">';
        }

        if($abierta == 1){
            /// Anticipación para reservar
            $hoy = new DateTime('today');
            $manana = new DateTime('tomorrow');
            $resw = "";

            // 🔹 Nuevo caso: hoy antes de las 3:00 pm -> bloqueado
            $limiteHoy = (clone $hoy)->setTime(12, 0); // hoy a las 3:00pm
            if ($start->format('Y-m-d') === $hoy->format('Y-m-d') && $start < $limiteHoy) {
                if ($row['reservados'] < 2) {
                        $abierta = 0;
                        $resw = "*Puedes reservar por WhatsApp.";
                    } 
            }

            // 🔹 Caso 1: $start es mañana antes de las 12:00pm
            $limite1 = (clone $hoy)->setTime(22, 30); // hoy a las 10:30pm
            if ($start->format('Y-m-d') === $manana->format('Y-m-d') && $start->format('H') < 12) {
                if ($now <= $limite1) {
                    
                } else {
                    if ($row['reservados'] < 2) {
                        $abierta = 0;
                        $resw = "*Puedes reservar por WhatsApp.";
                    } 
                }
            }

         // 🔹 Caso: $start es hoy después de las 12:00pm
            $limite = (clone $hoy)->setTime(12, 0); // hoy a las 12:00pm
            $unaHoraAntes = (clone $start)->modify('-1 hour'); // límite 1 hora antes del evento

            if ($start->format('Y-m-d') === $hoy->format('Y-m-d') && $start >= $limite) {
                
                // Si falta menos de una hora, se cierra
                if ($now >= $unaHoraAntes) {
                    if($row['reservados'] < 2){
                            $abierta = 0;
                            $resw = "*Puedes reservar por WhatsApp.";
                        }
                } 
            }

        }


        $clases[] = [
            "id" => $row['id'],
            "id_coach" => $row['id_coach'],
            "nombre_coach" => $nombre_coach,
            "horario" => $horario,
            "duracion" => $duracion,
            "aforo" => $aforo,
            "estatus" => $estatus,
            "disciplina" => $nombre_disciplina,
            "id_disciplina" => $row['id_disciplina'],
            "abierta" => $abierta,
            "close_whats" => $resw
        ];
    }
    $stmtC->close();
    $stmtD->close();
    echo json_encode($clases);
} else {
    echo json_encode([]);
}
