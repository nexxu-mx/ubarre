<?php

header('Content-Type: application/json');
include '../db.php';
include '../error_log.php';

$codigo = isset($_POST['codigo']) ? trim($_POST['codigo']) : '';
$descuento = isset($_POST['descuento']) ? trim($_POST['descuento']) : '';
$finaliza = isset($_POST['finaliza']) ? trim($_POST['finaliza']) : '';
$restriccion = isset($_POST['restriccion']) ? trim($_POST['restriccion']) : '';

// Validaciones básicas
            if (!$codigo || !$descuento || !$finaliza) {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Faltan datos obligatorios'
                ]);
                exit;
            }
        $activo = 1;
        if(empty($restriccion)){
            $restriccion = null;
        }
        $sql = $conn->prepare("INSERT INTO descuentos (descuento, codigo, activo, fin, excepcion) VALUES (?, ?, ?, ?, ?)");
        $sql->bind_param("isisi", $descuento, $codigo, $activo, $finaliza, $restriccion);
        
        if($sql->execute()){
            echo json_encode([
                'status' => 'success',
                'codigo' => $codigo,
                'descuento' => $descuento,
                'finaliza' => $finaliza,
                'restriccion' => $restriccion,
                'message' => 'Datos recibidos correctamente'
            ]);
        }else{
            echo json_encode([
                    'status' => 'error',
                    'message' => 'Error en el alta'
                ]);
                exit;
        }
        

?>
