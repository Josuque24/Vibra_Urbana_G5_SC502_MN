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

$orderID = $_POST['orderID'] ?? '';
if (!$orderID) {
    http_response_code(400);
    echo json_encode(["error" => "orderID faltante"]);
    exit();
}

// 1) Obtener Access Token
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

// 2) Capturar orden
$ch = curl_init();
curl_setopt_array($ch, [
    CURLOPT_URL => PAYPAL_API_BASE . "/v2/checkout/orders/" . urlencode($orderID) . "/capture",
    CURLOPT_HTTPHEADER => [
        "Content-Type: application/json",
        "Authorization: Bearer " . $accessToken
    ],
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => "{}", 
    CURLOPT_RETURNTRANSFER => true,
]);
$captureResponse = curl_exec($ch);
if ($captureResponse === false) {
    http_response_code(500);
    echo json_encode(["error" => "No se pudo capturar la orden"]);
    exit();
}
curl_close($ch);

$data = json_decode($captureResponse, true);

// 3) Si el capture fue exitoso: limpiar carrito, registrar orden, etc.
$status = $data['status'] ?? '';
if ($status === 'COMPLETED') {
    // Limpiar carrito del usuario
    $idCliente = (int)$_SESSION['id_cliente'];
    // Buscar id_carrito
    $sc = $mysqli->prepare("SELECT id_carrito FROM carrito WHERE id_cliente = ?");
    $sc->bind_param("i", $idCliente);
    $sc->execute();
    $sc->bind_result($idCarrito);
    if ($sc->fetch()) {
        $sc->close();
        $del = $mysqli->prepare("DELETE FROM carrito_detalle WHERE id_carrito = ?");
        $del->bind_param("i", $idCarrito);
        $del->execute();
        $del->close();
    } else {
        $sc->close();
    }
}

echo $captureResponse; 
