<?php
// Configurar cabeceras seguras
header('Content-Type: application/json; charset=UTF-8');
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: DENY');
header('X-XSS-Protection: 1; mode=block');

// Conexión a la base de datos
include 'db.php';
  include 'error_log.php';

// Validar y sanitizar entrada
$numero = $_POST['numero'] ?? '';
$numero = trim($numero);
$numero = preg_replace('/\D/', '', $numero);

// Opcional: Limitar el tamaño del número para evitar abuso
if (strlen($numero) > 20) {
    echo json_encode(['error' => 'Número demasiado largo']);
    exit;
}

// Verificar que no esté vacío después de sanitizar
if (empty($numero)) {
    echo json_encode(['error' => 'Número no proporcionado']);
    exit;
}

try {
    $stmt = $conn->prepare("SELECT mail FROM users WHERE numero = ?");
    if (!$stmt) {
        throw new Exception('Error al preparar la consulta.');
    }
    
    $stmt->bind_param("s", $numero);
    $stmt->execute();
    $stmt->store_result();

    if($stmt->num_rows > 0){
        $stmt->bind_result($mail);
        $stmt->fetch();
        $stmt->close();
        
       $token = random_int(100000, 999999);
       
       // Envio de Email:
       if(isset($_POST['recuperar'] )){
           $celjk = $_POST['recuperar'] . "-";
           if($_POST['recuperar'] == 1){
                $celjk = "2";
                $mail_mailing = htmlspecialchars($mail, ENT_QUOTES, 'UTF-8');
                $mail_asunto = "Tu código de verificación de acceso";
                $mail_motivo = "Código";
                $mail_motivo2 = "Aquí está tu código de verificación de acceso:";
                $mail_descripcion = "Por favor, asegúrate de no compartir nunca este código con nadie. Tu código expirará en 15 minutos.";
                $mail_tabla = "<span style='font-size: 22px; font-weight: 600; color: #986C5D'>$token</span>";
              
                include 'success_mail.php';
           }
       }else{
           $celjk = "-";
       }
       
        // Fin Envio de Email:
        //Envio WhatsApp API

        //Fin WhatsApp API
        //Agrega codigo al registro
        date_default_timezone_set('America/Mexico_City');
        $dlogin = time();
        $tlogin = $token;

        $sqlT = "UPDATE users SET tlogin = ?, dlogin = ? WHERE numero = ?";
        $stmtT = $conn->prepare($sqlT);
        $stmtT->bind_param("ssi", $tlogin, $dlogin, $numero);
        $stmtT->execute();

        if ($stmtT->affected_rows > 0) {
            $tlog = true;
        }
        $stmtT->close();
        //Fin codigo al registro
        echo json_encode(['exists' => true, 'tlo' =>  $celjk]);
    } else {
        $stmt->close();
        echo json_encode(['exists' => false]);
    }

} catch (Exception $e) {
    // Log interno, no exponer detalles al usuario
    error_log('Error en la consulta: ' . $e->getMessage());
    echo json_encode(['error' => 'Error interno del servidor']);
}
?>
