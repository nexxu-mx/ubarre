<?php
include 'db.php'; // tu archivo de conexión

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitizar y validar entradas
    $name = trim(strip_tags($_POST['nombreR']));
    $email = trim(filter_var($_POST['mailR'], FILTER_SANITIZE_EMAIL));
    $numero = trim(preg_replace('/\D/', '', $_POST['numeroR'])); 
    $invitacion = isset($_POST['invit']) ? strtoupper(trim(strip_tags($_POST['invit']))) : null;
    $pass = $_POST['contra'];

    $dia = $_POST['dia'];
    $mes = $_POST['mes'];
    $anio = $_POST['anio'];

    // Validar que los campos obligatorios estén presentes y bien
    if (empty($name) || empty($email) || empty($numero) || empty($dia) || empty($mes) || empty($anio)) {
        echo "Error: Faltan campos obligatorios. $nombre, $email, $numero, $dia, $mes, $anio";
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Error: Correo no válido.";
        exit;
    }

    if (strlen($numero) < 9 || strlen($numero) > 10) {
        echo "Error: Número de WhatsApp inválido.";
        exit;
    }

   
    $fechaNacimiento = $dia . '-' . $mes . '-' . $anio;
    // Antes de registrar, puedes validar que el correo o número no exista
    $checkStmt = $conn->prepare("SELECT id FROM users WHERE mail = ? OR numero = ?");
    $checkStmt->bind_param("si", $email, $numero);
    $checkStmt->execute();
    $checkStmt->store_result();

    if ($checkStmt->num_rows > 0) {
        echo "Error: El correo o el número ya están registrados.";
        $checkStmt->close();
        exit;
    }
    $checkStmt->close();

    $partes = explode(" ", $name);
    $nombre = "";
    $apellido = "";

    // Si hay más de 2 palabras
    if (count($partes) === 4) {
        $nombre = $partes[0] . " " . $partes[1];
        $apellido = $partes[2] . " " . $partes[3];
    } elseif (count($partes) === 3) {
        $nombre = $partes[0];
        $apellido = $partes[1] . " " . $partes[2];
    } elseif (count($partes) === 2) {
        $nombre = $partes[0];
        $apellido = $partes[1];
    } else {
        $nombre = $partes[0];
        $apellido = "";
    }
    $tipoUser = "1";
    $activo = "1";
    $credit = 0;
    $fecha = date('Y-m-d H:i:s');
    // Insertar en la base de datos
    $insertStmt = $conn->prepare("INSERT INTO users (tipoUser, nombre, apellido, mail, numero, pass, fecha_nacimiento, credit, activo, fecha) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $insertStmt->bind_param("ssssssssss", $tipoUser, $nombre, $apellido, $email, $numero, $pass, $fechaNacimiento, $credit, $activo, $fecha);
    
    if ($insertStmt->execute()) {
        header("Location: login.php");
         exit();
    } else {
        echo "Error al registrar: " . $insertStmt->error;
    }

    $insertStmt->close();
    $conn->close();
} else {
    echo "Acceso no permitido.";
}
?>
