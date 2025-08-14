<?php
header('Content-Type: application/json');
$id = $_POST['id'] ?? '';
if($id){
    include 'db.php';

    $sql = "SELECT nombre_coach, descripcion_coach FROM coaches WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        echo json_encode(["error" => "Coach no encontrado"]);
        exit;
    }

    $row = $result->fetch_assoc();
    $img = "assets/images/coaches/$id.png";
    echo json_encode([
        "image" => $img,
        "nombre" => $row["nombre_coach"],
        "descripcion" => $row["descripcion_coach"]
    ]);
}
?>
