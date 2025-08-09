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
$cantidad   = (int)($_POST['cantidad'] ?? 0);

if ($idProducto <= 0 || $idTalla <= 0 || $cantidad <= 0) {
    http_response_code(400);
    echo "Datos inválidos";
    exit();
}

// Buscar carrito
$stmt = $mysqli->prepare("SELECT id_carrito FROM carrito WHERE id_cliente = ?");
$stmt->bind_param("i", $idCliente);
$stmt->execute();
$stmt->bind_result($idCarrito);
if (!$stmt->fetch()) {
    http_response_code(404);
    echo "Carrito no encontrado";
    exit();
}
$stmt->close();

// Verificar stock disponible
$st = $mysqli->prepare("SELECT cantidad_disponible FROM producto_talla WHERE id_producto=? AND id_talla=?");
$st->bind_param("ii", $idProducto, $idTalla);
$st->execute();
$st->bind_result($stock);
if (!$st->fetch()) {
    http_response_code(404);
    echo "No existe stock para ese producto/talla";
    exit();
}
$st->close();

if ($cantidad > $stock) {
    http_response_code(409); // conflicto
    echo "No hay stock suficiente. Disponible: $stock";
    exit();
}

// Actualizar cantidad en carrito_detalle
$up = $mysqli->prepare("
    UPDATE carrito_detalle 
    SET cantidad = ? 
    WHERE id_carrito = ? AND id_producto = ? AND id_talla = ?
");
$up->bind_param("iiii", $cantidad, $idCarrito, $idProducto, $idTalla);
$up->execute();

if ($up->affected_rows < 0) {
    http_response_code(500);
    echo "Error al actualizar la cantidad";
    exit();
}
$up->close();

// Subtotal del item
$qItem = $mysqli->prepare("
    SELECT p.precio, (p.precio * cd.cantidad) AS subtotal
    FROM carrito_detalle cd
    JOIN producto p ON p.id_producto = cd.id_producto
    WHERE cd.id_carrito = ? AND cd.id_producto = ? AND cd.id_talla = ?
");
$qItem->bind_param("iii", $idCarrito, $idProducto, $idTalla);
$qItem->execute();
$qItem->bind_result($precio, $itemSubtotal);
$qItem->fetch();
$qItem->close();

// Total del carrito
$qTotal = $mysqli->prepare("
    SELECT COALESCE(SUM(p.precio * cd.cantidad), 0) AS total
    FROM carrito_detalle cd
    JOIN producto p ON p.id_producto = cd.id_producto
    WHERE cd.id_carrito = ?
");
$qTotal->bind_param("i", $idCarrito);
$qTotal->execute();
$qTotal->bind_result($cartTotal);
$qTotal->fetch();
$qTotal->close();

// Formateo ₡
function crcFmt($n) { return '₡' . number_format((float)$n, 0, ',', '.'); }

echo json_encode([
    "ok" => true,
    "itemSubtotal"   => (float)$itemSubtotal,
    "itemSubtotalFmt"=> crcFmt($itemSubtotal),
    "cartTotal"      => (float)$cartTotal,
    "cartTotalFmt"   => crcFmt($cartTotal)
]);
