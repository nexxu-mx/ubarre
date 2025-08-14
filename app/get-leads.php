<?php
require_once('../db.php');

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
                credit
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
        
        // Obtener iniciales
        $iniciales = strtoupper(($nombre[0] ?? '').($apellido[0] ?? ''));
        if (empty($iniciales)) $iniciales = 'NA';
        if($row['tipoUser'] == 1){
            $tipo = "Cliente";
        }elseif($row['tipoUser'] == 2){
            $tipo = "Coach";
        }elseif($row['tipoUser'] == 3){
            $tipo = "Admin";
        }
        $leads[] = [
            'id' => $row['id'],
            'nombre_completo' => $nombreCompleto,
            'iniciales' => $iniciales,
            'email' => $row['mail'] ?? 'No especificado',
            'telefono' => $row['numero'] ?? 'No especificado',
            'interes' => $row['credit'] ?? 'No especificado',
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