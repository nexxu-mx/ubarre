<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require './db.php';

$query = "SELECT id, monto, claves, metodo, idpago, fecha FROM transactin ORDER BY fecha DESC LIMIT 5";

$result = $conn->query($query);

$transacciones = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Determinar el método de pago
        switch ($row['metodo']) {
            case '1':
                $meth = "Pago en Efectivo";
                break;
            case '2':
                $meth = "Pago con Tarjeta";
                break;
            case '3':
                $meth = "Venta E-Commerce";
                break;
            default:
                $meth = "Método desconocido"; // Si 'metodo' no es 1, 2 ni 3
                break;
        }
        

        // Guardar los datos de las transacciones en un array
        $transacciones[] = [
            'id' => $row['id'],
            'monto' => $row['monto'],
            'metodo' => $meth
        ];
    }
} else {
    $transacciones = ['mensaje' => 'Sin Transacciones Recientes'];
}

$conn->close();

// Devolver las transacciones en formato JSON
echo json_encode($transacciones);
?>
