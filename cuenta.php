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
  <title>Configuración de Cuenta - Vibra Urbana</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="./styles/style_principal.css">
</head>
<body>

  <!-- Navbar -->
  <?php include("include/menu.php"); ?>

  <!-- Formulario de configuración -->
  <div class="container my-5">
    <h2 class="mb-4 text-center">Configuración de Cuenta</h2>

    <form class="row g-3">
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
      <div class="col-md-6">
        <label for="contrasenia" class="form-label">Nueva Contraseña</label>
        <input type="password" class="form-control" id="contrasenia" placeholder="Nueva contraseña">
      </div>

      <div class="col-12 text-end">
        <button type="submit" class="btn btn-primary">Guardar cambios</button>
      </div>
    </form>
  </div>

  <footer>
    <p class="mb-0">&copy; 2025 Vibra Urbana. Todos los derechos reservados.</p>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
