<?php
require_once('../db.php');

header('Content-Type: application/json');

try {
    // Consulta para obtener los cursos
    $query = "
            SELECT 
                id,
                nombre_coach,
                descripcion_coach,
                id_disciplina
            FROM coaches
            ORDER BY id DESC
        ";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmtD = $conn->prepare("SELECT nombre_disciplina FROM disciplinas WHERE id = ?");
    $cursos = [];
    
    while ($row = $result->fetch_assoc()) {

        $nombre = $row['nombre_coach'];
        $ID_disciplina = $row['id_disciplina'];

        $profilePath = "../assets/images/coaches/pro/" . $row['id'] . ".png";
        $defaultPath = "../assets/images/coaches/pro/unknow.png";
        if (!file_exists($profilePath)) {
            $profilePath = $defaultPath;
        }
        $stmtD->bind_param("i", $ID_disciplina);
        $stmtD->execute();
        $resultD = $stmtD->get_result();
        if ($rowD = $resultD->fetch_assoc()) {
            $disciplina = $rowD['nombre_disciplina'];
        } else {
            $disciplina = "Sin Disciplina";
        }

        $disciplinaPath = "../assets/images/disciplinas/" . $ID_disciplina . ".png";
        $defaultPathD = "../assets/images/disciplinas/unknow.png";

        if (!file_exists($disciplinaPath)) {
            $disciplinaPath = $defaultPathD;
        }
        $cursos[] = [
            'id' => $row['id'],
            'nombre' => $nombre,
            'imagen' => $disciplinaPath,
            'imgau' => $profilePath,
            'diciplina' => $disciplina,
            'descripcion' => $row['descripcion_coach'] ?: 'Sin descripción...'
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