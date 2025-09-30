<?php
require_once('../db.php');

header('Content-Type: application/json');

try {
    // Consulta para obtener los cursos
    $query = " SELECT id, descuento, codigo, fin, excepcion FROM descuentos ORDER BY id DESC";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $result = $stmt->get_result();
    $paquetes = [];
    
    while ($row = $result->fetch_assoc()) {
        $paquetes[] = [
            'id' => $row['id'],
            'descuento' => $row['descuento'],
            'codigo' => $row['codigo'],
            'finaliza' => $row['fin'],
            'excepcion' => $row['excepcion']
        ];
    }

    echo json_encode(['paquetes' => $paquetes]);

} catch (Exception $e) {
    echo json_encode([
        'error' => true,
        'message' => 'Error: ' . $e->getMessage()
    ]);
}
?>