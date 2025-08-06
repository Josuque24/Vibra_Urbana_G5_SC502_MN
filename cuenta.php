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
  <title>Configuración de Cuenta - Vibra Urbana</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="./styles/style_principal.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="javascript/cuenta.js"></script>
</head>

<body>
  <main>
    <!-- Navbar -->
    <?php include("include/menu.php"); ?>

    <!-- Formulario de configuración -->
    <div class="container my-5">
      <h2 class="mb-4 text-center">Configuración de Cuenta</h2>
      <div id="alerta-exito" class="alert alert-success d-none" role="alert"></div>
      <div id="alerta-mensaje" class="alert alert-danger d-none" role="alert"></div>


      <form class="row g-3" id="form-cuenta">
        <div class="col-md-6">
          <label for="nombre" class="form-label">Nombre</label>
          <input type="text" class="form-control" id="nombre" placeholder="Nombre" required>
        </div>
        <div class="col-md-6">
          <label for="apellido" class="form-label">Apellido</label>
          <input type="text" class="form-control" id="apellido" placeholder="Apellido" required>
        </div>
        <div class="col-md-6">
          <label for="usuario" class="form-label">Usuario</label>
          <input type="text" class="form-control" id="usuario" placeholder="Usuario" required>
        </div>
        <?php if (!empty($mensaje)) : ?>
          <div class="alert alert-danger"><?= $mensaje ?></div>
        <?php endif; ?>
        <div class="col-md-6">
          <label for="contrasenia" class="form-label">Nueva Contraseña</label>
          <input type="password" class="form-control" id="contrasenia" placeholder="Nueva contraseña">
        </div>

        <div class="col-12 text-end">
          <button type="submit" class="btn btn-primary">Guardar cambios</button>
        </div>
      </form>
    </div>
  </main>
  <?php include("include/footer.php"); ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>