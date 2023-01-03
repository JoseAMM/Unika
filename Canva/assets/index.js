// //Guardar el elemento y el contexto
// const mainCanvas = document.getElementById("main-canvas");
// const firmCanvas = document.getElementById("btn__keep");
// const clearCanvas = document.getElementById("btn__clear");
// const context = mainCanvas.getContext("2d");
// let rect = mainCanvas.getBoundingClientRect();

// mainCanvas.style.width = "350px";
// mainCanvas.style.height = "300px";

// const escala = window.devicePixelRatio;

// mainCanvas.width = Math.floor(350 * 5);
// mainCanvas.height = Math.floor(300 * 5);

// context.scale(5, 5);

// let initialX;
// let initialY;

// function clear(){
//   context.strokeStyle = "#ffffff";
//   context.clearRect(0, 0, 350, 300);
// };

// clearCanvas.addEventListener("click", clear);

// const dibujar = (cursorX, cursorY) => {
//   context.beginPath();
//   context.moveTo(initialX, initialY);
//   context.lineWidth = 3;
//   context.strokeStyle = "#000";
//   context.lineCap = "round";
//   context.lineJoin = "round";
//   context.lineTo(cursorX, cursorY);
//   context.stroke();

//   initialX = cursorX;
//   initialY = cursorY;
// };

// const mouseDown = (evt) => {
//   initialX = evt.touches[0].clientX - rect.left;
//   initialY = evt.touches[0].clientY - rect.top;
//   dibujar(initialX, initialY);
//   mainCanvas.addEventListener("touchmove", mouseMoving);
// };

// const mouseMoving = (evt) => {
//   dibujar(
//     evt.touches[0].clientX - rect.left,
//     evt.touches[0].clientY - rect.top
//   );
// };

// const mouseUp = () => {
//   mainCanvas.removeEventListener("touchmove", mouseMoving);
// };

// mainCanvas.addEventListener("touchstart", mouseDown);

//  function firmar() {
//   let id = document.getElementById("id");
//   let documento = document.getElementById("documento");
//   id = id.getAttribute("value");
//   firmCanvas.setAttribute("disabled", "");
//   clearCanvas.setAttribute("disabled", "");
//   documento = documento.getAttribute("value");
//   const data = mainCanvas.toDataURL("image/png");
//   var n = Math.floor(Math.random() * 10000);
//   let nombreDocumento = id + documento + n + ".png";

//   const fd = new FormData();
//   fd.append("imagen", data); // Se llama "imagen", en PHP lo recuperamos con $_POST["imagen"]
//   fd.append("id", id); // Se llama "id", en PHP lo recuperamos con $_POST["id"]
//   fd.append("documento", documento); // Se llama "documento", en PHP lo recuperamos con $_POST["documento"]
//   fd.append("nombreDocumento", nombreDocumento); // Se llama "documento", en PHP lo recuperamos con $_POST["documento"]
//   const respuestaHttp = fetch("pngFirma.php", {
//     method: "POST",
//     body: fd,
//   });
//   // console.log(
//   //   "La imagen ha sido enviada y tiene el nombre de: " + nombreImagenSubida
//   // );

//   setTimeout(function () {
//     window.location.href =
//       "https://unikabienesraices.com/admin/Propiedades/Ver/DocumentosCanva/avisoPrivacidadFirma.php?id=" +
//       id +
//       "&document=" +
//       documento +
//       "&imagen=" +
//       nombreDocumento;
//   }, 1000);
//       setTimeout(function () {
//     window.location.replace('http://unikabienesraices.com/index.html');}, 10000)

// };

// location.href = '../../../admin/Propiedades/Ver/DocumentosCanva/avisoPrivacidadFirma.php?id=' + id + '&document=' + documento + '&imagen=' + nombreImagenSubida;

//======================================================================
// VARIABLES
//======================================================================

let mainContainer = document.getElementById("main-container");
var miCanvas = document.createElement("canvas");
miCanvas.id = "pwCanvasMain";
var miCanvasTemp = document.createElement("canvas");
miCanvasTemp.id = "pwCanvasTmp";
mainContainer.prepend(miCanvasTemp);
mainContainer.prepend(miCanvas);
let firmCanvas = document.getElementById("btn__keep");
let clearCanvas = document.getElementById("btn__clear");
let id = document.getElementById("id");
let documento = document.getElementById("documento");
firmCanvas.setAttribute("disabled", "");
let punto = true;

let lineas = [];
let correccionX = 0;
let correccionY = 0;
let pintarLinea = false;
// Marca el nuevo punto
let nuevaPosicionX = 0;
let nuevaPosicionY = 0;
var point = {
  x: 0,
  y: 0,
};
var ppts = [];

let posicion;
let posicionTemp;

posicion = miCanvas.getBoundingClientRect();
posicionTemp = miCanvasTemp.getBoundingClientRect();
correccionX = posicion.x;
correccionY = posicion.y;

