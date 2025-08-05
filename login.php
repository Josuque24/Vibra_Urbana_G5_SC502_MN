<?php
session_start();
require_once("include/conexion.php");

$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST['usuario'];
    $password = $_POST['password'];

    $stmt = $mysqli->prepare("SELECT id_cliente, contrasenia FROM cliente WHERE usuario = ?");
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 1) {
        $stmt->bind_result($id_cliente, $hash_password);
        $stmt->fetch();

        if (password_verify($password, $hash_password)) {
            $_SESSION['id_cliente'] = $id_cliente;
            $_SESSION['usuario'] = $usuario;
            header("Location: home.php");
            exit();
        } else {
            $mensaje = "Contraseña incorrecta.";
        }
    } else {
        $mensaje = "Usuario no encontrado.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Vida Urbana - Login</title>
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
      <form method="POST" action="login.php" class="p-4">
        <div class="mb-3">
          <label for="usuario" class="form-label">Usuario:</label>
          <input type="text" class="form-control" id="usuario" name="usuario" placeholder="Ingrese su usuario">
        </div>
        
        <div class="mb-3">
          <label for="password" class="form-label">Contraseña:</label>
          <input type="password" class="form-control" id="password" name="password" placeholder="Ingrese su contraseña">
        </div>
        
        <button type="submit" class="btn btn-primary w-100">Iniciar Sesión</button>
        <p class="text-center mt-3">Si no tiene cuenta <a href="register.php">Registrarse aquí.</a></p>
      </form>
    </div>
  </div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
  <script src="script.js"></script>
</body>
</html>
