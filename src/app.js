
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
// Agregar el evento change al select del modal
var select = modal.querySelector('.tamaño');
var cantidadInput = modal.querySelector('.cantidad');
var botonAgregar = modal.querySelector('#agregar'); // Selecciona el botón de agregar

select.addEventListener('change', function() {
  updatePrice(modal); // Actualizar el subtotal al cambiar el tamaño seleccionado
  
  // Habilitar o deshabilitar el botón de agregar según las condiciones
  if (select.value !== "" && cantidadInput.value > 0) {
    botonAgregar.removeAttribute('disabled');
  } else {
    botonAgregar.setAttribute('disabled', 'true');
  }
});
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

document.addEventListener('DOMContentLoaded', function() {
  const selects = document.querySelectorAll('.tamaño');
  selects.forEach(select => {
      const addButton = select.closest('.modal-content').querySelector('#agregar');
      const cantidadInput = select.closest('.modal-content').querySelector('.cantidad');
      
      select.addEventListener('change', function() {
          if (this.value === '') {
              addButton.disabled = true;
              cantidadInput.disabled = true;
          } else {
              addButton.disabled = false;
              cantidadInput.disabled = false;
          }
      });
      
      addButton.addEventListener('click', function() {
          const modal = this.closest('.modal-content');
          const selectedOption = modal.querySelector('.tamaño option:checked');
          const precio = selectedOption.getAttribute('data-precio');
          const cantidad = cantidadInput.value;
          const subtotalSpan = modal.querySelector('.subtotal');
          const subtotal = parseFloat(precio) * parseInt(cantidad);
          subtotalSpan.textContent = subtotal.toFixed(2);
      });
  });
});
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