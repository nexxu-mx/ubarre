<?php
include 'error_log.php';
include('../db.php');
date_default_timezone_set('America/Mexico_City');
// === Recibir mes de consulta desde JS (si no llega, usar mes actual) ===
$mesConsulta = isset($_GET['mes']) ? $_GET['mes'] : date('Y-m'); // formato YYYY-MM
if(empty($_GET['mes'])){
  $mesConsulta = date('Y-m');
}
// Obtener la fecha actual (hoy)
$fechaHoy = date('Y-m-d H:i:s');

// === 1. Consultar egresos del mes seleccionado ===
$queryEgresos = "SELECT fecha, monto 
                 FROM egr 
                 WHERE DATE_FORMAT(fecha, '%Y-%m') = '$mesConsulta'";
$resultEgresos = mysqli_query($conn, $queryEgresos);

$egresos = [];
while ($row = mysqli_fetch_assoc($resultEgresos)) {
    $egresos[] = $row;
}

// === 1.2 Consultar ingresos del mes seleccionado ===
$queryIngresos = "SELECT fecha, monto 
                 FROM ing 
                 WHERE DATE_FORMAT(fecha, '%Y-%m') = '$mesConsulta'";
$resultIngresos = mysqli_query($conn, $queryIngresos);

$ing = [];
while ($row = mysqli_fetch_assoc($resultIngresos)) {
    $ing[] = $row;
}
// === 2. Consultar transacciones del mes seleccionado ===
$queryTransacciones = "SELECT fecha, monto, metodo 
                       FROM transacciones 
                       WHERE DATE_FORMAT(fecha, '%Y-%m') = '$mesConsulta'";
$resultTransacciones = mysqli_query($conn, $queryTransacciones);

$transacciones = [];
while ($row = mysqli_fetch_assoc($resultTransacciones)) {
    $transacciones[] = $row;
}

// === 3. Calcular ingresos por método ===
$ingresosTienda = 0;
$ingresosEcommerce = 0;
foreach ($transacciones as $transaccion) {
    $monto = $transaccion['monto'];
    $metodo = $transaccion['metodo'];

    if ($metodo != 3) {
        $ingresosTienda += $monto; // Tienda física
    } else {
        $ingresosEcommerce += $monto; // Ecommerce
    }
}

// === 4. Calcular egresos ===
$egresosTotales = 0;
foreach ($egresos as $egreso) {
    $egresosTotales += $egreso['monto'];
}

// === 4.5 Calcular ingresos ===
$ingresosTotales = 0;
foreach ($ing as $ings) {
    $ingresosMan += $ings['monto'];
}


// === 5. Calcular utilidad ===
$totalUtilidad = ($ingresosTienda + $ingresosEcommerce + $ingresosMan) - $egresosTotales;

// === 6. Consultar ocupación de clases hasta el momento actual ===
$queryClases = "SELECT aforo, reservados, fecha 
                FROM clases 
                WHERE DATE_FORMAT(fecha, '%Y-%m') = '$mesConsulta'
                AND fecha <= '$fechaHoy'"; 
$resultClases = mysqli_query($conn, $queryClases);

$totalAforo = 0;
$totalReservados = 0;

while ($row = mysqli_fetch_assoc($resultClases)) {
    $totalAforo += (int)$row['aforo'];
    $totalReservados += (int)$row['reservados'];
}

$porcentajeOcupacion = ($totalAforo > 0) 
    ? round(($totalReservados / $totalAforo) * 100, 2) 
    : 0;

// === 7. Ventas históricas (ANUAL, no se filtra por mes) ===
$queryVentasHistoricas = "SELECT DATE_FORMAT(fecha, '%Y-%m') AS mes, metodo, SUM(monto) AS total_ventas 
                          FROM transacciones 
                          WHERE metodo IN (1, 3) 
                          GROUP BY mes, metodo
                          ORDER BY mes ASC";
