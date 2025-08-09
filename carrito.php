<?php
session_start();
if (!isset($_SESSION['usuario'])) {
  header("Location: ./login.php");
  exit();
}
require_once("include/conexion.php");

$idCliente = $_SESSION['id_cliente'] ?? null;

// Buscar o crear carrito del cliente
$idCarrito = null;
if ($idCliente) {
  $stmt = $mysqli->prepare("SELECT id_carrito FROM carrito WHERE id_cliente = ?");
  $stmt->bind_param("i", $idCliente);
  $stmt->execute();
  $stmt->bind_result($idCarrito);
  if (!$stmt->fetch()) {
    $stmt->close();
    // Crear carrito si no existe
    $ins = $mysqli->prepare("INSERT INTO carrito (id_cliente) VALUES (?)");
    $ins->bind_param("i", $idCliente);
    $ins->execute();
    $idCarrito = $ins->insert_id;
    $ins->close();
  } else {
    $stmt->close();
  }
}

// Traer detalle del carrito con producto, imagen, talla
$items = [];
$total = 0;

if ($idCarrito) {
  $sql = "
        SELECT 
            cd.id_producto,
            cd.id_talla,
            p.nombre AS producto,
            p.imagen,
            t.talla,
            cd.cantidad,
            p.precio,
            (cd.cantidad * p.precio) AS subtotal
        FROM carrito_detalle cd
        JOIN producto p      ON p.id_producto = cd.id_producto
        JOIN talla t         ON t.id_talla    = cd.id_talla
        WHERE cd.id_carrito = ?
        ORDER BY p.nombre ASC, t.talla ASC
    ";
  $q = $mysqli->prepare($sql);
  $q->bind_param("i", $idCarrito);
  $q->execute();
  $res = $q->get_result();
  while ($row = $res->fetch_assoc()) {
    $items[] = $row;
    $total += (float)$row['subtotal'];
  }
  $q->close();
}

function crc($n)
{
  // ₡12,000
  return '₡' . number_format((float)$n, 0, ',', '.');
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <title>Carrito - Vibra Urbana</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="./styles/style_carrito.css">
  <link rel="stylesheet" href="./styles/style_principal.css">
</head>

<body>

  <!-- Nav bar -->
  <?php include("include/menu.php"); ?>

  <!-- Carrito de compras -->
  <div class="container my-5">
    <h2 class="mb-4 text-center">Tu Carrito de Compras</h2>

    <table class="table table-bordered align-middle text-center custom-cart-table">
      <thead class="cart-header">
        <tr>
          <th>Imagen</th>
          <th>Producto</th>
          <th>Talla</th>
          <th>Cantidad</th>
          <th>Precio</th>
          <th>Total</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($items)): ?>
          <tr>
            <td colspan="7" class="text-center">Tu carrito está vacío.</td>
          </tr>
        <?php else: ?>
          <?php foreach ($items as $it): ?>
            <tr
              data-id-producto="<?= (int)$it['id_producto'] ?>"
              data-id-talla="<?= (int)$it['id_talla'] ?>">
              <td style="width:90px">
                <?php
                $img = trim($it['imagen'] ?? '');

                // Si no hay imagen, usa placeholder local
                if ($img === '') {
                  $src = "assets/img/placeholder.png";
                }
                // Si es una URL completa (http/https), úsala tal cual
                elseif (preg_match('~^https?://~i', $img)) {
                  $src = $img;
                }
                // Si no, trátala como archivo local dentro de assets/img
                else {
                  // Si tu BD podría tener espacios en nombres de archivo:
                  $img = str_replace(' ', '%20', $img);
                  $src = "assets/img/{$img}";
                }
                ?>

                <img src="<?= htmlspecialchars($src) ?>" alt="<?= htmlspecialchars($it['producto']) ?>" class="img-thumbnail" style="max-width:70px">
              </td>
              <td><?= htmlspecialchars($it['producto']) ?></td>
              <td><?= htmlspecialchars($it['talla']) ?></td>
              <td style="width:120px">
                <input
                  type="number"
                  value="<?= (int)$it['cantidad'] ?>"
                  min="1"
                  class="form-control text-center qty-input">
              </td>
              <td><?= crc($it['precio']) ?></td>
              <td><span class="item-subtotal"><?= crc($it['subtotal']) ?></span></td>
              <td>
                <button class="btn btn-danger btn-sm btn-eliminar">Eliminar</button>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>

    </table>

    <div class="text-end">
      <h4>Total:
        <span id="cart-total" data-total="<?= (float)$total ?>"><?= crc($total) ?></span>
      </h4>
      <h6>PayPal de momento solo cobra en dólares <br> 
        Pero hacemos la conversión por ti 526 CRC ≈ 1 USD</h6>

      <!-- data-has-items: "1" si hay ítems, "0" si no -->
      <div id="paypal-button-container"
        data-has-items="<?= empty($items) ? '0' : '1' ?>"
        data-currency="USD"></div>
    </div>




    <?php include("include/footer.php"); ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="javascript/carrito.js"></script>
    <!--<script src="https://www.paypal.com/sdk/js?client-id=AaHttcXRHc76ugtZ2YgtRFDP7r5-WbJTuq7L0G-iA2p0u1NqFrNu8OPvOGhx3oJpQM4e8vH1ie4K42jy&currency=USD"></script>-->
    <script src="https://www.paypal.com/sdk/js?client-id=AaHttcXRHc76ugtZ2YgtRFDP7r5-WbJTuq7L0G-iA2p0u1NqFrNu8OPvOGhx3oJpQM4e8vH1ie4K42jy&currency=USD&disable-funding=card"></script>
    <script src="javascript/paypal.js"></script>


</body>

</html>