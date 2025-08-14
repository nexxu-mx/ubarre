<?php
// Iniciar buffer de salida para capturar posibles warnings/errors

ob_start();
date_default_timezone_set('America/Mexico_City');

error_reporting(E_ALL & ~E_DEPRECATED);
header('Content-Type: application/json');

// Obtener datos del request
$data = json_decode(file_get_contents('php://input'), true);
include './db.php';

if ($conn->connect_error) {
    ob_end_clean();
    die(json_encode(['error' => "Conexión fallida: " . $conn->connect_error]));
}

// Variables de sesión
session_start();
$idusrv = $_SESSION['idUser'] ?? null;
$paquete = $_SESSION['paquete'] ?? null;

if (!$idusrv || !$paquete) {
    ob_end_clean();
    http_response_code(400);
    die(json_encode(['error' => 'Datos de sesión inválidos']));
}

// SDK Mercado Pago v3.3.0 
require_once 'vendor/autoload.php';
use MercadoPago\Client\Common\RequestOptions;
use MercadoPago\Client\Payment\PaymentClient;
use MercadoPago\Client\Customer\CustomerClient;
use MercadoPago\Client\Customer\CustomerCardClient;
use MercadoPago\Exceptions\MPApiException;
use MercadoPago\MercadoPagoConfig;

// Configurar SDK // PR::: APP_USR-5884940483219894-043014-2fc1d8a754811f35c443238d8031c469-21071102 TEST::: TEST-7009180377754289-091823-3aea4b50c4898192e8bd32dac3b11d7c-1940582280
MercadoPagoConfig::setAccessToken("APP_USR-5884940483219894-043014-2fc1d8a754811f35c443238d8031c469-21071102");


// Obtener información del paquete
$sqlP = "SELECT clases, costo, vigencia, invitados, descuento FROM paquetes WHERE id = ?";
$stmtP = $conn->prepare($sqlP);
$stmtP->bind_param("i", $paquete);
$stmtP->execute();
$resultP = $stmtP->get_result();

if ($resultP->num_rows === 0) {
    ob_end_clean();
    http_response_code(400);
    die(json_encode(['error' => 'Paquete no encontrado']));
}

$rowP = $resultP->fetch_assoc();
$credits = $rowP['clases'];
$vigencia = $rowP['vigencia'];
$invitados = $rowP['invitados'];


    if(!empty($rowP['descuento'])){
        $costo1 = ($rowP['costo'] / 100) * $rowP['descuento'];
        $costo2 = $rowP['costo'] - $costo1;
        $cargo1 = (float) $costo2;
    }else{
        $cargo1 = (float) $rowP['costo'];
    }
// Datos del usuario
$sql = "SELECT nombre, apellido, mail, numero, credit, claseBienvenida, customer_id FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $idusrv);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    ob_end_clean();
    http_response_code(404);
    die(json_encode(['error' => 'Usuario no encontrado']));
}

$row = $result->fetch_assoc();
if($row['claseBienvenida'] == 1 && $paquete == 1){
    ob_end_clean();
    echo json_encode(['error' => "CLASE BIENVENIDA UTILIZADA"]);
    exit;
}

$nombre = $row['nombre'];
$apellido = $row['apellido'];
$numero = $row['numero'];
$creditos = $row['credit'];
$mail = $row['mail'];
$customer_id = $row['customer_id'];

// Inicializar clientes
$payment_client = new PaymentClient();
$customer_client = new CustomerClient();
$customer_card_client = new CustomerCardClient();