$resultVentasHistoricas = mysqli_query($conn, $queryVentasHistoricas);

$ventasHistoricas = [];
while ($row = mysqli_fetch_assoc($resultVentasHistoricas)) {
    $ventasHistoricas[] = $row;
}
// === 8. Genera las operaciones del mes consultado todos los movimientos

$saldo1 = 0;
$operaciones = [];

// === 1. CONSULTAR TRANSACCIONES ===
$queryTrans1 = "
    SELECT DATE(fecha) AS fecha, mrecibido AS monto, 'Venta Créditos' AS tipo, 'ingreso' AS mov
    FROM transacciones
    WHERE DATE_FORMAT(fecha, '%Y-%m') = '$mesConsulta'
";
$resTrans1 = mysqli_query($conn, $queryTrans1);
while ($row1 = mysqli_fetch_assoc($resTrans1)) {
    $operaciones[] = [
        "fecha" => date("Y-m-d", strtotime($row1['fecha'])), // guardamos en Y-m-d para ordenar bien
        "tipo" => $row1['tipo'],
        "monto" => (float)$row1['monto'],
        "mov" => $row1['mov']
    ];
}

// === 2. CONSULTAR ING ===
$queryIng1 = "
    SELECT fecha, monto, concepto AS tipo, 'ingreso' AS mov
    FROM ing
    WHERE DATE_FORMAT(fecha, '%Y-%m') = '$mesConsulta'
";
$resIng1 = mysqli_query($conn, $queryIng1);
while ($row1 = mysqli_fetch_assoc($resIng1)) {
    $operaciones[] = [
        "fecha" => date("Y-m-d", strtotime($row1['fecha'])),
        "tipo" => $row1['tipo'],
        "monto" => (float)$row1['monto'],
        "mov" => $row1['mov']
    ];
}

// === 3. CONSULTAR EGR ===
$queryEgr1 = "
    SELECT fecha, monto, concepto AS tipo, 'egreso' AS mov
    FROM egr
    WHERE DATE_FORMAT(fecha, '%Y-%m') = '$mesConsulta'
";
$resEgr1 = mysqli_query($conn, $queryEgr1);
while ($row1 = mysqli_fetch_assoc($resEgr1)) {
    $operaciones[] = [
        "fecha" => date("Y-m-d", strtotime($row1['fecha'])),
        "tipo" => $row1['tipo'],
        "monto" => (float)$row1['monto'],
        "mov" => $row1['mov']
    ];
}

// === ORDENAR OPERACIONES POR FECHA ===
usort($operaciones, function($a, $b) {
    return strtotime($a['fecha']) - strtotime($b['fecha']);
});

// === RECALCULAR SALDO EN ORDEN CRONOLÓGICO ===
$saldo1 = 0;
$operacionesFinal = [];

foreach ($operaciones as $op) {
    if ($op['mov'] === 'ingreso') {
        $saldo1 += $op['monto'];
        $ingreso = number_format($op['monto'], 2);
        $egreso = '';
    } else {
        $saldo1 -= $op['monto'];
        $ingreso = '';
        $egreso = number_format($op['monto'], 2);
    }

    $operacionesFinal[] = [
        "fecha" => date("d-m-Y", strtotime($op['fecha'])),
        "tipo" => $op['tipo'],
        "ingreso" => $ingreso,
        "egreso" => $egreso,
        "saldo" => number_format($saldo1, 2)
    ];
}



// === 8. Respuesta JSON ===
header('Content-Type: application/json');
echo json_encode([
    'ingresos' => $ingresosTienda + $ingresosEcommerce + $ingresosMan,
    'egresos' => $egresosTotales,
    'utilidades' => $totalUtilidad,
    'ocupacion' => $porcentajeOcupacion,
    'ventasHistoricas' => $ventasHistoricas,
    'operaciones' => $operacionesFinal
]);
?>
