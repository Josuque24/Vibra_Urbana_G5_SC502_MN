<?php
session_start();
if (!isset($_SESSION['usuario'])) {
  header("Location: ./login.php");
  exit();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Productos - Vibra Urbana</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="styles/style_productos.css">
  <link rel="stylesheet" href="styles/style_modal.css">
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
              <img src="https://cdn.awsli.com.br/800x800/1100/1100536/produto/113537436/3d4612e990.jpg" class="card-img-top img-producto">
              <div class="card-body">
                <h5 class="card-title">Camisa Essentials</h5>
                <p class="card-text">₡16,000</p>
                <button onclick="verMas('Camisa Essentials', 'https://cdn.awsli.com.br/800x800/1100/1100536/produto/113537436/3d4612e990.jpg', '100% algodon.', 16000)">Ver más</button>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="card producto h-100">
              <img src="https://tse1.mm.bing.net/th/id/OIP.YE7ilgCHd2S0EPMPkdPcwAHaJb?r=0&rs=1&pid=ImgDetMain&o=7&rm=3" class="card-img-top img-producto">
              <div class="card-body">
                <h5 class="card-title">Pantaloneta Zayin Niño</h5>
                <p class="card-text">₡14,000</p>
                <button onclick="verMas('Pantaloneta Zayin Niño', 'https://tse1.mm.bing.net/th/id/OIP.YE7ilgCHd2S0EPMPkdPcwAHaJb?r=0&rs=1&pid=ImgDetMain&o=7&rm=3', 'Tela elastica, edición especial.', 14000)">Ver más</button>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="card producto h-100">
              <img src="https://image.made-in-china.com/2f0j00TGFqdeOlZPuR/Swim-Solid-Bikini-Set-Beachwear-2-Pieces-Bathing-Suit.jpg" class="card-img-top img-producto">
              <div class="card-body">
                <h5 class="card-title">Bikini Mujer</h5>
                <p class="card-text">₡12,500</p>
                <button onclick="verMas('bikini', 'https://image.made-in-china.com/2f0j00TGFqdeOlZPuR/Swim-Solid-Bikini-Set-Beachwear-2-Pieces-Bathing-Suit.jpg', 'No transparenta.', 12500)">Ver más</button>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="card producto h-100">
              <img src="https://www.lapolar.cl/dw/image/v2/BCPP_PRD/on/demandware.static/-/Sites-master-catalog/default/dw8ec73934/images/large/25247531.jpg?sw=1200&sh=1200&sm=fit" class="card-img-top img-producto">
              <div class="card-body">
                <h5 class="card-title">Billetera Timberland</h5>
                <p class="card-text">₡21,900</p>
                <button onclick="verMas('Billetera Timberland', 'https://www.lapolar.cl/dw/image/v2/BCPP_PRD/on/demandware.static/-/Sites-master-catalog/default/dw8ec73934/images/large/25247531.jpg?sw=1200&sh=1200&sm=fit', 'Cuero.', 21900)">Ver más</button>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="card producto h-100">
              <img src="https://i.pinimg.com/originals/c1/90/21/c19021877b19f726839760e3f12d7720.jpg" class="card-img-top img-producto">
              <div class="card-body">
                <h5 class="card-title">Bolso de Playa</h5>
                <p class="card-text">₡4,800</p>
                <button onclick="verMas('Bolso de Playa', 'https://i.pinimg.com/originals/c1/90/21/c19021877b19f726839760e3f12d7720.jpg', 'Bolsa tejido crochet.', 4800)">Ver más</button>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="card producto h-100">
              <img src="https://th.bing.com/th/id/OIP.LUCJ-IwsqRxoGeTCa9pZ9gHaHa?r=0&o=7rm=3&rs=1&pid=ImgDetMain&o=7&rm=3" class="card-img-top img-producto">
              <div class="card-body">
                <h5 class="card-title">Short Mujer</h5>
                <p class="card-text">₡6,500</p>
                <button onclick="verMas('Short Mujer', 'https://th.bing.com/th/id/OIP.LUCJ-IwsqRxoGeTCa9pZ9gHaHa?r=0&o=7rm=3&rs=1&pid=ImgDetMain&o=7&rm=3', 'Manta.', 6500)">Ver más</button>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="card producto h-100">
              <img
                src="https://litb-cgis.rightinthebox.com/images/640x640/202306/bps/product/inc/zhlnfn1687426499724.jpg?fmt=webp&v=1"
                class="card-img-top" alt="Bolso de playa">
              <div class="card-body">
                <h5 class="card-title">Bolso de playa</h5>
                <p class="card-text">₡6,500</p>
                <button onclick="verMas('Bolso de playa', 'https://litb-cgis.rightinthebox.com/images/640x640/202306/bps/product/inc/zhlnfn1687426499724.jpg?fmt=webp&v=1', 'Bolso tejido para verano.', 6500)">Ver más</button>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="card producto h-100">
              <img
                src="https://hips.hearstapps.com/hmg-prod/images/camiseta-de-corte-relajado-de-levi-s-17-50-euros-1627560346.png?crop=0.992xw:0.992xh;0.00417xw,0.00417xh&resize=980:*"
                class="card-img-top" alt="Camiseta Oversize">
              <div class="card-body">
                <h5 class="card-title">Camiseta Oversize</h5>
                <p class="card-text">₡12,000</p>
                <button onclick="verMas('Camiseta Urbana', 'https://hips.hearstapps.com/hmg-prod/images/camiseta-de-corte-relajado-de-levi-s-17-50-euros-1627560346.png?crop=0.992xw:0.992xh;0.00417xw,0.00417xh&resize=980:*','Camiseta de algodón oversize unisex.', 12000)">Ver más</button>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="card producto h-100">
              <img src="https://cbu01.alicdn.com/img/ibank/O1CN01MrzNf32LVHXYY5oKQ_!!4016249697-0-cib.jpg"
                class="card-img-top" alt="Traje de Baño">
              <div class="card-body">
                <h5 class="card-title">Traje de Baño</h5>
                <p class="card-text">₡12,500</p>
                <button onclick="verMas('Traje de Baño', 'https://cbu01.alicdn.com/img/ibank/O1CN01MrzNf32LVHXYY5oKQ_!!4016249697-0-cib.jpg', 'Traje de baño blanco dos piezas.', 12500)">Ver más</button>
              </div>
            </div>
          </div>
    </section>
  </main>
  <!-- Modal -->
  <div id="modal" class="modal">
    <div class="modal-content">
      <span class="close" onclick="cerrarModal()">&times;</span>
      <img id="modalImg" src="" style="width:100%; max-height:200px; object-fit:cover;">
      <h2 id="modalNombre"></h2>
      <p id="modalDescripcion"></p>
      <p><strong>Precio: ₡<span id="modalPrecio"></span></strong></p>

      <!-- Selección de talla -->
      <form id="formCarrito" method="POST" action="carrito_agregar.php">
        <input type="hidden" name="id_cliente" value="<?php echo $id_cliente; ?>">
        <input type="hidden" id="nombreProducto" name="nombre">
        <input type="hidden" id="precioProducto" name="precio">
        <label for="talla">Talla:</label>
        <select name="id_talla" id="talla" required>
          <option value="1">S</option>
          <option value="2">M</option>
          <option value="3">L</option>
          <option value="4">XL</option>
          <option value="4">XXL</option>
        </select><br><br>
        <label for="cantidad">Cantidad:</label>
        <input type="number" name="cantidad" id="cantidad" min="1" value="1" required><br><br>
        <button type="submit" class="boton">Agregar al carrito</button>
        </form>
    </div>
  </div>

  <?php include("include/footer.php"); ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    let productoActual = {};

    function verMas(nombre, imagen, descripcion, precio) {
      productoActual = {
        nombre,
        imagen,
        descripcion,
        precio
      };
      document.getElementById("modalNombre").innerText = nombre;
      document.getElementById("modalImg").src = imagen;
      document.getElementById("modalDescripcion").innerText = descripcion;
      document.getElementById("modalPrecio").innerText = precio;
      document.getElementById("nombreProducto").value = nombre; 
      document.getElementById("precioProducto").value = precio;
      document.getElementById("modal").style.display = "flex";
    }

    function cerrarModal() {
      document.getElementById("modal").style.display = "none";
    }

    function agregarCarrito() {
      let talla = document.getElementById("modalTalla").value;
      let cantidad = document.getElementById("modalCantidad").value;

      fetch("carrito_agregar.php", {
          method: "POST",
          headers: {
            "Content-Type": "application/x-www-form-urlencoded"
          },
          body: "nombre=" + productoActual.nombre +
            "&precio=" + productoActual.precio +
            "&talla=" + talla +
            "&cantidad=" + cantidad
        })
        .then(response => response.text())
        .then(data => {
          alert(data);
        });
    }
    
  </script>
</body>
</html>