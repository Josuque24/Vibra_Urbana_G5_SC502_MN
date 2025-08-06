<?php
session_start();
require_once("include/conexion.php");

if (!isset($_SESSION['id_cliente'])) {
    http_response_code(403);
    exit();
}

$id = $_SESSION['id_cliente'];

$sql = "SELECT nombre, apellido, usuario FROM cliente WHERE id_cliente = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$resultado = $stmt->get_result();
$usuario = $resultado->fetch_assoc();

echo json_encode($usuario);
