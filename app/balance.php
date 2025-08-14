<?php
    // Conexión a la base de datos
    include 'error_log.php';
    include('../db.php');
    
    // Obtener la fecha actual (Mes y Año)
    $fechaActual = date('Y-m');
    
    // Consultar los egresos del mes en curso
    $queryEgresos = "SELECT fechaRegistro, monto FROM egr WHERE DATE_FORMAT(fechaRegistro, '%Y-%m') = '$fechaActual'";
    $resultEgresos = mysqli_query($conn, $queryEgresos);
    
    $egresos = [];
    while ($row = mysqli_fetch_assoc($resultEgresos)) {
        $egresos[] = $row;
    }
    
    // Consultar las transacciones del mes en curso
    $queryTransacciones = "SELECT fecha, monto, metodo FROM transacciones WHERE DATE_FORMAT(fecha, '%Y-%m') = '$fechaActual'";
    $resultTransacciones = mysqli_query($conn, $queryTransacciones);
    
    $transacciones = [];
    while ($row = mysqli_fetch_assoc($resultTransacciones)) {
        $transacciones[] = $row;

    }
    
  
    // Calcular los ingresos del mes en curso
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
    // Calcular los egresos del mes
    $egresosTotales = 0;
    foreach ($egresos as $egreso) {
        $egresosTotales += $egreso['monto'];
    }
    
    
    
    // Calcular la utilidad total
    $totalUtilidad = ($ingresosTienda + $ingresosEcommerce) - $egresosTotales;
    
  
    
    // Consultar ventas históricas por mes (para el MultipleLineChart)
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
    
    // Enviar los datos como JSON
    header('Content-Type: application/json');
    echo json_encode([
        'ingresos' => $ingresosTienda + $ingresosEcommerce,
        'egresos' => $egresosTotales,
        'utilidades' => $totalUtilidad,
        'ventasHistoricas' => $ventasHistoricas
    ]);
    
    ?>