<?php 
include("include/conexion.php");

$categoria_id = isset($_GET['cat']) ? intval($_GET['cat']) : null;
$subcategoria_id = isset($_GET['subcat']) ? intval($_GET['subcat']) : null;

$titulo = "Productos";
$sql = "";

if ($categoria_id) {
    $sql = "SELECT * FROM producto WHERE id_categoria = $categoria_id";
    $q = $mysqli->query("SELECT nombre FROM categoria_producto WHERE id_categoria = $categoria_id");
    $titulo = $q->fetch_assoc()['nombre'];
} elseif ($subcategoria_id) {
    $sql = "SELECT * FROM producto WHERE id_subcategoria = $subcategoria_id";
    $q = $mysqli->query("SELECT nombre FROM subcategoria_producto WHERE id_subcategoria = $subcategoria_id");
    $titulo = $q->fetch_assoc()['nombre'];
} else {
    echo "<h3 class='text-center mt-5'>No se especificó ninguna categoría o subcategoría.</h3>";
    exit();
}

$resultado = $mysqli->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo ucfirst($titulo); ?> - Vibra Urbana</title>

 
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  
  <link rel="stylesheet" href="styles/style_categorias.css">
</head>
<body>

<?php include("include/menu.php"); ?>

<div class="container py-5">
  <h2 class="text-center mb-4"><?php echo ucfirst($titulo); ?></h2>

  <?php if ($resultado && $resultado->num_rows > 0) { ?>
    <div class="row">
      <?php while ($producto = $resultado->fetch_assoc()) { ?>
        <div class="col-md-4 mb-4">
          <div class="card h-100 shadow-sm">
            <img src="<?php echo $producto['imagen']; ?>" class="card-img-top" alt="imagen" style="height: 300px; object-fit: cover;">
            <div class="card-body text-center">
              <h5 class="card-title"><?php echo $producto['nombre']; ?></h5>
              <p class="card-text text-muted">₡<?php echo number_format($producto['precio'], 2); ?></p>
              <a href="detalle_producto.php?id=<?php echo $producto['id_producto']; ?>" class="btn btn-outline-primary">Ver más</a>
            </div>
          </div>
        </div>
      <?php } ?>
    </div>
  <?php } else { ?>
    <div class="alert alert-warning text-center">No se encontraron productos en esta categoría.</div>
  <?php } ?>
</div>


<?php include("include/footer.php"); ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

