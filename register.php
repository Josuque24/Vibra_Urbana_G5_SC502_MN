<?php
require_once("include/conexion.php");

$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $usuario = $_POST['usuario'];
    $clave_plana = $_POST['contrasenia'];
    $clave_segura = password_hash($clave_plana, PASSWORD_DEFAULT);

    $stmt = $mysqli->prepare("INSERT INTO cliente (nombre, apellido, usuario, contrasenia) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $nombre, $apellido, $usuario, $clave_segura);

    try {
        $stmt->execute();
        header("Location: login.php?registro=exitoso");
        exit();
    } catch (mysqli_sql_exception $e) {
        if ($e->getCode() === 1062) {
            $mensaje = "El usuario ya existe. Intenta con otro.";
        } else {
            $mensaje = "Error al registrar el cliente.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Registro - Vibra Urbana</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="./styles/styles_login.css">
</head>
<body>
  <div class="container-fluid vh-100 d-flex align-items-center justify-content-center">
    <div class="login-box">
      <div class="header">
        <h1>VIBRA URBANA</h1>
        <img src="./assets/img/logo_vidaurbana.jpg" alt="Logo Vibra Urbana" class="img-fluid mb-3 d-block mx-auto" style="max-width: 150px;">
        <p>Siempre buena vibra, siempre vibra urbana</p>
      </div>
      <form method="POST" action="register.php" class="p-4">
        <?php if (!empty($mensaje)) : ?>
          <div class="alert alert-danger"><?= $mensaje ?></div>
        <?php endif; ?>
        <div class="mb-3">
          <label for="nombre" class="form-label">Nombre:</label>
          <input type="text" class="form-control" id="nombre" name="nombre" required>
        </div>
        <div class="mb-3">
          <label for="apellido" class="form-label">Apellido:</label>
          <input type="text" class="form-control" id="apellido" name="apellido" required>
        </div>
        <div class="mb-3">
          <label for="usuario" class="form-label">Usuario:</label>
          <input type="email" class="form-control" id="usuario" name="usuario" 
           placeholder="tu@email.com" required>
           <div class="invalid-feedback">Ingresa un correo válido.</div>
        </div>
        <div class="mb-3">
          <label for="contrasenia" class="form-label">Contraseña:</label>
          <input type="password" class="form-control" id="contrasenia" name="contrasenia" required>
        </div>
        <button type="submit" class="btn btn-success w-100">Registrarse</button>
        <p class="text-center mt-3">¿Ya tienes cuenta? <a href="login.php">Inicia sesión aquí</a>.</p>
      </form>
    </div>
  </div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
