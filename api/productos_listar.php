<?php
declare(strict_types=1);
ini_set('display_errors', '0');
error_reporting(E_ALL);
header('Content-Type: application/json; charset=utf-8');

try {
  require_once __DIR__ . '/../include/conexion.php';
  if (!isset($mysqli) || !($mysqli instanceof mysqli)) {
    throw new Exception('Conexión a BD no inicializada ($mysqli).');
  }

  $cat   = isset($_GET['cat']) ? (int)$_GET['cat'] : null;
  $sub   = isset($_GET['subcat']) ? (int)$_GET['subcat'] : null;
  $q     = isset($_GET['q']) ? trim((string)$_GET['q']) : '';
  $page  = max(1, (int)($_GET['page'] ?? 1));
  $size  = min(24, max(1, (int)($_GET['size'] ?? 12)));
  $off   = ($page - 1) * $size;

  $sql = "SELECT id_producto, nombre, precio, imagen, descripcion
          FROM producto
          WHERE 1=1";
  $types = '';
  $params = [];

  if ($cat) { $sql .= " AND id_categoria = ?";   $types .= 'i'; $params[] = $cat; }
  if ($sub) { $sql .= " AND id_subcategoria = ?";$types .= 'i'; $params[] = $sub; }
  if ($q !== '') { $sql .= " AND nombre LIKE ?"; $types .= 's'; $params[] = "%$q%"; }

  $sql .= " ORDER BY id_producto DESC LIMIT ? OFFSET ?";
  $types .= 'ii'; $params[] = $size; $params[] = $off;

  $stmt = $mysqli->prepare($sql);
  if (!$stmt) throw new Exception('Prepare listar: ' . $mysqli->error);
  if ($types !== '') $stmt->bind_param($types, ...$params);
  $stmt->execute();
  $res = $stmt->get_result();

  $rows = [];
  while ($r = $res->fetch_assoc()) {
    $r['nombre'] = htmlspecialchars($r['nombre'] ?? '', ENT_QUOTES, 'UTF-8');
    $r['descripcion'] = htmlspecialchars($r['descripcion'] ?? '', ENT_QUOTES, 'UTF-8');
    $rows[] = $r;
  }

  echo json_encode(['ok' => true, 'data' => $rows, 'page' => $page, 'size' => $size], JSON_UNESCAPED_UNICODE);
} catch (Throwable $e) {
  http_response_code(500);
  echo json_encode(['ok' => false, 'error' => 'ERR_INTERNAL'], JSON_UNESCAPED_UNICODE);
}
