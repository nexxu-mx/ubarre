<?php
require_once('../db.php');
require '../error_log.php';

date_default_timezone_set('America/Mexico_City');

header('Content-Type: application/json');

try {
    // Consulta para obtener los últimos 5 leads
    $query = "
            SELECT 
                id,
                tipoUser,
                nombre,
                apellido,
                mail,
                numero,
                credit,
                fechaCredit
            FROM users
            ORDER BY id DESC
        ";

 
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $result = $stmt->get_result();
   

    $leads = [];
    
    while ($row = $result->fetch_assoc()) {
        
        // Extraer nombre y apellido
        $nombreCompleto = $row['nombre'] . ' ' . $row['apellido'];
        $nombre = $row['nombre'];
        $apellido = $row['apellido'];
        
        
        if($row['tipoUser'] == 1){
            $tipo = "Cliente";
        }elseif($row['tipoUser'] == 2){
            $tipo = "Coach";
        }elseif($row['tipoUser'] == 3){
            $tipo = "Admin";
        }elseif($row['tipoUser'] == 4){
            $tipo = "Recepción";
        }

        ///maneja vencimiento 

        $estatus = '-';
        if(!empty($row['fechaCredit'])){
            
             
             
            $vencimiento = $row['fechaCredit'];
            $hoy = new DateTime(); 
            $fechaVenc = new DateTime($vencimiento);
            $diff = (int)$hoy->diff($fechaVenc)->format("%r%a"); 
        

            if ($diff < 0) {
                $estatus = '<span class="badge badge-danger">Vencida</span>';
            } elseif ($diff < 3) {
                $estatus = '<span class="badge badge-warning">Por Vencer</span>';
            } else {
                if($row['credit'] < 3){
                    $estatus = '<span class="badge badge-warning">Por Vencer</span>';
                }elseif($row['credit'] == 0){
                    $estatus = '<span class="badge badge-danger">Vencida</span>';
                }else{

                    $estatus = '<span class="badge badge-success">Activo</span>';
                }
                
            }  
        }else{
            $estatus = '<span class="badge badge-danger">Sin Créditos</span>';
            
        }
        
        if($row['credit'] == 0){
            $estatus = '<span class="badge badge-danger">Vencida</span>';
        }
        
        
        $leads[] = [
            'id' => $row['id'],
            'nombre_completo' => $nombreCompleto,
            'email' => $row['mail'] ?? 'No especificado',
            'telefono' => $row['numero'] ?? 'No especificado',
            'interes' => $row['credit'] ?? 'No especificado',
            'satatus' => $estatus,
            'tipo' => $tipo
        ];
        
        
       
    }

    echo json_encode(['leads' => $leads]);

} catch (Exception $e) {
    echo json_encode([
        'error' => true,
        'message' => 'Error: ' . $e->getMessage()
    ]);
}
?>