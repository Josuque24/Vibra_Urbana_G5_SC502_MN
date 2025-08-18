<?php
session_start();
require_once("include/conexion.php");

if (!isset($_SESSION['id_cliente'])) {
    header("Location: ./login.php");
    exit();
}

$nombre = $_POST['nombre'];
$correo = $_POST['correo'];
$mensaje = $_POST['mensaje'];

$sql = "INSERT INTO mensajes_contacto (nombre, correo, mensaje) VALUES (?, ?, ?)";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("sss", $nombre, $correo, $mensaje);

if ($stmt->execute()) {
    echo "<script>alert('Gracias por contactarnos. ¡Tu mensaje fue enviado con éxito!'); window.location.href='contacto.php';</script>";
} else {
    echo "<script>alert('Hubo un error al enviar tu mensaje. Intenta nuevamente.'); window.location.href='contacto.php';</script>";
}

$stmt->close();
?>
