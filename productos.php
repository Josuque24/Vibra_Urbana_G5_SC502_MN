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
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="styles/style_productos.css">
</head>

<body>
  <main>
    <?php include("include/menu.php"); ?>

    <section class="py-5">
      <div class="container">
        <h2 class="mb-4 text-center">Nuestros Productos</h2>

        <div class="d-flex justify-content-center">
          <div class="input-group mb-4" style="max-width: 420px;">
            <input
              id="busq"
              type="search"
              class="form-control"
              placeholder="Buscar producto..."
              value="<?php echo isset($_GET['q']) ? htmlspecialchars($_GET['q'], ENT_QUOTES, 'UTF-8') : ''; ?>"
              autocapitalize="off"
              autocomplete="off"
              spellcheck="false" />
            <button id="btn-busq" class="btn btn-dark" type="button">Buscar</button>
          </div>
        </div>


        <div id="grid-productos" class="row g-3"></div>
        <div id="more-wrap" class="text-center mt-4 d-none">
          <button id="btn-mas" class="btn btn-outline-dark" type="button">Mostrar más</button>
        </div>
      </div>
    </section>
  </main>

  <!-- Modal Detalle -->
  <div class="modal fade" id="productoModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 id="md-nombre" class="modal-title"></h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
          <div class="d-flex flex-column flex-md-row gap-3">
            <img id="md-img" class="img-fluid rounded" style="max-width: 280px;" alt="Producto">
            <div class="flex-grow-1">
              <p id="md-desc" class="mb-2"></p>
              <h4 id="md-precio" class="mb-3"></h4>

              <div class="mb-3" id="md-tallas"><!-- select dinámico --></div>

              <div class="input-group" style="max-width: 180px;">
                <span class="input-group-text">Cant.</span>
                <input id="md-cant" type="number" min="1" value="1" class="form-control">
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button id="md-add" class="btn btn-dark" type="button">Agregar al carrito</button>
        </div>
      </div>
    </div>
  </div>

  <?php include("include/footer.php"); ?>

  <!-- Bootstrap bundle (con Popper). Cárgalo ANTES de tu JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-4CMFba5+JXkH8h6jvQ2qXj0dP5C9V2i2qTqk5xv5Xg8qM1E8A2T+6Zp6o2f2bQ7H"
    crossorigin="anonymous"></script>

  <!-- Fallback si el CDN falla -->
  <script>
    (function ensureBootstrap() {
      if (!window.bootstrap || !window.bootstrap.Modal) {
        console.warn('[bootstrap] No cargó desde CDN, intentando fallback…');
        var s = document.createElement('script');
        s.src = 'https://unpkg.com/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js';
        s.onload = () => console.log('[bootstrap] cargado por fallback');
        s.onerror = () => console.error('[bootstrap] no se pudo cargar (CDN y fallback fallaron).');
        document.head.appendChild(s);
      } else {
        console.log('[bootstrap] OK');
      }
    })();
  </script>

  <!-- Logs de eventos del modal para ver si llega a dispararse -->
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const modalEl = document.getElementById('productoModal');
      if (!modalEl) {
        console.error('[modal] No existe #productoModal');
        return;
      }

      ['show.bs.modal', 'shown.bs.modal', 'hide.bs.modal', 'hidden.bs.modal'].forEach(evt => {
        modalEl.addEventListener(evt, () => console.log('[modal event]', evt));
      });

      // Botón de prueba (oculto) por si quieres abrir el modal a mano
      const testBtn = document.createElement('button');
      testBtn.type = 'button';
      testBtn.textContent = 'TEST MODAL';
      testBtn.style.cssText = 'position:fixed;bottom:10px;right:10px;opacity:0;pointer-events:none;';
      testBtn.addEventListener('click', () => {
        try {
          const m = new bootstrap.Modal(modalEl);
          m.show();
        } catch (e) {
          console.error('[modal] Error al intentar abrir manualmente:', e);
        }
      });
      document.body.appendChild(testBtn);
      console.log('[debug] Bootstrap?', !!window.bootstrap, 'Modal API?', !!(window.bootstrap && window.bootstrap.Modal));
    });
  </script>

  <!-- Tu JS de productos, al final -->
  <script src="javascript/productos.js?v=fix-modal-1"></script>
</body>

</html>