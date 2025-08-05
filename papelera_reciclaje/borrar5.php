<?php

session_start();

// Si NO está logueado, redirige al login
if (!isset($_SESSION['usuario'])) {
    header("Location: /usuarios/login.php");
    exit();
}

// Si está logueado, imprime el nombre de usuario
echo "Bienvenido, " . htmlspecialchars($_SESSION['usuario']);

require_once("include/conexion.php"); // ajusta si está en otra ruta

$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = trim($_POST["usuario"]);
    $clave = trim($_POST["clave"]);
    
    if ($usuario !== "" && $clave !== "") {
        $clave_hash = password_hash($clave, PASSWORD_DEFAULT);

        $stmt = $mysqli->prepare("INSERT INTO cliente (usuario, contrasenia) VALUES (?, ?)");
        $stmt->bind_param("ss", $usuario, $clave_hash);

        if ($stmt->execute()) {
            $mensaje = "<div class='alert alert-success'>Usuario registrado correctamente.</div>";
        } else {
            $mensaje = "<div class='alert alert-danger'>Error al registrar el usuario.</div>";
        }
    } else {
        $mensaje = "<div class='alert alert-warning'>Complete todos los campos.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Insertar Usuario</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
  <h2>Insertar Usuario a la Base de Datos</h2>
  <?= $mensaje ?>
  <form method="POST">
    <div class="mb-3">
      <label for="usuario" class="form-label">Usuario:</label>
      <input type="text" name="usuario" class="form-control" required>
    </div>
    <div class="mb-3">
      <label for="clave" class="form-label">Contraseña:</label>
      <input type="password" name="clave" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-primary">Registrar Usuario</button>
  </form>
</body>
</html>
