<?php 
session_start();
if (!isset($_SESSION['usuario'])) { header("Location: ./login.php"); exit(); }
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8"><title>Gracias por tu compra</title>
  <link rel="stylesheet" href="./styles/style_principal.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <?php include("include/menu.php"); ?>
  <main class="container py-5 text-center">
    <h2 class="mb-3 text-success">¡Pago completado con éxito! 🎉</h2>
    <p>Nuestros colaboradores se <strong>comunicaran</strong> contigo por correo para coordinar la entrega.</p>
    <p>Gracias por tu compra en <strong>Vibra Urbana</strong>.</p>
    <a href="home.php" class="btn custom-btn-naranja mt-3">Volver al inicio</a>
  </main>
  <?php include("include/footer.php"); ?>
</body>
</html>
