function agregarCarrito() {
  let talla = document.getElementById("modalTalla").value;
  let cantidad = document.getElementById("modalCantidad").value;

  fetch("carrito_agregar.php", {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
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