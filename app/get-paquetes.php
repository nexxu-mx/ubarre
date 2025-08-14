<?php
require_once('../db.php');

header('Content-Type: application/json');

try {
    // Consulta para obtener los cursos
    $query = " SELECT id, clases, costo, nombre, vigencia, invitados, persona FROM paquetes ORDER BY id DESC";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $result = $stmt->get_result();
    $paquetes = [];
    
    while ($row = $result->fetch_assoc()) {
        $paquetes[] = [
            'id' => $row['id'],
            'clases' => $row['nombre'],
            'costo' => $row['costo'],
            'nombre' => $row['nombre'],
            'vigencia' => $row['vigencia'],
            'invitados' => $row['invitados'],
            'persona' => $row['persona']
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