miCanvas.width = miCanvasTemp.width = 370;
miCanvas.height = miCanvasTemp.height = 500;

const context = miCanvas.getContext("2d");
const tmp_context = miCanvasTemp.getContext("2d");
let rect;
let rectTemp;
rect = miCanvas.getBoundingClientRect();
rectTemp = miCanvasTemp.getBoundingClientRect();

const escala = window.devicePixelRatio;

miCanvas.width = miCanvasTemp.width = Math.floor(370 * 1.5);
miCanvas.height = miCanvasTemp.height = Math.floor(500 * 1.5);

// context.scale(4, 4);
tmp_context.scale(1.5, 1.5);

//======================================================================
// FUNCIONES
//======================================================================

const clear = () => {
  context.strokeStyle = "#ffffff";
  context.clearRect(0, 0, 370 * 1.5, 500 * 1.5);
  document.getElementById("writer").style.display = "initial";
  firmCanvas.setAttribute("disabled", "");
  ppts = [];
  point = {
    x: 0,
    y: 0,
  };
};

clearCanvas.addEventListener("click", clear);
/**
 * Funcion que empieza a dibujar la linea
 */
function empezarDibujo() {
  pintarLinea = true;
  document.getElementById("writer").style.display = "none";
  firmCanvas.removeAttribute("disabled");
  tmp_context.beginPath();
  context.beginPath();
  tmp_context.moveTo(point.x, point.y);
  punto = true;
}

/**
 * Funcion dibuja la linea
 */
function dibujarLinea(event) {
  if (pintarLinea) {
    if (event.changedTouches == undefined) {
      // Versión ratón
      point.x = event.clientX - correccionX;
      point.y = event.clientY - correccionY;
    } else {
      // Versión touch, pantalla tactil
      point.x = event.changedTouches[0].clientX - correccionX;
      point.y = event.changedTouches[0].clientY - correccionY;
    }
    punto = false;

    event.preventDefault();

    // Se guardan las coordenadas en una matriz de objetos
    ppts.push({
      x: point.x,
      y: point.y,
    });

    if (ppts.length === 3) {
      var b = ppts[0];
      tmp_context.beginPath();
      tmp_context.arc(b.x, b.y, tmp_context.lineWidth / 1, 0, Math.PI * 2, !0);
      tmp_context.fill();
      tmp_context.closePath();
      return;
    }

    // Estilos de linea
    tmp_context.lineJoin = tmp_context.lineCap = "round";

    // (Math.random() * (4 - 2.5) + 2.5).toFixed(5);
    tmp_context.lineWidth = 6;
    // Color de la linea
    tmp_context.strokeStyle = "#000000";
    tmp_context.beginPath();
    tmp_context.moveTo(ppts[0].x, ppts[0].y);
    // Limpiar el canvas temporal
    tmp_context.clearRect(0, 0, miCanvasTemp.width, miCanvasTemp.height);

    for (var i = 1; i < ppts.length - 2; i++) {
      var c = (ppts[i].x + ppts[i + 1].x) / 2;
      var d = (ppts[i].y + ppts[i + 1].y) / 2;
      tmp_context.quadraticCurveTo(ppts[i].x, ppts[i].y, c, d);
    }
    if (ppts.length == 3) {
      tmp_context.quadraticCurveTo(
        ppts[i].x,
        ppts[i].y,
        ppts[i + 1].x,
        ppts[i + 1].y
      );
    }

    tmp_context.stroke();
  }
}

/**
 * Funcion que deja de dibujar la linea
 */
function pararDibujar() {
  context.lineJoin = context.lineCap = "round";
  context.lineWidth = 5;
  context.strokeStyle = "#000000";
  context.drawImage(
    miCanvasTemp,
    posicionTemp.x - correccionX,
    posicionTemp.y - correccionY,
    miCanvasTemp.width,
    miCanvasTemp.height
  );
  tmp_context.clearRect(0, 0, miCanvasTemp.width, miCanvasTemp.height);
  pintarLinea = false;
  ppts = [];
  point = {
    x: 0,
    y: 0,
  };
}

function resize() {
  window.location.reload();
  console.log("reloading");
}
function descargar() {
  var filename = "canvas";
  link = document.getElementById("descargar");

  //Otros navegadores: Google chrome, Firefox etc...

  link.href = miCanvas.toDataURL("image/png"); // Extensión .png ("image/png") --- Extension .jpg ("image/jpeg")

  link.download = filename;
}

