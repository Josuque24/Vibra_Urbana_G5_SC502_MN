<?php
session_start();
require_once("include/conexion.php");

if (!isset($_SESSION['id_cliente'])) {
    http_response_code(403);
    exit();
}

$id = $_SESSION['id_cliente'];
$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$usuario = $_POST['usuario'];
$contrasenia = $_POST['contrasenia'];

try {
    if (!empty($contrasenia)) {
        $hash = password_hash($contrasenia, PASSWORD_DEFAULT);
        $sql = "UPDATE cliente SET nombre = ?, apellido = ?, usuario = ?, contrasenia = ? WHERE id_cliente = ?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("ssssi", $nombre, $apellido, $usuario, $hash, $id);
    } else {
        $sql = "UPDATE cliente SET nombre = ?, apellido = ?, usuario = ? WHERE id_cliente = ?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("sssi", $nombre, $apellido, $usuario, $id);
    }

    $stmt->execute();
    echo "ok";

} catch (mysqli_sql_exception $e) {
    if ($e->getCode() == 1062) {
        // Error de duplicado
        http_response_code(409); // Conflicto
        echo "El nombre de usuario ya está en uso.";
    } else {
        http_response_code(500);
        echo "Error al actualizar: " . $e->getMessage();
    }
}
