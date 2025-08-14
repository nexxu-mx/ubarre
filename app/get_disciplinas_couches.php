<?php
include '../db.php';

header('Content-Type: application/json');
$disciplinas = [];
$couches = [];

$res1 = $conn->query("SELECT id, nombre_disciplina FROM disciplinas");
while ($row = $res1->fetch_assoc()) {
  $disciplinas[] = $row;
}

$res2 = $conn->query("SELECT id, nombre_coach FROM coaches");
while ($row = $res2->fetch_assoc()) {
  $couches[] = $row;
}

echo json_encode([
  'disciplinas' => $disciplinas,
  'couches' => $couches
]);
?>
