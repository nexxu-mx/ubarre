<?php
require_once('../db.php');

header('Content-Type: application/json');

try {
    // Consulta para obtener los últimos 5 leads
    $query = " SELECT id, user, numero, metodo, monto, creditos, fecha FROM transacciones ORDER BY fecha DESC LIMIT 5";

    $stmt = $conn->prepare($query);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmtD = $conn->prepare("SELECT nombre, apellido FROM users WHERE id = ?");
    $leads = [];
    
    while ($row = $result->fetch_assoc()) {
        $stmtD->bind_param("i", $row['user']);
        $stmtD->execute();
        $resultD = $stmtD->get_result();
        if ($rowD = $resultD->fetch_assoc()) {
            $nombre = $rowD['nombre'];
            $apellido = $rowD['apellido'];
        } else {
            $nombre = "U";
            $apellido = "K";
        }
        
        $nombreCompleto = $nombre . " " . $apellido;
        // Obtener iniciales
        $iniciales = strtoupper(($nombre[0] ?? '').($apellido[0] ?? ''));
        if (empty($iniciales)) $iniciales = 'NA';
        
        $leads[] = [
            'id' => $row['id'],
            'nombre_completo' => $nombreCompleto,
            'iniciales' => $iniciales,
            'monto' => $row['monto'],
            'credits' => $row['creditos'],
            'telefono' => $row['numero'] ?? 'No especificado',
            'fecha' => date('d/m/Y H:i', strtotime($row['fecha']))
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