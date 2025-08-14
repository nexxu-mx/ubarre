<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require '../db.php';

$query = "SELECT id, user, monto, creditos, numero, metodo, idpago, mrecibido, fecha FROM transacciones ORDER BY id DESC";
$result = $conn->query($query);

$productos = array(); // Array para almacenar los productos

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $producto = array();

        $producto['id'] = $row['id'];
        $producto['monto'] = number_format($row['monto'], 2);
        $producto['creditos'] = $row['creditos'];
        $producto['idpago'] = $row['idpago'];
        $producto['recibido'] = $row['mrecibido'];
       

      
            $sqlC = "SELECT numero FROM users WHERE id = ?";
            if ($stmtC = $conn->prepare($sqlC)) {
                $stmtC->bind_param("s", $row['user']);
                $stmtC->execute();
                $stmtC->bind_result($numero);
                if ($stmtC->fetch()) {
                    $producto['cliente'] = $numero;
                }
                $stmtC->close();
            }
      
        
        // Método de pago
        if ($row['metodo'] == '1') {
            $producto['metodo'] = "Efectivo";
        } elseif ($row['metodo'] == '3') {
            $producto['metodo'] = "App";
        } else {
            $producto['metodo'] = "Tarjeta";
        }

        $producto['fecha'] = $row['fecha'];

        // Agregar el producto al array de productos
        $productos[] = $producto;
    }
}

$conn->close();

// Enviar los productos como respuesta JSON
header('Content-Type: application/json');
echo json_encode($productos);
?>
