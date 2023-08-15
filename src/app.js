// Función para actualizar el subtotal dentro del modal
function updatePrice(modal) {
  var select = modal.querySelector('.tamaño');
  var selectedOption = select.options[select.selectedIndex];
  var precio = parseFloat(selectedOption.getAttribute('data-precio'));
  var cantidad = parseFloat(modal.querySelector('.cantidad').value);
  var subtotalElement = modal.querySelector('.subtotal');

  if (!isNaN(precio) && !isNaN(cantidad)) {
    var subtotal = precio * cantidad;
    subtotalElement.textContent = subtotal.toFixed(2);
  } else {
    subtotalElement.textContent = "0";
  }
}
// Listener para el evento shown.bs.modal
document.addEventListener('shown.bs.modal', function(event) {
  var modal = event.target; // Obtener el modal que se ha mostrado completamente
  var modalId = modal.getAttribute('id'); // Obtener el ID del modal

  // Restablecer los valores del modal a los iniciales
  resetValues(modal);

  // Agregar el evento change al select del modal
  var select = modal.querySelector('.tamaño');
  select.addEventListener('change', function() {
    updatePrice(modal); // Llamar a la función para actualizar el subtotal
  });

  // Agregar el evento change al input de cantidad del modal
  var cantidadInput = modal.querySelector('.cantidad');
  cantidadInput.addEventListener('change', function() {
    updatePrice(modal); // Llamar a la función para actualizar el subtotal
  });
});

// Función para restablecer los valores del modal a los iniciales
function resetValues(modal) {
  // Restablecer el select a su opción inicial
  var select = modal.querySelector('.tamaño');
  select.selectedIndex = 0;

  // Restablecer el input de cantidad a su valor inicial
  var cantidadInput = modal.querySelector('.cantidad');
  cantidadInput.value = 0;

  // Restablecer el contenido del subtotal a "0" (o cualquier otro valor predeterminado)
  var subtotalElement = modal.querySelector('.subtotal');
  subtotalElement.textContent = "0";
}

// Función para actualizar el tamaño y precio antes de enviar el formulario
function actualizarCampos(id) {
  const modal = document.querySelector(`#modal${id}`);
  const selectTamaño = modal.querySelector('.tamaño');
  const selectedOption = selectTamaño.options[selectTamaño.selectedIndex];
  const precio = selectedOption.getAttribute('data-precio');
  const inputPrecio = modal.querySelector('input[name="precio"]');
  const inputTamaño = modal.querySelector('input[name="tamaño"]');
  inputPrecio.value = precio;
  inputTamaño.value = selectedOption.value;
}

// Función para actualizar el total del carrito

document.addEventListener('shown.bs.modal', function (event) {
  var modal = event.target; // Obtener el modal que se ha mostrado completamente
  var modalId = modal.getAttribute('id'); // Obtener el ID del modal

  // Restablecer los valores del modal a los iniciales
  resetValues(modal);

  // Agregar el evento change al select del modal
  var select = modal.querySelector('.tamaño');
  select.addEventListener('change', function () {
    updatePrice(modal); // Llamar a la función para actualizar el subtotal
    actualizarTotal(); // Llamar a la función para actualizar el total
  });

  // Agregar el evento change al input de cantidad del modal
  var cantidadInput = modal.querySelector('.cantidad');
  cantidadInput.addEventListener('change', function () {
    updatePrice(modal); // Llamar a la función para actualizar el subtotal
    actualizarTotal(); // Llamar a la función para actualizar el total
  });
});