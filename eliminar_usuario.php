<?php
session_start();
require_once("include/conexion.php");

if (!isset($_SESSION['id_cliente'])) {
    http_response_code(403);
    exit();
}

$id = $_SESSION['id_cliente'];

// Eliminar usuario
$stmt = $mysqli->prepare("DELETE FROM cliente WHERE id_cliente = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    // Cerrar sesión
    session_unset();
    session_destroy();
    echo "ok";
} else {
    http_response_code(500);
    echo "Error al eliminar la cuenta.";
}
