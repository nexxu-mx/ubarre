<?php
/**
 * TICKET 4: Script automático para limpiar descuentos expirados
 *
 * Este script elimina automáticamente los descuentos de paquetes
 * cuya fecha de finalización (finalizadsc) ya expiró.
 *
 * Se ejecuta automáticamente al iniciar sesión o acceder al panel admin.
 */

// Evitar ejecución directa desde navegador sin sesión
if (!defined('AUTO_CLEAN_ALLOWED')) {
    // Si se ejecuta directamente, permitir solo desde CLI o localhost
    if (php_sapi_name() !== 'cli' && $_SERVER['REMOTE_ADDR'] !== '127.0.0.1') {
        http_response_code(403);
        die('Acceso denegado');
    }
}

require_once(__DIR__ . '/db.php');

if (!isset($conn) || $conn->connect_error) {
    error_log("Auto-clean-discounts: Error de conexión a la base de datos");
    return false;
}

try {
    date_default_timezone_set('America/Mexico_City');
    $fecha_actual = date('Y-m-d H:i:s');

    // Actualizar paquetes con descuentos expirados
    // Poner descuento = NULL y finalizadsc = NULL cuando finalizadsc < NOW()
    $query = "UPDATE paquetes
              SET descuento = NULL, finalizadsc = NULL
              WHERE finalizadsc IS NOT NULL
              AND finalizadsc != ''
              AND finalizadsc < ?
              AND descuento IS NOT NULL";

    $stmt = $conn->prepare($query);

    if (!$stmt) {
        error_log("Auto-clean-discounts: Error preparando query - " . $conn->error);
        return false;
    }

    $stmt->bind_param("s", $fecha_actual);
    $result = $stmt->execute();

    if ($result) {
        $affected_rows = $stmt->affected_rows;
        if ($affected_rows > 0) {
            error_log("Auto-clean-discounts: Se limpiaron $affected_rows descuentos expirados");
        }
        $stmt->close();
        return true;
    } else {
        error_log("Auto-clean-discounts: Error ejecutando query - " . $stmt->error);
        $stmt->close();
        return false;
    }

} catch (Exception $e) {
    error_log("Auto-clean-discounts: Excepción - " . $e->getMessage());
    return false;
}

// No cerramos $conn aquí porque puede estar siendo usado por el script principal
?>
