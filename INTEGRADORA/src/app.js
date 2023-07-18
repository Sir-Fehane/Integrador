document.addEventListener("DOMContentLoaded", function() {
    // Obtener todos los botones de tarjeta
    const cardButtons = document.querySelectorAll(".card");
  
    // Agregar un evento de clic a cada botón de tarjeta
    cardButtons.forEach(function(button) {
      button.addEventListener("click", function() {
        // Obtener el título de la tarjeta seleccionada
        const title = this.querySelector(".titulo-item").textContent;
  
        // Actualizar el título del modal con el título de la tarjeta seleccionada
        const modalTitle = document.querySelector("#titulo-modal");
        modalTitle.textContent = title;
      });
    });
  });
  