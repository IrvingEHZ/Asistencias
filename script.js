document.addEventListener("DOMContentLoaded", function() {
  const mensajeElement = document.getElementById("conferencia");
  const mensaje = document.getElementById("hora");
  const now = new Date();
  const hours = now.getHours();
  const minutes = now.getMinutes();

  if (hours === 12 && minutes === 21) {
    mensajeElement.textContent = "Conferencia de orcl";
	mensaje.textContent = "Horario de Inicio: 12:30"
  }
});



