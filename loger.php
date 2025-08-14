<?php
include 'error_log.php';
$session_lifetime = 60 * 60 * 24 * 30; // 30 días en segundos
ini_set('session.gc_maxlifetime', $session_lifetime);
session_set_cookie_params([
    'lifetime' => $session_lifetime,
    'path' => '/',
    'secure' => isset($_SERVER['HTTPS']), // true si es HTTPS
    'httponly' => true,
    'samesite' => 'Lax'
]);

session_start();
include 'db.php'; 

//Cabeceras HTTP de seguridad Activar en producción
//header('X-Frame-Options: DENY'); 
//header('X-Content-Type-Options: nosniff'); 
//header('Referrer-Policy: no-referrer'); 
//header('Content-Security-Policy: default-src \'self\'; script-src \'self\';'); 

$maxAttempts = 5;
$lockTime = 300; // segundos
if (!isset($_SESSION['attempts'])) {
    $_SESSION['attempts'] = 0;
    $_SESSION['last_attempt_time'] = time();
}
if ($_SESSION['attempts'] >= $maxAttempts && (time() - $_SESSION['last_attempt_time']) < $lockTime) {
    die('Demasiados intentos fallidos. Intenta nuevamente más tarde.');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $number = trim($_POST['number'] ?? '');
    $code = $_POST['contras'] ?? '';
    if (!preg_match('/^\d{9,10}$/', $number)) {
        die('Datos inválidos.');
    }
    $stmt = $conn->prepare("SELECT id, nombre, mail, numero, tipoUser FROM users WHERE numero = ? AND pass = ?");
    $stmt->bind_param("ss", $number, $code);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        session_regenerate_id(true);
        $_SESSION['tipoUser'] = $user['tipoUser'];
        $_SESSION['idUser'] = (int)$user['id'];
        $_SESSION['email'] = $user['mail'];
        $_SESSION['number'] = $user['numero'];
        $_SESSION['nombre'] = htmlspecialchars($user['nombre'], ENT_QUOTES, 'UTF-8');
        $_SESSION['attempts'] = 0;
        header("Location: profile.php");
        exit();
    } else {
        $_SESSION['attempts']++;
        $_SESSION['last_attempt_time'] = time();
        header("Location: login.php?error=credenciales");
        exit();
    }
}
?>
