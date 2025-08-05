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
          <div class="col-md-4 col-sm-6 col-12">
            <div class="card categoria-card h-100">
              <div class="card-body">
                <a class="nav-link" href="nuestra_historia.html">
                  <h5 class="card-title">Nuesta historia</h5>
                </a>
              </div>
            </div>
          </div>
          <div class="col-md-4 col-sm-6 col-12">
            <div class="card categoria-card h-100">
              <div class="card-body">
                <a class="nav-link" href="compania.html">
                  <h5 class="card-title">Compañia</h5>
                </a>
              </div>
            </div>
          </div>
        </div>


        <div class="row g-4 justify-content-center mt-4">
          <div class="col-md-4 col-sm-6 col-12">
            <div class="card categoria-card h-100">
              <div class="card-body">
                <a class="nav-link" href="sobre_nosotros.html">
                  <h5 class="card-title">Sobre nosotros</h5>
                </a>
              </div>
            </div>
          </div>
          <div class="col-md-4 col-sm-6 col-12">
            <div class="card categoria-card h-100">
              <div class="card-body">
                <a class="nav-link" href="home.php">
                  <h5 class="card-title">volver</h5>
                </a>
              </div>
            </div>
          </div>
        </div>       
      </div>
    </section>

  </main>

  <!-- Footer -->
  <footer class="bg-dark text-white text-center py-3">
    <p class="mb-0">&copy; 2025 Vibra Urbana. Todos los derechos reservados.</p>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>