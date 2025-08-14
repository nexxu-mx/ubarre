<?php
include './db.php';
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
// Obtener el valor de idusrv del cuerpo de la solicitud
$data = json_decode(file_get_contents('php://input'), true);

session_start();
$idusrv = $_SESSION['idUser'];
$paquete = $_SESSION['paquete'];

$sqlP = "SELECT clases, costo FROM paquetes WHERE id = ?";
$stmtP = $conn->prepare($sqlP);
$stmtP->bind_param("i", $paquete);
$stmtP->execute();
$resultP = $stmtP->get_result();

if ($resultP->num_rows === 0) exit;
$rowP = $resultP->fetch_assoc();
$credits = $rowP['clases'];
$cargo = $rowP['costo'];
$cargo1 = (float) $cargo;



$descrition = $credits . "Créditos para Clases";
// Validar idusrv
if (empty($idusrv)) {
    echo json_encode(['error' => 'idusrv no proporcionado']);
    exit;
}
$sql = "SELECT id, nombre, apellido, mail FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $idusrv);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $id = $row['id'];
        $nombre = $row['nombre'];
        $apellido = $row['apellido'];
        $mail = $row['mail'];
    }
} else {
    echo json_encode(['error' => 'No se encontraron datos para el usuario especificado']);
    exit;
}
// Incluir el autoload.php de Composer para cargar las clases del SDK
require __DIR__ . '/vendor/autoload.php';
use MercadoPago\MercadoPagoConfig;
use MercadoPago\Client\Preference\PreferenceClient;
use MercadoPago\Exceptions\MPApiException;
// Agregar las credenciales del ambiente de producción usando MercadoPagoConfig. PR::: APP_USR-5884940483219894-043014-2fc1d8a754811f35c443238d8031c469-21071102 TEST::: TEST-7009180377754289-091823-3aea4b50c4898192e8bd32dac3b11d7c-1940582280
MercadoPagoConfig::setAccessToken('APP_USR-5884940483219894-043014-2fc1d8a754811f35c443238d8031c469-21071102');
function createPaymentPreference($product, $payer) {
    // Crear la preferencia de pago
    $preferenceClient = new PreferenceClient();
    $preferenceRequest = [
        'items' => [$product],
        'payer' => $payer,
        'back_urls' => [
            "success" => "https://studiosencia.com/pago.php?f9489989srfg482j389fd98f8=" . $idusrv . "&",
            "failure" => "https://studiosencia.com/pago.php?8237fuhiasfh749849h0f8h=" . $idusrv . "&",
            "pending" => "https://studiosencia.com/pago.php?000vsjds99040vi0ri=" . $idusrv . "&"
        ],
        'auto_return' => "approved"
    ];

    try {
        // Enviar la solicitud para crear la preferencia
        $preference = $preferenceClient->create($preferenceRequest);

        // Devolver la preferencia creada
        return $preference;
    } catch (MPApiException $error) {
        // Manejar la excepción si ocurre un error en la API de Mercado Pago
        error_log('Error al crear la preferencia de pago: ' . $error->getMessage());
        return null;
    }
}
// Definir los datos del producto
$product = [
    "id" => $id,
    "title" => "SENCIA Studio",
    "description" => $descrition,
    "currency_id" => "MXN",
    "quantity" => 1,
    "unit_price" => $cargo1
];
// Definir los datos del pagador
$payer = [
    "name" => $nombre,
    "surname" => $apellido,
    "email" => $mail
];
$preference = createPaymentPreference($product, $payer);
if ($preference) {
    echo json_encode(['id' => $preference->id]);
} else {
    echo json_encode(['error' => 'No se pudo crear la preferencia']);
}
?>
