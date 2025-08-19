// javascript/home.js — 3 productos aleatorios en Home con modal y carrito

async function fetchJSON(url, opts = {}) {
  const r = await fetch(url, { credentials: 'same-origin', ...opts });
  if (!r.ok) {
    const txt = await r.text().catch(() => '');
    throw new Error(`HTTP ${r.status} - ${url}\n${txt}`);
  }
  const ct = r.headers.get('content-type') || '';
  if (!ct.includes('application/json')) {
    const txt = await r.text().catch(() => '');
    throw new Error(`Respuesta no JSON en ${url}\n${txt}`);
  }
  return r.json();
}

function cardHTML(p) {
  const img = p.imagen || 'img/no-image.png';
  const precioFmt = Number(p.precio).toLocaleString('es-CR', { minimumFractionDigits: 2 });
  return `
    <div class="col-6 col-lg-4">
      <div class="card h-100 shadow-sm">
        <img src="${img}" class="card-img-top" alt="${p.nombre}">
        <div class="card-body d-flex flex-column">
          <h6 class="card-title mb-1">${p.nombre}</h6>
          <div class="mb-2 fw-bold">₡ ${precioFmt}</div>
          <div class="mt-auto d-grid gap-2">        
            <button 
              type="button" 
              class="btn btn-dark btn-ver" 
              data-id="${p.id_producto}"
              data-bs-toggle="modal" 
              data-bs-target="#productoModal">
              Ver más
            </button>
          </div>
        </div>
      </div>
    </div>`;
}

async function loadHomeProductos() {
  const res = await fetchJSON('api/productos_aleatorios.php');
  const grid = document.querySelector('#home-productos');
  grid.innerHTML = res.data.map(cardHTML).join('') || '<p class="text-muted">No hay productos.</p>';
}

// ======= Modal & Carrito (mismo patrón que productos.js) =======
async function fillModal(id) {
  const res = await fetchJSON('api/producto_detalle.php?id=' + encodeURIComponent(id));
  const p = res.data;

  document.querySelector('#md-nombre').textContent = p.nombre || '';
  document.querySelector('#md-desc').textContent   = p.descripcion || '';
  document.querySelector('#md-precio').textContent = '₡ ' + Number(p.precio).toLocaleString('es-CR', { minimumFractionDigits: 2 });
  document.querySelector('#md-img').src            = p.imagen || 'img/no-image.png';

  const tallasDiv = document.querySelector('#md-tallas');
  if (res.tallas && res.tallas.length) {
    tallasDiv.innerHTML = `
      <label class="form-label">Talla</label>
      <select id="md-talla" class="form-select">
        ${res.tallas.map(t => `<option value="${t.id_talla}">${t.talla}</option>`).join('')}
      </select>`;
  } else {
    tallasDiv.innerHTML = '';
  }

  document.querySelector('#md-add').dataset.id = p.id_producto;
}

function openModalFallback() {
  const modalEl = document.getElementById('productoModal');
  if (!modalEl) return;
  modalEl.classList.add('show');
  modalEl.style.display = 'block';
  modalEl.removeAttribute('aria-hidden');
  modalEl.setAttribute('aria-modal', 'true');
  document.body.classList.add('modal-open');
  const bd = document.createElement('div');
  bd.className = 'modal-backdrop fade show';
  document.body.appendChild(bd);
}

async function onOpenClick(btn) {
  try {
    const id = btn.dataset.id;
    if (!id) { alert('Sin ID de producto'); return; }
    await fillModal(id);
    const modalEl = document.getElementById('productoModal');
    if (window.bootstrap && window.bootstrap.Modal) {
      const m = bootstrap.Modal.getOrCreateInstance(modalEl);
      m.show();
    } else {
      console.warn('[modal] Bootstrap no disponible, usando fallback.');
      openModalFallback();
    }
  } catch (err) {
    console.error('[home modal] Error al abrir:', err);
    alert('No se pudo cargar el detalle del producto.');
  }
}

async function addToCart(id, tallaId, cantidad) {
  const form = new FormData();
  form.append('id_producto', id);
  form.append('id_talla', tallaId);
  form.append('cantidad', cantidad);

  const r = await fetch('carrito_agregar.php', { method: 'POST', body: form, credentials: 'same-origin' });
  if (!r.ok) {
    const txt = await r.text().catch(() => '');
    alert('No se pudo agregar: ' + txt);
    return;
  }
  alert('Producto agregado al carrito');
}

document.addEventListener('DOMContentLoaded', () => {
  // Cargar los 3 aleatorios
  loadHomeProductos();

  // Delegación de clicks para abrir modal o agregar desde el modal
  document.addEventListener('click', (e) => {
    const openBtn = e.target.closest('.btn-ver');
    if (openBtn) {
      e.preventDefault();
      onOpenClick(openBtn);
      return;
    }

    if (e.target.id === 'md-add') {
      const id = e.target.dataset.id;
      const tallaEl = document.querySelector('#md-talla');
      const tallaId = tallaEl ? parseInt(tallaEl.value, 10) : 0;
      const cant    = parseInt(document.querySelector('#md-cant').value, 10) || 1;
      if (!id || !tallaId) { alert('Selecciona una talla válida.'); return; }
      addToCart(id, tallaId, cant);
    }
  });
});
