<?php
session_start();
require_once('../db.php');

// Solo recepción y admin pueden generar corte
if (!isset($_SESSION['idUser']) || !isset($_SESSION['tipoUser'])) {
    die('No autorizado');
}

$tipoUser = (int)$_SESSION['tipoUser'];
if ($tipoUser !== 3 && $tipoUser !== 4) {
    die('No autorizado');
}

$fecha = isset($_GET['fecha']) ? $_GET['fecha'] : date('Y-m-d');
$nombreUsuario = $_SESSION['nombre'];

// Obtener ventas del día
$query = "SELECT
            DATE_FORMAT(fecha_venta, '%H:%i') as hora,
            nombre_producto,
            cantidad,
            precio_unitario,
            total,
            vendedor_nombre,
            metodo_pago
          FROM ventas
          WHERE DATE(fecha_venta) = ?
          ORDER BY fecha_venta ASC";

$stmt = $conn->prepare($query);
$stmt->bind_param("s", $fecha);
$stmt->execute();
$result = $stmt->get_result();

$ventas = [];
$total_efectivo = 0;
$total_tarjeta = 0;
$count_efectivo = 0;
$count_tarjeta = 0;

while ($row = $result->fetch_assoc()) {
    $ventas[] = $row;
    if ($row['metodo_pago'] === 'efectivo') {
        $total_efectivo += floatval($row['total']);
        $count_efectivo++;
    } else {
        $total_tarjeta += floatval($row['total']);
        $count_tarjeta++;
    }
}

$total_general = $total_efectivo + $total_tarjeta;
$total_ventas = count($ventas);

$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Corte de Caja - <?php echo date('d/m/Y', strtotime($fecha)); ?></title>
    <style>
        @media print {
            .no-print { display: none; }
        }
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #333;
            padding-bottom: 20px;
            margin-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            color: #986C5D;
        }
        .info-section {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .resumen {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
            margin-bottom: 20px;
        }
        .resumen-card {
            background: white;
            border: 2px solid #986C5D;
            padding: 15px;
            border-radius: 8px;
            text-align: center;
        }
        .resumen-card h3 {
            margin: 0 0 10px 0;
            color: #666;
            font-size: 0.9rem;
        }
        .resumen-card .amount {
            font-size: 1.8rem;
            font-weight: bold;
            color: #986C5D;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table th, table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        table th {
            background: #986C5D;
            color: white;
        }
        .totales {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            font-size: 1.1rem;
        }
        .firma {
            margin-top: 60px;
            text-align: center;
        }
        .firma-linea {
            border-top: 2px solid #333;
            width: 300px;
            margin: 40px auto 10px;
        }
        .btn-print {
            background: #986C5D;
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 1rem;
            margin-bottom: 20px;
        }
        .btn-print:hover {
            background: #7D5A4D;
        }
    </style>
</head>
<body>
    <div class="no-print">
        <button class="btn-print" onclick="window.print()">🖨️ Imprimir Corte</button>
    </div>

    <div class="header">
        <h1>übarre</h1>
        <h2>Corte de Caja</h2>
        <p><strong>Fecha:</strong> <?php echo date('d/m/Y', strtotime($fecha)); ?></p>
        <p><strong>Generado por:</strong> <?php echo htmlspecialchars($nombreUsuario); ?></p>
        <p><strong>Hora:</strong> <?php echo date('H:i:s'); ?></p>
    </div>

    <div class="resumen">
        <div class="resumen-card">
            <h3>💵 Efectivo</h3>
            <div class="amount">$<?php echo number_format($total_efectivo, 2); ?></div>
            <p><?php echo $count_efectivo; ?> transacciones</p>
        </div>
        <div class="resumen-card">
            <h3>💳 Tarjeta</h3>
            <div class="amount">$<?php echo number_format($total_tarjeta, 2); ?></div>
            <p><?php echo $count_tarjeta; ?> transacciones</p>
        </div>
    </div>

    <div class="info-section">
        <h3>Resumen del Día</h3>
        <p><strong>Total de Ventas:</strong> <?php echo $total_ventas; ?></p>
        <p><strong>Total General:</strong> $<?php echo number_format($total_general, 2); ?></p>
    </div>

    <?php if (count($ventas) > 0): ?>
    <h3>Detalle de Ventas</h3>
    <table>
        <thead>
            <tr>
                <th>Hora</th>
                <th>Producto</th>
                <th>Cant.</th>
                <th>Precio Unit.</th>
                <th>Total</th>
                <th>Método</th>
                <th>Vendedor</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($ventas as $venta): ?>
            <tr>
                <td><?php echo $venta['hora']; ?></td>
                <td><?php echo htmlspecialchars($venta['nombre_producto']); ?></td>
                <td><?php echo $venta['cantidad']; ?></td>
                <td>$<?php echo number_format($venta['precio_unitario'], 2); ?></td>
                <td>$<?php echo number_format($venta['total'], 2); ?></td>
                <td><?php echo strtoupper($venta['metodo_pago']); ?></td>
                <td><?php echo htmlspecialchars($venta['vendedor_nombre']); ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php else: ?>
    <p style="text-align: center; padding: 40px; background: #f8f9fa; border-radius: 8px;">
        No hay ventas registradas para esta fecha.
    </p>
    <?php endif; ?>

    <div class="totales">
        <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
            <span>Efectivo:</span>
            <strong>$<?php echo number_format($total_efectivo, 2); ?></strong>
        </div>
        <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
            <span>Tarjeta:</span>
            <strong>$<?php echo number_format($total_tarjeta, 2); ?></strong>
        </div>
        <div style="display: flex; justify-content: space-between; font-size: 1.3rem; border-top: 2px solid #333; padding-top: 10px;">
            <span><strong>TOTAL:</strong></span>
            <strong style="color: #986C5D;">$<?php echo number_format($total_general, 2); ?></strong>
        </div>
    </div>

    <div class="firma">
        <div class="firma-linea"></div>
        <p><strong>Firma del Responsable</strong></p>
    </div>

    <div style="margin-top: 40px; text-align: center; color: #999; font-size: 0.85rem;">
        <p>Documento generado automáticamente - übarre</p>
        <p><?php echo date('d/m/Y H:i:s'); ?></p>
    </div>
</body>
</html>
