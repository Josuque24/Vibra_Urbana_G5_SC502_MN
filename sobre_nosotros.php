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
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
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
        <h2 class="mb-4">Seleccione</h2>

        <div class="row g-4 justify-content-center">
          <!-- Card: Nuestra historia -->
          <div class="col-md-4 col-sm-6 col-12">
            <div class="card categoria-card h-100 position-relative">
              <div class="card-body">
                <h5 class="card-title mb-0">Nuestra historia</h5>
                <a href="nuestra_historia.html" class="stretched-link" aria-label="Ir a Nuestra historia"></a>
              </div>
            </div>
          </div>

          <!-- Card: Compañía -->
          <div class="col-md-4 col-sm-6 col-12">
            <div class="card categoria-card h-100 position-relative">
              <div class="card-body">
                <h5 class="card-title mb-0">Compañía</h5>
                <a href="compania.html" class="stretched-link" aria-label="Ir a Compañía"></a>
              </div>
            </div>
          </div>
        </div>

        <div class="row g-4 justify-content-center mt-4">
          <!-- Card: Sobre nosotros -->
          <div class="col-md-4 col-sm-6 col-12">
            <div class="card categoria-card h-100 position-relative">
              <div class="card-body">
                <h5 class="card-title mb-0">Sobre nosotros</h5>
                <a href="sobre_nosotros.html" class="stretched-link" aria-label="Ir a Sobre nosotros"></a>
              </div>
            </div>
          </div>

          <!-- Card: Volver -->
          <div class="col-md-4 col-sm-6 col-12">
            <div class="card categoria-card h-100 position-relative">
              <div class="card-body">
                <h5 class="card-title mb-0">Volver</h5>
                <a href="home.php" class="stretched-link" aria-label="Volver al inicio"></a>
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
