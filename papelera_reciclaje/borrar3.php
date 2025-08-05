<?php
require_once("../include/conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST['usuario'];
    $clave = password_hash($_POST['clave'], PASSWORD_DEFAULT);

    $stmt = $mysqli->prepare("INSERT INTO usuarios (usuario, clave) VALUES (?, ?)");
    $stmt->bind_param("ss", $usuario, $clave);

    if ($stmt->execute()) {
        header("Location: login.php?registro=exitoso");
        exit();
    } else {
        echo "Error al registrar";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro - Vibra Urbana</title>
    <link rel="stylesheet" href="../assets/bootstrap.min.css">
</head>
<body class="container mt-5">
    <h2>Registro de Usuario</h2>
    <form method="post">
        <div class="mb-3">
            <label for="usuario" class="form-label">Usuario</label>
            <input type="text" name="usuario" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="clave" class="form-label">Contraseña</label>
            <input type="password" name="clave" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Registrar</button>
        <a href="login.php" class="btn btn-link">¿Ya tienes cuenta?</a>
    </form>
</body>
</html>
