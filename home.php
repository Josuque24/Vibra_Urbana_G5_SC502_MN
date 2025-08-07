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
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="styles/style_principal.css">
</head>

<body>

  <?php include("include/menu.php"); ?>



  <!-- Hero Section -->
  <section class="hero text-center d-flex align-items-center">
    <div class="container">
      <h1 class="mb-3">Moda Juvenil con Identidad</h1>
      <p class="lead mb-4">Explora nuestra colección sostenible, auténtica e inclusiva. ¡Vibra con estilo!</p>
      <a href="#" class="btn btn-light btn-lg">Explorar Productos</a>
    </div>
  </section>

  <!-- Productos Destacados -->
  <section class="py-5">
    <div class="container text-center">
      <h2 class="mb-4">Productos Destacados</h2>
      <div class="row g-4">
        <div class="col-md-4">
          <div class="card producto h-100">
            <img
              src="https://litb-cgis.rightinthebox.com/images/640x640/202306/bps/product/inc/zhlnfn1687426499724.jpg?fmt=webp&v=1"
              class="card-img-top" alt="Bolso de playa">
            <div class="card-body">
              <h5 class="card-title">Bolso de playa</h5>
              <p class="card-text">₡6,500</p>
              <a href="#" class="btn btn-outline-dark">Ver más</a>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card producto h-100">
            <img
              src="https://hips.hearstapps.com/hmg-prod/images/camiseta-de-corte-relajado-de-levi-s-17-50-euros-1627560346.png?crop=0.992xw:0.992xh;0.00417xw,0.00417xh&resize=980:*"
              class="card-img-top" alt="Camiseta Oversize">
            <div class="card-body">
              <h5 class="card-title">Camiseta Oversize</h5>
              <p class="card-text">₡12,000</p>
              <a href="#" class="btn btn-outline-dark">Ver más</a>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card producto h-100">
            <img src="https://cbu01.alicdn.com/img/ibank/O1CN01MrzNf32LVHXYY5oKQ_!!4016249697-0-cib.jpg"
              class="card-img-top" alt="Traje de Baño">
            <div class="card-body">
              <h5 class="card-title">Traje de Baño</h5>
              <p class="card-text">₡12,500</p>
              <a href="#" class="btn btn-outline-dark">Ver más</a>
            </div>
          </div>
        </div>
        <div class="text-center mt-4">
          <a href="productos.php" class="btn btn-lg custom-btn-naranja">Ver más productos</a>
        </div>
      </div>
    </div>
  </section>

  <?php include("include/footer.php"); ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <!--<script src="./javascript/navbar_script.js"></script>-->
</body>

</html>