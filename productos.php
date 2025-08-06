<?php 
session_start();
if (!isset($_SESSION['usuario'] )) {
    header("Location: ./login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Productos - Vibra Urbana</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="styles/style_productos.css">
</head>
<body>
<main>
  <!-- Navbar -->
<?php include("include/menu.php"); ?>

<!-- Productos -->
<section class="py-5">
  <div class="container text-center">
    <h2 class="mb-4">Nuestros Productos</h2>
    <div class="row g-4">
      <div class="col-md-4">
        <div class="card producto h-100">
          <img src="https://cdn.awsli.com.br/800x800/1100/1100536/produto/113537436/3d4612e990.jpg" class="card-img-top img-producto" >
          <div class="card-body">
            <h5 class="card-title">Camisa Essentials</h5>
            <p class="card-text">₡16,000</p>
            <a href="#" class="btn btn-outline-dark">Ver más</a>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card producto h-100">
          <img src="https://tse1.mm.bing.net/th/id/OIP.YE7ilgCHd2S0EPMPkdPcwAHaJb?r=0&rs=1&pid=ImgDetMain&o=7&rm=3" class="card-img-top img-producto" >
          <div class="card-body">
            <h5 class="card-title">Pantaloneta Zayin Niño</h5>
            <p class="card-text">₡14,000</p>
            <a href="#" class="btn btn-outline-dark">Ver más</a>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card producto h-100">
          <img src="https://image.made-in-china.com/2f0j00TGFqdeOlZPuR/Swim-Solid-Bikini-Set-Beachwear-2-Pieces-Bathing-Suit.jpg" class="card-img-top img-producto" >
          <div class="card-body">
            <h5 class="card-title">Bikini Mujer</h5>
            <p class="card-text">₡12,500</p>
            <a href="#" class="btn btn-outline-dark">Ver más</a>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card producto h-100">
          <img src="https://www.lapolar.cl/dw/image/v2/BCPP_PRD/on/demandware.static/-/Sites-master-catalog/default/dw8ec73934/images/large/25247531.jpg?sw=1200&sh=1200&sm=fit" class="card-img-top img-producto" >
          <div class="card-body">
            <h5 class="card-title">Billetera Timberland</h5>
            <p class="card-text">₡21,900</p>
            <a href="#" class="btn btn-outline-dark">Ver más</a>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card producto h-100">
          <img src="https://i.pinimg.com/originals/c1/90/21/c19021877b19f726839760e3f12d7720.jpg" class="card-img-top img-producto" >
          <div class="card-body">
            <h5 class="card-title">Bolso de Playa</h5>
            <p class="card-text">₡4,800</p>
            <a href="#" class="btn btn-outline-dark">Ver más</a>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card producto h-100">
          <img src="https://th.bing.com/th/id/OIP.LUCJ-IwsqRxoGeTCa9pZ9gHaHa?r=0&o=7rm=3&rs=1&pid=ImgDetMain&o=7&rm=3" class="card-img-top img-producto" >
          <div class="card-body">
            <h5 class="card-title">Short Mujer</h5>
            <p class="card-text">₡6,500</p>
            <a href="#" class="btn btn-outline-dark">Ver más</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
</main>

<?php include("include/footer.php"); ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>