try {
    // 1. Manejo del Customer en Mercado Pago
    if (empty($customer_id)) {
        $customer = $customer_client->create([
            "email" => $mail,
            "first_name" => $nombre,
            "last_name" => $apellido,
            "phone" => [
                "area_code" => "",
                "number" => $numero
            ]
        ]);
        $customer_id = $customer->id;

        // Actualizar customer_id en la base de datos
        $stmt_update_customer = $conn->prepare("UPDATE users SET customer_id = ? WHERE id = ?");
        $stmt_update_customer->bind_param("si", $customer_id, $idusrv);
        $stmt_update_customer->execute();
    }

    // 2. Procesar el pago
    $paymentData = [
        "transaction_amount" => $cargo1,
        "description" => $data['description'] ?? "Compra de clases",
        "payment_method_id" => $data['payment_method_id'],
        "payer" => [
            "email" => $mail,
            "identification" => [
                "type" => $data['payer']['identification']['type'] ?? "DNI",
                "number" => $data['payer']['identification']['number'] ?? ""
            ]
        ]
    ];

    // Si es pago con tarjeta guardada
    if (isset($data['card_id']) && isset($data['cvv'])) {
        $paymentData['token'] = $data['card_id'];
        $paymentData['payer']['id'] = $customer_id;
    } 
    // Si es pago con nueva tarjeta
    elseif (isset($data['token'])) {
        $paymentData['token'] = $data['token'];
        $paymentData['installments'] = $data['installments'] ?? 1;
        $paymentData['issuer_id'] = $data['issuer_id'] ?? null;
    } else {
        throw new Exception('Datos de pago incompletos');
    }

   // Versión corregida para SDK v3.x


    $request_options = new RequestOptions();
    $request_options->setCustomHeaders([
        'x-idempotency-key' => uniqid()
    ]);

    $payment = $payment_client->create($paymentData, $request_options);
    
    // Log de la respuesta
    file_put_contents('./log.txt', date("Y-m-d H:i:s") . " - " . json_encode($payment) . PHP_EOL, FILE_APPEND);

    $payment_status = $payment->status;
    if($credits == "ILIMITADO"){
        $credits = 9999;
    }
    $new_credit = $credits;
    
    // 3. Si el pago fue aprobado
    if ($payment_status === "approved") {
    

    $fechaCredit = date('Y-m-d');
    $dias = (int)$vigencia; // si vigencia viene como número de días

    $vence = date('Y-m-d', strtotime("+{$dias} days"));

    $bienvenida = ($paquete == 1 || $row['claseBienvenida'] == 1) ? 1 : 0;

    $sql_update = "UPDATE users 
                   SET credit = ?, 
                       venceCredit = ?, 
                       fechaCredit = ?, 
                       maxInvitados = ?, 
                       claseBienvenida = ?, 
                       statu = ?, 
                       idpago = ?, 
                       montoPagado = ? 
                   WHERE id = ?";

    $stmt_update = $conn->prepare($sql_update);
    if (!$stmt_update) {
        die('Error en prepare: ' . $conn->error);
    }

    $stmt_update->bind_param(
        "issiissdi",
        $new_credit,
        $dias,      // venceCredit
        $vence, // fechaCredit
        $invitados,
        $bienvenida,
        $payment_status,
        $payment->id,
        $cargo1,
        $idusrv
    );

 


    if (!$stmt_update->execute()) {
    die('Error en execute: ' . $stmt_update->error);
    }
    
    // Registrar transacción
    $dateNow = date('Y-m-d H:i:s', time());
    $method = "3"; // Método de pago (Mercado Pago)
    $stmt_trans = $conn->prepare("INSERT INTO transacciones (user, monto, creditos, numero, metodo, idpago, mrecibido, fecha) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt_trans->bind_param("ssssssss", $idusrv, $cargo1, $credits, $numero, $method, $payment->id, $payment->transaction_details->net_received_amount, $dateNow);
    $stmt_trans->execute();

    // 4. Guardar tarjeta si es necesario
    if (($data['save_card'] ?? false) === true && isset($payment->card->id)) {
        $card_id = $payment->card->id;
        
        // Verificar si la tarjeta ya está registrada
        $stmt_check = $conn->prepare("SELECT id FROM user_cards WHERE user_id = ? AND card_id = ?");
        $stmt_check->bind_param("is", $idusrv, $card_id);
        $stmt_check->execute();
        $stmt_check->store_result();
        
        if ($stmt_check->num_rows === 0) {
            try {
                // Registrar tarjeta en Mercado Pago
                $card = $customer_card_client->create($customer_id, [
                    "token" => $data['token'],
                    "issuer" => [
                        "id" => $data['issuer_id'] ?? null
                    ]
                ]);
                
                // Guardar en nuestra base de datos
                $last_four = substr($payment->card->last_four_digits ?? '0000', -4);
                $payment_method = $payment->payment_method_id ?? 'unknown';
                $card_type = $payment->card->card_type ?? 'credit';
                
                $stmt_save = $conn->prepare("INSERT INTO user_cards 
                    (user_id, customer_id, card_id, last_four_digits, payment_method, card_type, created_at) 
                    VALUES (?, ?, ?, ?, ?, ?, NOW())");
                $stmt_save->bind_param("isssss", $idusrv, $customer_id, $card_id, $last_four, $payment_method, $card_type);
                $stmt_save->execute();
                
                $response['card_id'] = $card_id;
                $response['customer_id'] = $customer_id;
            } catch (Exception $e) {
                error_log("Excepción al guardar tarjeta: " . $e->getMessage());
            }
        }
    }
    } else {
    $status_update = ($payment_status === "pending") ? $payment_status : "Rechazo por MP";
    $stmt_update = $conn->prepare("UPDATE users SET status = ?, idpago = ?, montoPagado = ? WHERE id = ?");
    $stmt_update->bind_param("sssi", $status_update, $payment->id, $cargo1, $idusrv);
    $stmt_update->execute();
    }

    // Preparar respuesta
    $response = [
        'payment_id' => $payment->id,
        'payment_status' => $payment_status,
        'transaction_details' => [
            'net_received_amount' => $payment->transaction_details->net_received_amount,
            'total_paid_amount' => $payment->transaction_details->total_paid_amount,
            'external_resource_url' => $payment->transaction_details->external_resource_url ?? null
        ]
    ];

    // Limpiar buffer y enviar respuesta
    ob_end_clean();
    echo json_encode($response);

} catch (MPApiException $e) {
    ob_end_clean();
    http_response_code($e->getApiResponse()->getStatusCode());
    echo json_encode([
        'error' => $e->getApiResponse()->getContent(),
        'message' => 'Error en la API de MercadoPago'
    ]);
} catch (\Exception $e) {
    ob_end_clean();
    http_response_code(500);
    echo json_encode([
        'error' => $e->getMessage(),
        'message' => 'Error interno del servidor'
    ]);
}
?>