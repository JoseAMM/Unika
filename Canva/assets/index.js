//Guardar el elemento y el contexto
const mainCanvas = document.getElementById("main-canvas");
const firmCanvas = document.getElementById("btn__keep");
const clearCanvas = document.getElementById("btn__clear");
const context = mainCanvas.getContext("2d");
let rect = mainCanvas.getBoundingClientRect();

mainCanvas.style.width = "350px";
mainCanvas.style.height = "300px";

const escala = window.devicePixelRatio;

mainCanvas.width = Math.floor(350 * 8);
mainCanvas.height = Math.floor(300 * 8);

context.scale(8, 8);

let initialX;
let initialY;

const clear = () => {
  context.strokeStyle = "#ffffff";
  context.clearRect(0, 0, 350, 300);
};

clearCanvas.addEventListener("click", clear);

const dibujar = (cursorX, cursorY) => {
  context.beginPath();
  context.moveTo(initialX, initialY);
  context.lineWidth = 3;
  context.strokeStyle = "#000";
  context.lineCap = "round";
  context.lineJoin = "round";
  context.lineTo(cursorX, cursorY);
  context.stroke();

  initialX = cursorX;
  initialY = cursorY;
};

const mouseDown = (evt) => {
  initialX = evt.touches[0].clientX - rect.left;
  initialY = evt.touches[0].clientY - rect.top;
  dibujar(initialX, initialY);
  mainCanvas.addEventListener("touchmove", mouseMoving);
};

const mouseMoving = (evt) => {
  dibujar(
    evt.touches[0].clientX - rect.left,
    evt.touches[0].clientY - rect.top
  );
};

const mouseUp = () => {
  mainCanvas.removeEventListener("touchmove", mouseMoving);
};

mainCanvas.addEventListener("touchstart", mouseDown);

 function firmar() {
  let id = document.getElementById("id");
  let documento = document.getElementById("documento");
  id = id.getAttribute("value");
  firmCanvas.setAttribute("disabled", "");
  clearCanvas.setAttribute("disabled", "");
  documento = documento.getAttribute("value");
  const data = mainCanvas.toDataURL("image/png");
  var n = Math.floor(Math.random() * 10000);
  let nombreDocumento = id + documento + n + ".png";

  const fd = new FormData();
  fd.append("imagen", data); // Se llama "imagen", en PHP lo recuperamos con $_POST["imagen"]
  fd.append("id", id); // Se llama "id", en PHP lo recuperamos con $_POST["id"]
  fd.append("documento", documento); // Se llama "documento", en PHP lo recuperamos con $_POST["documento"]
  fd.append("nombreDocumento", nombreDocumento); // Se llama "documento", en PHP lo recuperamos con $_POST["documento"]
  const respuestaHttp = fetch("pngFirma.php", {
    method: "POST",
    body: fd,
  });
  // console.log(
  //   "La imagen ha sido enviada y tiene el nombre de: " + nombreImagenSubida
  // );

  setTimeout(function () {
    window.location.href =
      "https://unikabienesraices.com/admin/Propiedades/Ver/DocumentosCanva/avisoPrivacidadFirma.php?id=" +
      id +
      "&document=" +
      documento +
      "&imagen=" +
      nombreDocumento;
  }, 1000);
      setTimeout(function () {
    window.location.replace('http://unikabienesraices.com/index.html');}, 10000)

};

// location.href = '../../../admin/Propiedades/Ver/DocumentosCanva/avisoPrivacidadFirma.php?id=' + id + '&document=' + documento + '&imagen=' + nombreImagenSubida;
