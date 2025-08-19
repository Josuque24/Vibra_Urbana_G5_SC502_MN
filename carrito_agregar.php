<?php
session_start();
require_once("include/conexion.php");

if (!isset($_SESSION['usuario']) || !isset($_SESSION['id_cliente'])) {
    header("Location: ./login.php");
    exit();
}

$id_cliente = $_SESSION['id_cliente'];
$nombre = $_POST['nombre'] ?? '';
$precio = $_POST['precio'] ?? 0;
$id_talla = $_POST['id_talla'] ?? 0;
$cantidad = $_POST['cantidad'] ?? 1;

if (empty($nombre) || $precio <= 0 || $id_talla <= 0 || $cantidad <= 0) {
    echo "Error: Datos incompletos.";
    exit();
}

// Buscar el carrito del cliente
$stmt = $mysqli->prepare("SELECT id_carrito FROM carrito WHERE id_cliente = ?");
$stmt->bind_param("i", $id_cliente);
$stmt->execute();
$stmt->bind_result($id_carrito);
if (!$stmt->fetch()) {
    $stmt->close();
    // Crear un nuevo carrito
    $ins = $mysqli->prepare("INSERT INTO carrito (id_cliente) VALUES (?)");
    $ins->bind_param("i", $id_cliente);
    $ins->execute();
    $id_carrito = $ins->insert_id;
    $ins->close();
} else {
    $stmt->close();
}

// Busca el producto en la base de datos 
$stmt = $mysqli->prepare("SELECT id_producto FROM producto WHERE nombre = ? AND precio = ?");
$stmt->bind_param("sd", $nombre, $precio);
$stmt->execute();
$stmt->bind_result($id_producto);
if (!$stmt->fetch()) {
    
    $stmt->close();
    $ins = $mysqli->prepare("INSERT INTO producto (nombre, precio, imagen) VALUES (?, ?, ?)");
    $imagen = ''; 
    $ins->bind_param("sds", $nombre, $precio, $imagen);
    $ins->execute();
    $id_producto = $ins->insert_id;
    $ins->close();
} else {
    $stmt->close();
}

// Verifica si el producto ya esta en el carrito
$stmt = $mysqli->prepare("SELECT cantidad FROM carrito_detalle WHERE id_carrito = ? AND id_producto = ? AND id_talla = ?");
$stmt->bind_param("iii", $id_carrito, $id_producto, $id_talla);
$stmt->execute();
$stmt->bind_result($cantidad_existente);
if ($stmt->fetch()) {
    // Si ya esta en el carrito, actualiza la cantidad
    $stmt->close();
    $nueva_cantidad = $cantidad_existente + $cantidad;
    $upd = $mysqli->prepare("UPDATE carrito_detalle SET cantidad = ? WHERE id_carrito = ? AND id_producto = ? AND id_talla = ?");
    $upd->bind_param("iiii", $nueva_cantidad, $id_carrito, $id_producto, $id_talla);
    $upd->execute();
    $upd->close();
} else {
    $stmt->close();
    $ins = $mysqli->prepare("INSERT INTO carrito_detalle (id_carrito, id_producto, id_talla, cantidad) VALUES (?, ?, ?, ?)");
    $ins->bind_param("iiii", $id_carrito, $id_producto, $id_talla, $cantidad);
    $ins->execute();
    $ins->close();
}


echo "Producto agregado al carrito correctamente.";
header("Location: carrito.php"); 
exit();
?>
