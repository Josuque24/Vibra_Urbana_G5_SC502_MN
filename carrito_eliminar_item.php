<?php
session_start();
require_once("include/conexion.php");

header('Content-Type: application/json; charset=utf-8');

if (!isset($_SESSION['id_cliente'])) {
    http_response_code(403);
    echo "No autorizado";
    exit();
}

$idCliente = (int)$_SESSION['id_cliente'];
$idProducto = (int)($_POST['id_producto'] ?? 0);
$idTalla    = (int)($_POST['id_talla'] ?? 0);

if ($idProducto <= 0 || $idTalla <= 0) {
    http_response_code(400);
    echo "Datos inválidos";
    exit();
}

// Obtener carrito
$sc = $mysqli->prepare("SELECT id_carrito FROM carrito WHERE id_cliente = ?");
$sc->bind_param("i", $idCliente);
$sc->execute();
$sc->bind_result($idCarrito);
if (!$sc->fetch()) {
    http_response_code(404);
    echo "Carrito no encontrado";
    exit();
}
$sc->close();

// Eliminar ítem
$del = $mysqli->prepare("
    DELETE FROM carrito_detalle 
    WHERE id_carrito = ? AND id_producto = ? AND id_talla = ?
");
$del->bind_param("iii", $idCarrito, $idProducto, $idTalla);
$del->execute();
$del->close();

// Recalcular total
$qt = $mysqli->prepare("
    SELECT COALESCE(SUM(p.precio * cd.cantidad), 0) AS total
    FROM carrito_detalle cd
    JOIN producto p ON p.id_producto = cd.id_producto
    WHERE cd.id_carrito = ?
");
$qt->bind_param("i", $idCarrito);
$qt->execute();
$qt->bind_result($cartTotal);
$qt->fetch();
$qt->close();

function crcFmt($n) { return '₡' . number_format((float)$n, 0, ',', '.'); }

echo json_encode([
    "ok" => true,
    "cartTotal"    => (float)$cartTotal,
    "cartTotalFmt" => crcFmt($cartTotal)
]);
