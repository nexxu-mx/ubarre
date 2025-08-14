<?php
require_once('../db.php');

header('Content-Type: application/json');

try {
    // Consulta para obtener los cursos
    $query = " SELECT id, nombre_disciplina, descripcion_disciplina FROM disciplinas ORDER BY id DESC";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $result = $stmt->get_result();
    $cursos = [];
    
    while ($row = $result->fetch_assoc()) {

        $disciplinaPath = "../assets/images/disciplinas/" . $row['id'] . ".png";
        $defaultPathD = "../assets/images/disciplinas/unknow.png";

        if (!file_exists($disciplinaPath)) {
            $disciplinaPath = $defaultPathD;
        }
        $cursos[] = [
            'id' => $row['id'],
            'nombre' => $row['nombre_disciplina'],
            'imagen' => $disciplinaPath,
            'descripcion' => $row['descripcion_disciplina'] ?: 'Sin descripción disponible'
        ];
    }

    echo json_encode(['cursos' => $cursos]);

} catch (Exception $e) {
    echo json_encode([
        'error' => true,
        'message' => 'Error: ' . $e->getMessage()
    ]);
}
?>