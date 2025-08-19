<?php
// api/productos_aleatorios.php
declare(strict_types=1);
ini_set('display_errors', '0');
error_reporting(E_ALL);
header('Content-Type: application/json; charset=utf-8');

try {
  require_once __DIR__ . '/../include/conexion.php';
  if (!isset($mysqli) || !($mysqli instanceof mysqli)) {
    throw new Exception('Conexión a BD no inicializada ($mysqli).');
  }

  // Selecciona 3 productos aleatorios
  $sql = "SELECT id_producto, nombre, precio, imagen, descripcion
          FROM producto
          ORDER BY RAND()
          LIMIT 3";
  $res = $mysqli->query($sql);
  if (!$res) {
    throw new Exception('Query error: ' . $mysqli->error);
  }

  $rows = [];
  while ($r = $res->fetch_assoc()) {
    $r['nombre'] = htmlspecialchars($r['nombre'] ?? '', ENT_QUOTES, 'UTF-8');
    $r['descripcion'] = htmlspecialchars($r['descripcion'] ?? '', ENT_QUOTES, 'UTF-8');
    $rows[] = $r;
  }

  echo json_encode(['ok' => true, 'data' => $rows], JSON_UNESCAPED_UNICODE);
} catch (Throwable $e) {
  http_response_code(500);
  echo json_encode(['ok' => false, 'error' => 'ERR_INTERNAL'], JSON_UNESCAPED_UNICODE);
}
