<?php
include 'db.php';

$numero = $_POST['numero'] ?? '';
$code = $_POST['contra'] ?? '';

$response = ['valid' => false];

if (!empty($numero) && !empty($code)) {
    $stmt = $conn->prepare("SELECT COUNT(*) FROM users WHERE numero = ? AND pass = ?");
    $stmt->bind_param("ss", $numero, $code);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();

    if ($count > 0) {
        $response['valid'] = true;
    }
}

echo json_encode($response);
exit;
