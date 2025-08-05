<?php 
session_start();
if (!isset($_SESSION['usuario'] )) {
    header("Location: ./login.php");
    exit();
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
        <th>Producto</th>
        <th>Cantidad</th>
        <th>Precio</th>
        <th>Total</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>Camiseta Urbana</td>
        <td><input type="number" value="1" min="1" class="form-control text-center"></td>
        <td>₡12,000</td>
        <td>₡12,000</td>
        <td><button class="btn btn-danger btn-sm">Eliminar</button></td>
      </tr>
      <!-- Más productos aquí -->
    </tbody>
  </table>





    <div class="text-end">
      <h4>Total: <span class="text-success">₡12,000</span></h4>
      <button class="btn btn-primary mt-2">Pagar con PayPal</button>
    </div>
  </div>

  <!-- Footer -->
  <footer>
    <p class="mb-0">&copy; 2025 Vibra Urbana. Todos los derechos reservados.</p>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
