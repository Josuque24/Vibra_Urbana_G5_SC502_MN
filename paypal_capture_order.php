<?php
session_start();
require_once("include/conexion.php");
require_once("include/paypal_config.php");

header('Content-Type: application/json; charset=utf-8');

// 1) Seguridad básica: debe estar logueado
if (!isset($_SESSION['id_cliente'])) {
    http_response_code(403);
    echo json_encode(["error" => "No autorizado"]);
    exit();
}

$idCliente = (int)$_SESSION['id_cliente'];

// 2) Validar parámetro requerido
$orderID = $_POST['orderID'] ?? '';
if (!$orderID) {
    http_response_code(400);
    echo json_encode(["error" => "orderID faltante"]);
    exit();
}

// Función auxiliar para solicitar Access Token
function paypal_get_access_token() {
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
        curl_close($ch);
        return [null, "No se pudo obtener token"];
    }
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode < 200 || $httpCode >= 300) {
        return [null, "Error HTTP al pedir token: $httpCode"];
    }

    $tokenData = json_decode($tokenResponse, true);
    $accessToken = $tokenData['access_token'] ?? null;
    if (!$accessToken) {
        return [null, "Token inválido"];
    }
    return [$accessToken, null];
}

// 3) Obtener Access Token
list($accessToken, $tokenErr) = paypal_get_access_token();
if (!$accessToken) {
    http_response_code(500);
    echo json_encode(["error" => $tokenErr ?: "No se pudo obtener token"]);
    exit();
}

// 4) Capturar la orden
$ch = curl_init();
curl_setopt_array($ch, [
    CURLOPT_URL => PAYPAL_API_BASE . "/v2/checkout/orders/" . urlencode($orderID) . "/capture",
    CURLOPT_HTTPHEADER => [
        "Content-Type: application/json",
        "Authorization: Bearer " . $accessToken
    ],
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => "{}", // Body vacío, pero debe ser POST
    CURLOPT_RETURNTRANSFER => true,
]);
$captureResponse = curl_exec($ch);
if ($captureResponse === false) {
    $err = curl_error($ch);
    curl_close($ch);
    http_response_code(500);
    echo json_encode(["error" => "No se pudo capturar la orden", "detail" => $err]);
    exit();
}
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

// Si PayPal devuelve error HTTP
if ($httpCode < 200 || $httpCode >= 300) {
    http_response_code($httpCode);
    echo $captureResponse; // devolver tal cual para diagnóstico
    exit();
}

// 5) Procesar JSON de PayPal
$data = json_decode($captureResponse, true);

// Campos útiles
$status       = $data['status'] ?? '';
$order_id     = $data['id'] ?? '';
$captureNode  = $data['purchase_units'][0]['payments']['captures'][0] ?? [];
$capture_id   = $captureNode['id'] ?? '';
$amountValue  = $captureNode['amount']['value'] ?? '0.00';
$currency     = $captureNode['amount']['currency_code'] ?? (defined('PAYPAL_CURRENCY') ? PAYPAL_CURRENCY : 'USD');
$createTime   = $captureNode['create_time'] ?? '';
$updateTime   = $captureNode['update_time'] ?? '';
$payer_email  = $data['payer']['email_address'] ?? '';
$payer_name   = trim(($data['payer']['name']['given_name'] ?? '') . ' ' . ($data['payer']['name']['surname'] ?? ''));

// 6) Si la captura fue exitosa
if ($status === 'COMPLETED') {
    // Guardar solo el total para "gracias.php"
    $_SESSION['paypal_total_paid'] = number_format((float)$amountValue, 2, '.', ',') . ' ' . $currency;

    // (Opcional) Si quieres mostrar más datos en "gracias.php", puedes guardar un recibo completo:
    $_SESSION['paypal_receipt'] = [
        'status'      => $status,
        'order_id'    => $order_id,
        'capture_id'  => $capture_id,
        'payer_name'  => $payer_name,
        'payer_email' => $payer_email,
        'amount'      => $amountValue,
        'currency'    => $currency,
        'create_time' => $createTime,
        'update_time' => $updateTime,
    ];

    // (Opcional, activado) Limpiar carrito del usuario
    // Si prefieres limpiar sólo tras guardar una orden en BD, mueve esto al flujo de creación de orden.
    // Buscar id_carrito
    $idCarrito = null;
    $sc = $mysqli->prepare("SELECT id_carrito FROM carrito WHERE id_cliente = ?");
    $sc->bind_param("i", $idCliente);
    $sc->execute();
    $sc->bind_result($idCarrito);
    $sc->fetch();
    $sc->close();

    if ($idCarrito) {
        $del = $mysqli->prepare("DELETE FROM carrito_detalle WHERE id_carrito = ?");
        $del->bind_param("i", $idCarrito);
        $del->execute();
        $del->close();
    }

    // Devolver respuesta mínima esperada por onApprove (JS)
    echo json_encode([
        "status" => "COMPLETED",
        // Si más adelante guardas orden en BD, agrega aquí: "orden_id" => $idOrden
    ]);
    exit();
}

// 7) Si no está COMPLETED, devuelve la respuesta cruda para diagnóstico
echo $captureResponse;
