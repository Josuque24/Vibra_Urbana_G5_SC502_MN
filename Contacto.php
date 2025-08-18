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
  <title>Vibra Urbana - Contacto</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="styles/style_contacto.css">
</head>

<body>
  <?php include("include/menu.php"); ?>

  <section class="container py-5">
    <h2 class="text-center mb-4">💌 Déjanos tu mensaje</h2>
    <form action="guardar_comentario.php" method="POST">
      <div class="mb-3">
        <label for="nombre" class="form-label">Nombre</label>
        <input type="text" class="form-control" id="nombre" name="nombre" required>
      </div>
      <div class="mb-3">
        <label for="correo" class="form-label">Correo electrónico</label>
        <input type="email" class="form-control" id="correo" name="correo" required>
      </div>
      <div class="mb-3">
        <label for="mensaje" class="form-label">Mensaje</label>
        <textarea class="form-control" id="mensaje" name="mensaje" rows="4" required></textarea>
      </div>
      <button type="submit" class="btn btn-dark">Enviar</button>
    </form>
  </section>

  <footer>
    <p>&copy; 2025 Vibra Urbana. Todos los derechos reservados.</p>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    document.addEventListener("DOMContentLoaded", function () {
      fetch("obtener_datos_usuario.php")
        .then(response => {
          if (!response.ok) {
            throw new Error("No autorizado o error en la petición");
          }
          return response.json();
        })
        .then(data => {
          document.getElementById("nombre").value = data.nombre + " " + data.apellido;
          document.getElementById("correo").value = data.usuario;
        })
        .catch(error => {
          console.error("Error al obtener los datos del cliente:", error);
        });
    });
  </script>
</body>
</html>
