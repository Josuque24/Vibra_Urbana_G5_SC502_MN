$(function () {


  function debounce(fn, delay) {
    let t;
    return function (...args) {
      clearTimeout(t);
      t = setTimeout(() => fn.apply(this, args), delay);
    };
  }

  // Habilita/Deshabilita PayPal btn
  function updatePayButtonState() {
    const hasItems = $('.qty-input').length > 0;
    const totalText = $('#cart-total').text().replace(/[^\d]/g, '');
    const totalNum = parseInt(totalText || '0', 10);
    $('#btn-paypal').prop('disabled', !hasItems || totalNum <= 0);
  }

  // Formateo rápido de ₡ 
  function setTotalUI(totalFmt) {
    $('#cart-total').text(totalFmt);
  }

  // Guardar valor previo al enfocar
  $(document).on('focus', '.qty-input', function () {
    $(this).data('prev', $(this).val());
    $(this).removeClass('is-invalid'); // limpiar error visual anterior
  });

  // Cambiar cantidad con DEBOUNCE 
  const debouncedQtyChange = debounce(function () {
    const $input = $(this);
    const $row = $input.closest('tr');
    const id_producto = $row.data('id-producto');
    const id_talla = $row.data('id-talla');
    const cantidad = parseInt($input.val(), 10);

    if (isNaN(cantidad) || cantidad < 1) {
      $input.addClass('is-invalid');
      $input.val($input.data('prev') || 1);
      return;
    }

    $.ajax({
      url: 'carrito_actualizar_cantidad.php',
      type: 'POST',
      dataType: 'json',
      data: { id_producto, id_talla, cantidad },
      success: function (resp) {
        // Quitar error visual, actualizar subtotal y total
        $input.removeClass('is-invalid');
        $row.find('.item-subtotal').text(resp.itemSubtotalFmt);
        setTotalUI(resp.cartTotalFmt);
        // Guardar este valor como válido
        $input.data('prev', cantidad);
        // Refrescar estado del botón PayPal
        updatePayButtonState();
      },
      error: function (xhr) {
        // Marcar input en rojo y revertir
        $input.addClass('is-invalid');
        const prev = $input.data('prev') || 1;
        $input.val(prev);

        const msg = xhr.responseText || 'Error al actualizar la cantidad.';
        alert(msg);
      }
    });
  }, 400);

  // Handler usando debounce
  $(document).on('input', '.qty-input', debouncedQtyChange);

  // Eliminar ítem 
  $(document).on('click', '.btn-eliminar', function () {
    if (!confirm('¿Eliminar este producto del carrito?')) return;

    const $row = $(this).closest('tr');
    const id_producto = $row.data('id-producto');
    const id_talla = $row.data('id-talla');

    $.ajax({
      url: 'carrito_eliminar_item.php',
      type: 'POST',
      dataType: 'json',
      data: { id_producto, id_talla },
      success: function (resp) {
        $row.remove();
        setTotalUI(resp.cartTotalFmt);

        // Si no quedan filas, mostrar mensaje de vacío
        if ($('.qty-input').length === 0) {
          $('table tbody').html('<tr><td colspan="7" class="text-center">Tu carrito está vacío.</td></tr>');
        }

        // Actualiza el estado del botón de PayPal
        updatePayButtonState();
      },
      error: function (xhr) {
        alert(xhr.responseText || 'Error al eliminar el producto.');
      }
    });
  });

  // Estado inicial del botón PayPal 
  updatePayButtonState();
});
