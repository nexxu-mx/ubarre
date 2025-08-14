<?php
header('Content-Type: application/json');
$id = $_POST['id'] ?? '';
if($id){
    include 'db.php';

    $sql = "SELECT nombre_disciplina, descripcion_disciplina FROM disciplinas WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        echo json_encode(["error" => "Coach no encontrado"]);
        exit;
    }

    $row = $result->fetch_assoc();
    echo json_encode([
        "nombre" => $row["nombre_disciplina"],
        "descripcion" => $row["descripcion_disciplina"]
    ]);
}
?>
