<?php
// api/producto_detalle.php
declare(strict_types=1);
ini_set('display_errors', '0');
error_reporting(E_ALL);
header('Content-Type: application/json; charset=utf-8');

try {
  require_once __DIR__ . '/../include/conexion.php';
  if (!isset($mysqli) || !($mysqli instanceof mysqli)) {
    throw new Exception('Conexión a BD no inicializada ($mysqli).');
  }

  $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
  if ($id <= 0) {
    http_response_code(400);
    echo json_encode(['ok' => false, 'error' => 'ID inválido']);
    exit;
  }

  // Producto
  $stmt = $mysqli->prepare('
    SELECT id_producto, nombre, descripcion, precio, imagen
    FROM producto
    WHERE id_producto = ?
  ');
  if (!$stmt) throw new Exception('Prepare producto: ' . $mysqli->error);
  $stmt->bind_param('i', $id);
  $stmt->execute();
  $res = $stmt->get_result();
  $prod = $res ? $res->fetch_assoc() : null;
  if (!$prod) {
    http_response_code(404);
    echo json_encode(['ok' => false, 'error' => 'Producto no encontrado']);
    exit;
  }
  $prod['nombre'] = htmlspecialchars($prod['nombre'] ?? '', ENT_QUOTES, 'UTF-8');
  $prod['descripcion'] = htmlspecialchars($prod['descripcion'] ?? '', ENT_QUOTES, 'UTF-8');

  // Tallas con stock > 0 (usa talla.talla y producto_talla.cantidad_disponible)
  $tallas = [];
  $hasPT = $mysqli->query("SHOW TABLES LIKE 'producto_talla'");
  $hasT  = $mysqli->query("SHOW TABLES LIKE 'talla'");

  if ($hasPT && $hasPT->num_rows > 0 && $hasT && $hasT->num_rows > 0) {
    $ts = $mysqli->prepare('
      SELECT t.id_talla, t.talla AS talla, pt.cantidad_disponible
      FROM producto_talla pt
      JOIN talla t ON t.id_talla = pt.id_talla
      WHERE pt.id_producto = ? AND pt.cantidad_disponible > 0
      ORDER BY t.id_talla ASC
    ');
    if (!$ts) throw new Exception('Prepare tallas: ' . $mysqli->error);
    $ts->bind_param('i', $id);
    $ts->execute();
    $tallas = $ts->get_result()->fetch_all(MYSQLI_ASSOC);
  }

  echo json_encode(['ok' => true, 'data' => $prod, 'tallas' => $tallas], JSON_UNESCAPED_UNICODE);
} catch (Throwable $e) {
  http_response_code(500);
  echo json_encode(['ok' => false, 'error' => 'ERR_INTERNAL'], JSON_UNESCAPED_UNICODE);
}
