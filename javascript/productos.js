// javascript/productos.js — modal + buscador (X nativa) + "Mostrar más" con paginación

// ===== Utilidades AJAX =====
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

const qsObj = () => Object.fromEntries(new URLSearchParams(location.search).entries());
const updateUrl = (params) => {
  const qs = Object.keys(params).length ? '?' + new URLSearchParams(params) : '';
  history.replaceState(null, '', location.pathname + qs);
};

// ===== Render de cards =====
function cardHTML(p) {
  const img = p.imagen || 'img/no-image.png';
  const precioFmt = Number(p.precio).toLocaleString('es-CR', { minimumFractionDigits: 2 });
  return `
    <div class="col-6 col-md-4 col-lg-3">
      <div class="card h-100 shadow-sm">
        <img src="${img}" class="card-img-top" alt="${p.nombre}">
        <div class="card-body d-flex flex-column">
          <h6 class="card-title mb-1">${p.nombre}</h6>
          <div class="mb-2 fw-bold">₡ ${precioFmt}</div>
          <div class="mt-auto d-grid gap-2">
            <button 
              type="button" 
              class="btn btn-outline-dark btn-ver" 
              data-id="${p.id_producto}"
              data-bs-toggle="modal" 
              data-bs-target="#productoModal">
              Ver
            </button>
            <button 
              type="button" 
              class="btn btn-dark btn-ver" 
              data-id="${p.id_producto}"
              data-bs-toggle="modal" 
              data-bs-target="#productoModal">
              Agregar
            </button>
          </div>
        </div>
      </div>
    </div>`;
}

// ===== Estado de paginación =====
const State = {
  page: 1,
  size: 12,           // ajusta aquí si quieres más por página
  loading: false,
  done: false,
  params: {},         // últimos filtros (cat, subcat, q)
};

function setMoreVisibility(hasMore) {
  const wrap = document.getElementById('more-wrap');
  if (!wrap) return;
  wrap.classList.toggle('d-none', !hasMore);
}

// Render inicial o por búsqueda (reemplaza)
async function reloadProductos(params) {
  State.page = 1;
  State.done = false;
  State.params = { ...params }; // guarda filtros actuales
  await loadPage(State.page, /*append*/ false);
}

// Carga de páginas siguientes (append)
async function loadMore() {
  if (State.loading || State.done) return;
  State.page += 1;
  await loadPage(State.page, /*append*/ true);
}

async function loadPage(page, append) {
  try {
    State.loading = true;
    const grid = document.getElementById('grid-productos');
    const query = new URLSearchParams({ ...State.params, page, size: State.size }).toString();
    const res = await fetchJSON('api/productos_listar.php' + (query ? `?${query}` : ''));
    const html = res.data.map(cardHTML).join('');
    if (append) {
      grid.insertAdjacentHTML('beforeend', html);
    } else {
      grid.innerHTML = html || '<p class="text-muted">No hay productos.</p>';
    }
    // si vino menos que size, ya no hay más
    const hasMore = res.data.length === State.size;
    State.done = !hasMore;
    setMoreVisibility(hasMore);
  } catch (err) {
    console.error('[loadPage] Error:', err);
    alert('No se pudieron cargar los productos.');
  } finally {
    State.loading = false;
  }
}

// ===== Modal =====
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
    console.error('[modal] Error al abrir:', err);
    alert('No se pudo cargar el detalle del producto.');
  }
}

async function addToCart(id, tallaId, cantidad) {
  const form = new FormData();
  form.append('id_producto', id);
  form.append('id_talla', tallaId); // requerido por tu esquema
  form.append('cantidad', cantidad);

  const r = await fetch('carrito_agregar.php', { method: 'POST', body: form, credentials: 'same-origin' });
  if (!r.ok) {
    const txt = await r.text().catch(() => '');
    alert('No se pudo agregar: ' + txt);
    return;
  }
  alert('Producto agregado al carrito');
}

// ===== Buscador =====
function hookSearch() {
  const input     = document.getElementById('busq');
  const btnBuscar = document.getElementById('btn-busq');

  const doSearch = () => {
    const q = (input?.value || '').trim();
    const params = qsObj();
    if (q === '') {
      delete params.q;
      updateUrl(params);
      reloadProductos(params);
      return;
    }
    const newParams = { ...params, q };
    updateUrl(newParams);
    reloadProductos(newParams);
  };

  btnBuscar?.addEventListener('click', doSearch);

  input?.addEventListener('keydown', (e) => {
    if (e.key === 'Enter') {
      e.preventDefault();
      doSearch();
    } else if (e.key === 'Escape') {
      e.preventDefault();
      input.value = '';
      const params = qsObj();
      delete params.q;
      updateUrl(params);
      reloadProductos(params);
      input.focus();
    }
  });

  // X  del <input type="search">
  input?.addEventListener('search', () => {
    if (input.value === '') {
      const params = qsObj();
      delete params.q;
      updateUrl(params);
      reloadProductos(params);
      input.focus();
    }
  });

  // Compatibilidad: si queda vacío y no disparó 'search'
  input?.addEventListener('input', () => {
    if (input.value === '') {
      const params = qsObj();
      delete params.q;
      updateUrl(params);
      reloadProductos(params);
    }
  });
}

// ===== Listeners globales =====
document.addEventListener('DOMContentLoaded', () => {
  // Carga inicial respetando filtros URL (?cat, ?subcat, ?q)
  const params = qsObj();
  reloadProductos(params);

  // Buscar
  hookSearch();

  // Abrir modal y agregar desde modal
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
    if (e.target.id === 'btn-mas') {
      loadMore();
    }
  });
});
