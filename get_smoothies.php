<?php 
include 'db.php';

$sql = "SELECT id, sabor FROM smoothies";
$result = $conn->query($sql);

$smoothies = [];
while ($row = $result->fetch_assoc()) {
    $id = $row['id'];

    $rutaPng = "assets/images/smoothies/$id.png";
    $rutaJpg = "assets/images/smoothies/$id.jpg";

    if (file_exists($rutaPng)) {
        $row['ruta'] = $rutaPng;
    } elseif (file_exists($rutaJpg)) {
        $row['ruta'] = $rutaJpg;
    } else {
        $row['ruta'] = "assets/images/smoothies/default.png"; // opcional
    }

    $smoothies[] = $row;
}

echo json_encode($smoothies);
?>