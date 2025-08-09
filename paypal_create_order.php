<?php
session_start();
require_once("include/conexion.php");
require_once("include/paypal_config.php");

header('Content-Type: application/json; charset=utf-8');

if (!isset($_SESSION['id_cliente'])) {
    http_response_code(403);
    echo json_encode(["error" => "No autorizado"]);
    exit();
}

$idCliente = (int)$_SESSION['id_cliente'];

// 1) Calcular total del carrito en CRC
$sql = "
  SELECT COALESCE(SUM(p.precio * cd.cantidad), 0) AS total_crc
  FROM carrito_detalle cd
  JOIN producto p ON p.id_producto = cd.id_producto
  JOIN carrito c  ON c.id_carrito = cd.id_carrito
  WHERE c.id_cliente = ?
";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("i", $idCliente);
$stmt->execute();
$stmt->bind_result($total_crc);
$stmt->fetch();
$stmt->close();

if ($total_crc <= 0) {
    http_response_code(400);
    echo json_encode(["error" => "Carrito vacío"]);
    exit();
}

// 2) Convertir a USD
$total_usd = $total_crc * EXCHANGE_RATE_CRC_USD;
$amount_value = number_format($total_usd, 2, '.', '');

// 3) Obtener Access Token
$ch = curl_init();
curl_setopt_array($ch, [
    CURLOPT_URL => PAYPAL_API_BASE . "/v1/oauth2/token",
    CURLOPT_HTTPHEADER => [
        "Accept: application/json",
        "Accept-Language: en_US"
    ],
    CURLOPT_USERPWD => PAYPAL_CLIENT_ID . ":" . PAYPAL_SECRET,
    CURLOPT_POSTFIELDS => "grant_type=client_credentials",
    CURLOPT_POST => true,
    CURLOPT_RETURNTRANSFER => true,
]);
$tokenResponse = curl_exec($ch);
if ($tokenResponse === false) {
    http_response_code(500);
    echo json_encode(["error" => "No se pudo obtener token"]);
    exit();
}
$tokenData = json_decode($tokenResponse, true);
curl_close($ch);

$accessToken = $tokenData['access_token'] ?? null;
if (!$accessToken) {
    http_response_code(500);
    echo json_encode(["error" => "Token inválido"]);
    exit();
}

// 4) Crear la orden (intent: CAPTURE)
$payload = [
    "intent" => "CAPTURE",
    "purchase_units" => [[
        "amount" => [
            "currency_code" => PAYPAL_CURRENCY,
            "value" => $amount_value
        ]]
    ]
];

$ch = curl_init();
curl_setopt_array($ch, [
    CURLOPT_URL => PAYPAL_API_BASE . "/v2/checkout/orders",
    CURLOPT_HTTPHEADER => [
        "Content-Type: application/json",
        "Authorization: Bearer " . $accessToken
    ],
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => json_encode($payload),
    CURLOPT_RETURNTRANSFER => true,
]);
$orderResponse = curl_exec($ch);
if ($orderResponse === false) {
    http_response_code(500);
    echo json_encode(["error" => "No se pudo crear la orden"]);
    exit();
}
curl_close($ch);

echo $orderResponse; // Devuelve JSON con {id: "...", status: "...", ...}
