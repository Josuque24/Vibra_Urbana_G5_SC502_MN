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
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Categorías - Vibra Urbana</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="styles/style_categorias.css">
</head>
<body>
<main>

  <!-- Navbar -->
  <?php include("include/menu.php"); ?>


<!-- Categorías -->
<section class="py-5 bg-light">
  <div class="container text-center">
    <h2 class="mb-4">Categorías</h2>
    <div class="row g-4">
      <div class="col-md-3 col-6">
        <div class="card categoria-card h-100">
          <div class="card-body">
            <h5 class="card-title">Niños</h5>
          </div>
        </div>
      </div>
      <div class="col-md-3 col-6">
        <div class="card categoria-card h-100">
          <div class="card-body">
            <h5 class="card-title">Bikinis</h5>
          </div>
        </div>
      </div>
      <div class="col-md-3 col-6">
        <div class="card categoria-card h-100">
          <div class="card-body">
            <h5 class="card-title">Oversize</h5>
          </div>
        </div>
      </div>
      <div class="col-md-3 col-6">
        <div class="card categoria-card h-100">
          <div class="card-body">
            <h5 class="card-title">Accesorios</h5>
          </div>
        </div>
      </div>
      <div class="col-md-3 col-6">
        <div class="card categoria-card h-100">
          <div class="card-body">
            <h5 class="card-title">Ropa Zayin</h5>
          </div>
        </div>
      </div>
      <div class="col-md-3 col-6">
        <div class="card categoria-card h-100">
          <div class="card-body">
            <h5 class="card-title">Ropa para Mujer</h5>
          </div>
        </div>
      </div>
      <div class="col-md-3 col-6">
        <div class="card categoria-card h-100">
          <div class="card-body">
            <h5 class="card-title">Ropa para Hombre</h5>
          </div>
        </div>
      </div>
      <div class="col-md-3 col-6">
        <div class="card categoria-card h-100">
          <div class="card-body">
            <h5 class="card-title">Billeteras y Carteras</h5>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
</main>

<?php include("include/footer.php"); ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>