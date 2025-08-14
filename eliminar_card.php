<?php
include './db.php';

$data = json_decode(file_get_contents("php://input"), true);
$cardId = $data['card_id'] ?? null;

if ($cardId) {
    $stmt = $conn->prepare("DELETE FROM user_cards WHERE id = ?");
    $stmt->bind_param("i", $cardId);
    $success = $stmt->execute();

    echo json_encode(['success' => $success]);
} else {
    echo json_encode(['success' => false, 'error' => 'ID no recibido']);
}
?>
