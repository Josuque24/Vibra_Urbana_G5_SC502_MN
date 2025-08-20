<?php
session_start();
if (!isset($_SESSION['usuario'])) {
  header("Location: ./login.php");
  exit();
}

$totalPaypal = $_SESSION['paypal_total_paid'] ?? null;
unset($_SESSION['paypal_total_paid']);
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <title>Gracias por tu compra</title>
  <link rel="stylesheet" href="./styles/style_principal.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
  <?php include("include/menu.php"); ?>
  <main class="container py-5 text-center">
    <h2 class="mb-3 text-success">¡Pago completado con éxito! 🎉</h2>

    <?php if ($totalPaypal): ?>
      <p class="lead">
        Gracias por tu compra en <strong>Vibra Urbana</strong> por un total de
        <strong><?= htmlspecialchars($totalPaypal) ?></strong>.
      </p>
      <p>Nuestros colaboradores se pondrán en contacto por email contigo para definir la entrega.</p>
    <?php else: ?>
      <p class="lead">
        Gracias por tu compra en <strong>Vibra Urbana</strong>.
      </p>
    <?php endif; ?>

    <a href="home.php" class="btn custom-btn-naranja mt-3">Volver al inicio</a>
  </main>

  <?php include("include/footer.php"); ?>
</body>

</html>