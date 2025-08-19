<?php
// carrito_agregar.php
session_start();
require_once __DIR__ . '/include/conexion.php';

if (!isset($_SESSION['usuario']) || !isset($_SESSION['id_cliente'])) {
  http_response_code(401);
  exit('Debes iniciar sesión');
}

$id_cliente  = (int) $_SESSION['id_cliente'];
$id_producto = (int) ($_POST['id_producto'] ?? 0);
$id_talla    = isset($_POST['id_talla']) ? (int)$_POST['id_talla'] : 0; // NOT NULL en tu PK
$cantidad    = max(1, (int) ($_POST['cantidad'] ?? 1));

if ($id_producto <= 0 || $id_talla <= 0) {
  http_response_code(400);
  exit('Producto o talla inválida.');
}

// Validar que el producto exista
$stmt = $mysqli->prepare("SELECT 1 FROM producto WHERE id_producto = ?");
$stmt->bind_param('i', $id_producto);
$stmt->execute();
if (!$stmt->get_result()->fetch_row()) {
  http_response_code(404);
  exit('Producto no existe');
}
$stmt->close();

// Validar talla y stock (si existe producto_talla)
$hasPT = $mysqli->query("SHOW TABLES LIKE 'producto_talla'");
if ($hasPT && $hasPT->num_rows > 0) {
  $st = $mysqli->prepare("SELECT cantidad_disponible FROM producto_talla WHERE id_producto=? AND id_talla=?");
  $st->bind_param('ii', $id_producto, $id_talla);
  $st->execute();
  $st->bind_result($stock);
  if (!$st->fetch()) { http_response_code(400); exit('Talla inválida para este producto'); }
  if ((int)$stock < $cantidad) { http_response_code(400); exit('Stock insuficiente'); }
  $st->close();
}

// Buscar carrito del cliente o crearlo
$q = $mysqli->prepare("SELECT id_carrito FROM carrito WHERE id_cliente = ? LIMIT 1");
$q->bind_param('i', $id_cliente);
$q->execute();
$q->bind_result($id_carrito);
if (!$q->fetch()) {
  $q->close();
  $ins = $mysqli->prepare("INSERT INTO carrito (id_cliente) VALUES (?)");
  $ins->bind_param('i', $id_cliente);
  $ins->execute();
  $id_carrito = $ins->insert_id;
  $ins->close();
} else {
  $q->close();
}

// ¿Ya existe la línea? (PK compuesta en tu esquema)
$sel = $mysqli->prepare("SELECT cantidad FROM carrito_detalle WHERE id_carrito=? AND id_producto=? AND id_talla=?");
$sel->bind_param('iii', $id_carrito, $id_producto, $id_talla);
$sel->execute();
$sel->bind_result($cant_actual);

if ($sel->fetch()) {
  $sel->close();
  $upd = $mysqli->prepare("UPDATE carrito_detalle SET cantidad = cantidad + ? WHERE id_carrito=? AND id_producto=? AND id_talla=?");
  $upd->bind_param('iiii', $cantidad, $id_carrito, $id_producto, $id_talla);
  $upd->execute();
  $upd->close();
} else {
  $sel->close();
  $insd = $mysqli->prepare("INSERT INTO carrito_detalle (id_carrito,id_producto,id_talla,cantidad) VALUES (?,?,?,?)");
  $insd->bind_param('iiii', $id_carrito, $id_producto, $id_talla, $cantidad);
  $insd->execute();
  $insd->close();
}

echo 'OK';