function dibujarPunto(event) {
  if (punto) {
    if (event.changedTouches == undefined) {
      // Versión ratón
      point.x = event.clientX - correccionX;
      point.y = event.clientY - correccionY;
    } else {
      // Versión touch, pantalla tactil
      point.x = event.changedTouches[0].clientX - correccionX;
      point.y = event.changedTouches[0].clientY - correccionY;
    }

    event.preventDefault();

    // Se guardan las coordenadas en una matriz de objetos
    ppts.push({
      x: point.x,
      y: point.y,
    });

    if (ppts.length == 1) {
      tmp_context.beginPath();
      tmp_context.arc(point.x, point.y, 2, 0, 2 * Math.PI);
      // tmp_context.stroke();
      tmp_context.fillStyle = "#000000";
      tmp_context.fill();
      tmp_context.stroke();

      context.drawImage(
        miCanvasTemp,
        posicionTemp.x - correccionX,
        posicionTemp.y - correccionY,
        miCanvasTemp.width,
        miCanvasTemp.height
      );
      tmp_context.clearRect(0, 0, miCanvasTemp.width, miCanvasTemp.height);
      ppts = [];
      point = {
        x: 0,
        y: 0,
      };
    }
  }
}

//======================================================================
// EVENTOS
//======================================================================

// Eventos raton
miCanvasTemp.addEventListener("mousedown", empezarDibujo, false);
miCanvasTemp.addEventListener("mousemove", dibujarLinea, false);
miCanvasTemp.addEventListener("mouseup", pararDibujar, false);
miCanvasTemp.addEventListener("click", dibujarPunto, false);

// Eventos pantallas táctiles
miCanvasTemp.addEventListener("touchstart", empezarDibujo, false);
miCanvasTemp.addEventListener("touchmove", dibujarLinea, false);
miCanvasTemp.addEventListener("touchend", pararDibujar, false);

/**
 * + Función para firmar el documento
 */

function firmar() {
  /**
   * * Estilos para el canvas y los botones para deshabilitarlos
   */

  document.getElementById("loader").style.display = "initial";
  document.getElementById("btn__clear").style.cursor = "not-allowed";
  document.getElementById("btn__keep").style.cursor = "not-allowed";
  document.getElementById("pwCanvasMain").style.opacity = "0.2";
  firmCanvas.setAttribute("disabled", "");
  clearCanvas.setAttribute("disabled", "");

  /**
   * * Se obtiene el id del inmuble y el nombre del documento que se va a firmar
   */

  let id = document.getElementById("id");
  id = id.getAttribute("value");
  let documento = document.getElementById("documento");
  documento = documento.getAttribute("value");

  /**
   * * Se obtiene el png del canvas
   */
  const data = miCanvas.toDataURL("image/png");

  /**
   * * El nombre del documento que aparecerá en la base de datos y que se guardará en el servidor y la referencia del documento que se va a firmar
   */
  var n = Math.floor(Math.random() * 10000);
  let nombreDocumento = id + documento + n + ".png";
  let nombreDocumentoReferencia = documento + "Firma.php";
  let referencia =
    "http://localhost:3000/admin/Propiedades/Ver/DocumentosCanva/" +
    nombreDocumentoReferencia +
    "?id=" +
    id +
    "&document=" +
    documento +
    "&imagen=" +
    nombreDocumento;

  // let referencia =
  //   "https://unikabienesraices.com/admin/Propiedades/Ver/DocumentosCanva/" +  nombreDocumentoReferencia + "?id=" +
  //   id +
  //   "&document=" +
  //   documento +
  //   "&imagen=" +
  //   nombreDocumento;

  /**
   * * Se envía a pngFirma.php para decodificarlo de base64 y guardar la imagen temporal de la firma en el servidor
   */

  const fd = new FormData();

  fd.append("imagen", data); // Se llama "imagen", en PHP lo recuperamos con $_POST["imagen"]
  fd.append("id", id); // Se llama "id", en PHP lo recuperamos con $_POST["id"]
  fd.append("documento", documento); // Se llama "documento", en PHP lo recuperamos con $_POST["documento"]
  fd.append("nombreDocumento", nombreDocumento); // Se llama "documento", en PHP lo recuperamos con $_POST["documento"]
  const respuestaHttp = fetch("pngFirma.php", {
    method: "POST",
    body: fd,
  });

  setTimeout(function () {
    document.getElementById("success").style.display = "initial";
    document.getElementById("wait").style.display = "initial";
    document.getElementById("downloader").style.display = "initial";
    document.getElementById("loader").style.display = "none";
    /**
     * / Si el documento es AceptacionSeguimientoCompraVenta, se envía la decisión al documento para la firma
     */

    if (documento == "AceptacionSeguimientoCompraVenta") {
      let decision = document.querySelector(
        'input[name="decision"]:checked'
      ).value;
      window.location.href =
        referencia +
        id +
        "&document=" +
        documento +
        "&imagen=" +
        nombreDocumento +
        "&decision=" +
        decision;
    } else {
      window.location.href =
        referencia +
        id +
        "&document=" +
        documento +
        "&imagen=" +
        nombreDocumento;
    }
  }, 6000);
  setTimeout(function () {
    window.location.replace("http://unikabienesraices.com/index.html");
  }, 40000);
}
