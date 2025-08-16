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
      <h2 class="mb-4">Seleccione</h2>

      <div class="row g-4 justify-content-center">
        <!-- Card: Contáctenos -->
        <div class="col-md-4 col-sm-6 col-12">
          <div class="card categoria-card h-100 position-relative">
            <div class="card-body">
              <h5 class="card-title mb-0">Contáctenos</h5>
              <a href="Contacto.php" class="stretched-link" aria-label="Ir a Contáctenos"></a>
            </div>
          </div>
        </div>

        <!-- Card: Preguntas frecuentes -->
        <div class="col-md-4 col-sm-6 col-12">
          <div class="card categoria-card h-100 position-relative">
            <div class="card-body">
              <h5 class="card-title mb-0">Preguntas frecuentes</h5>
              <a href="FaQ.php" class="stretched-link" aria-label="Ir a Preguntas frecuentes"></a>
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
