<?php
header('Content-Type: application/json');
include './db.php';

// Obtener el ID de usuario desde la solicitud
$data = json_decode(file_get_contents('php://input'), true);
session_start();
$idusrv = $_SESSION['idUser'];

if (!$idusrv) {
    http_response_code(400);
    echo json_encode(['error' => 'ID de usuario no proporcionado']);
    exit;
}

try {
    // 1. Verificar si el usuario existe y tiene customer_id
    $stmt_user = $conn->prepare("SELECT customer_id FROM users WHERE id = ?");
    $stmt_user->bind_param("i", $idusrv);
    $stmt_user->execute();
    $result_user = $stmt_user->get_result();

    if ($result_user->num_rows === 0) {
        http_response_code(404);
        echo json_encode(['error' => 'Usuario no encontrado']);
        exit;
    }

    $user = $result_user->fetch_assoc();
    $customer_id = $user['customer_id'];

    // 2. Obtener las tarjetas guardadas del usuario
    $stmt_cards = $conn->prepare("
        SELECT 
            card_id, 
            last_four_digits, 
            payment_method, 
            card_type,
            created_at
        FROM user_cards 
        WHERE user_id = ?
        ORDER BY created_at DESC
    ");
    $stmt_cards->bind_param("i", $idusrv);
    $stmt_cards->execute();
    $result_cards = $stmt_cards->get_result();

    $cards = [];
    while ($row = $result_cards->fetch_assoc()) {
        // Formatear los datos de la tarjeta para el frontend
        $cards[] = [
            'card_id' => $row['card_id'],
            'last_four' => $row['last_four_digits'],
            'payment_method' => $row['payment_method'],
            'card_type' => $row['card_type'],
            'label' => getCardLabel($row['payment_method'], $row['last_four_digits'], $row['card_type'])
        ];
    }

    // 3. Opcional: Obtener tarjetas directamente de Mercado Pago para verificación
    // (Esto requiere que tengas el ACCESS_TOKEN configurado)
    $mp_cards = [];
   

    echo json_encode([
        'success' => true,
        'customer_id' => $customer_id,
        'cards' => $cards,
        'mp_cards' => $mp_cards // Opcional, para debug
    ]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'error' => 'Error al obtener tarjetas',
        'details' => $e->getMessage()
    ]);
}

// Función auxiliar para generar etiquetas descriptivas de tarjetas
function getCardLabel($payment_method, $last_four, $card_type) {
    $brands = [
        'visa' => 'visa',
        'master' => 'master',
        'amex' => 'amex',
        'diners' => 'diners'
    ];
    
    $type = ($card_type === 'debit') ? 'Débito' : 'Crédito';
    $brand = $brands[strtolower($payment_method)] ?? ucfirst($payment_method);
    
    return "$brand $type •••• $last_four";
}
?>