<?php
session_start();
if (!isset($_SESSION['usuario'])) {
  header("Location: ./login.php");
  exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Vibra Urbana - Inicio</title>
  <!-- Bootstrap CSS (mantenemos 5.3.0 como tenías) -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Tus estilos -->
  <link rel="stylesheet" href="styles/style_principal.css">
  <!-- style_modal.css removido para evitar conflictos con el modal de Bootstrap -->
</head>
<body>
  <main>

    <?php include("include/menu.php"); ?>

    <!-- Hero Section -->
    <section class="hero text-center d-flex align-items-center">
      <div class="container">
        <h1 class="mb-3">Moda Juvenil con Identidad</h1>
        <p class="lead mb-4">Explora nuestra colección sostenible, auténtica e inclusiva. ¡Vibra con estilo!</p>
        <a href="productos.php" class="btn btn-light btn-lg">Explorar Productos</a>
      </div>
    </section>

    <!-- Productos Recomendados (3 aleatorios) -->
    <section class="py-5">
      <div class="container">
        <h2 class="mb-3 text-center">Recomendados</h2>

        <!-- Aquí se inyectan 3 productos aleatorios -->
        <div id="home-productos" class="row g-3"></div>

        <!-- Botón a todos los productos -->
        <div class="text-center mt-4">
          <a href="productos.php" class="btn btn-dark">Ver todos los productos</a>
        </div>
      </div>
    </section>

  </main>

  <!-- Modal-->
  <div class="modal fade" id="productoModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 id="md-nombre" class="modal-title"></h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
          <div class="d-flex flex-column flex-md-row gap-3">
            <img id="md-img" class="img-fluid rounded" style="max-width: 280px;" alt="Producto">
            <div class="flex-grow-1">
              <p id="md-desc" class="mb-2"></p>
              <h4 id="md-precio" class="mb-3"></h4>

              <div class="mb-3" id="md-tallas"><!-- select dinámico --></div>

              <div class="input-group" style="max-width: 180px;">
                <span class="input-group-text">Cant.</span>
                <input id="md-cant" type="number" min="1" value="1" class="form-control">
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button id="md-add" class="btn btn-dark" type="button">Agregar al carrito</button>
        </div>
      </div>
    </div>
  </div>

  <?php include("include/footer.php"); ?>

  <!-- Bootstrap bundle (JS + Popper) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <!-- Lógica de Home: carga 3 productos aleatorios, abre modal y agrega al carrito -->
  <script src="javascript/home.js"></script>
</body>
</html>
