<?php
header('Content-Type: application/json');
date_default_timezone_set('America/Mexico_City');
include 'error_log.php';
include 'db.php';
session_start();
if(isset($_SESSION['idUser'])){
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

        if($row['aforo'] <= $row['reservados']){
            //estatus clase cerrada para reserva por cupo completo
            $estatus = '<img class="icono-reserva" src="assets/images/svg/full_class.svg" alt="Clase llena ícono">';
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
            $estatus = '<svg xmlns="http://www.w3.org/2000/svg" class="ionicon clase-en-curso-punto" viewBox="0 0 512 512"><defs></defs> <title>Ellipse</title> <path style="fill: #986C5D" d="M256 464c-114.69 0-208-93.31-208-208S141.31 48 256 48s208 93.31 208 208-93.31 208-208 208z" /> </svg>';
        } elseif ($now < $start) {
            if($abierta == 1){
                //estatus clase en abierta para reserva
                    $estatus = '<svg xmlns="http://www.w3.org/2000/svg" class="ionicon clase-en-curso-punto"
                    viewBox="0 0 512 512">
                    <defs>
                        
                    </defs>
                    <title>Ellipse</title>
                    <path style="fill: #00D52B;"
                        d="M256 464c-114.69 0-208-93.31-208-208S141.31 48 256 48s208 93.31 208 208-93.31 208-208 208z" />
                </svg>';
            }
        }elseif ($start < $now){
            $estatus = '<svg xmlns="http://www.w3.org/2000/svg" class="ionicon clase-en-curso-punto"
                    viewBox="0 0 512 512">
                    <defs>
                    </defs>
                    <title>Ellipse</title>
                    <path style="fill: #ACACAC;"
                        d="M256 464c-114.69 0-208-93.31-208-208S141.31 48 256 48s208 93.31 208 208-93.31 208-208 208z" />
                </svg>';
                $abierta = 0;
        }

        // Formatear horario en formato AM/PM
        $horario = $start->format("g:i A") . " - " . $end->format("g:i A");
        $duracion = $duracionTexto;

        if(isset($idUser)){
            //validara la reserva del usuario
            $idClase = $row['id'];
            $stmtU->bind_param("ii", $idUser, $idClase);
            $stmtU->execute();
            $resultU = $stmtU->get_result();
        
            if ($Alumno = $resultU->fetch_assoc()) {
                $estatus = '<img class="icono-reserva" src="assets/images/svg/reservado.svg" alt="Clase reservada ícono">';
                $abierta = 0;
            }
        }
        if($row['estatus'] == 2){
            //estatus clase en lista de espera
            $estatus = '<img class="icono-reserva" src="assets/images/svg/waiting_list.svg" alt="Wait List ícono">';
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
            "abierta" => $abierta
        ];
        
    }
    $stmtC->close();
    $stmtD->close();
    echo json_encode($clases);
} else {
    echo json_encode([]);
}
?>
