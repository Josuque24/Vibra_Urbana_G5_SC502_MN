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
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Categorías - Vibra Urbana</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="styles/style_categorias.css">
</head>
<body>
<main>

  <?php include("include/menu.php"); ?>

  <section class="py-5 bg-light">
    <div class="container text-center">
      <h2 class="mb-4">Categorías</h2>
      <div class="row g-4">

        <!-- Categorías -->
        <div class="col-md-3 col-6">
          <div class="card categoria-card h-100">
            <div class="card-body">
              <a href="productos.php?cat=1" class="text-decoration-none text-dark">
                <h5 class="card-title">Ropa</h5>
              </a>
            </div>
          </div>
        </div>

        <div class="col-md-3 col-6">
          <div class="card categoria-card h-100">
            <div class="card-body">
              <a href="productos.php?cat=2" class="text-decoration-none text-dark">
                <h5 class="card-title">Accesorios</h5>
              </a>
            </div>
          </div>
        </div>

        <div class="col-md-3 col-6">
          <div class="card categoria-card h-100">
            <div class="card-body">
              <a href="productos.php?cat=3" class="text-decoration-none text-dark">
                <h5 class="card-title">Trajes de baño</h5>
              </a>
            </div>
          </div>
        </div>

        <!-- Subcategorías -->
        <div class="col-md-3 col-6">
          <div class="card categoria-card h-100">
            <div class="card-body">
              <a href="productos.php?subcat=10" class="text-decoration-none text-dark">
                <h5 class="card-title">Bikinis</h5>
              </a>
            </div>
          </div>
        </div>

        <div class="col-md-3 col-6">
          <div class="card categoria-card h-100">
            <div class="card-body">
              <a href="productos.php?subcat=1" class="text-decoration-none text-dark">
                <h5 class="card-title">Camisetas</h5>
              </a>
            </div>
          </div>
        </div>

        <div class="col-md-3 col-6">
          <div class="card categoria-card h-100">
            <div class="card-body">
              <a href="productos.php?subcat=7" class="text-decoration-none text-dark">
                <h5 class="card-title">Bolsos</h5>
              </a>
            </div>
          </div>
        </div>

        <div class="col-md-3 col-6">
          <div class="card categoria-card h-100">
            <div class="card-body">
              <a href="productos.php?subcat=8" class="text-decoration-none text-dark">
                <h5 class="card-title">Billeteras</h5>
              </a>
            </div>
          </div>
        </div>

        <div class="col-md-3 col-6">
          <div class="card categoria-card h-100">
            <div class="card-body">
              <a href="productos.php?subcat=9" class="text-decoration-none text-dark">
                <h5 class="card-title">Carteras</h5>
              </a>
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
