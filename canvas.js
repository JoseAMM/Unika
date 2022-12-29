var canvas = document.querySelector("#paint");
var ctx = canvas.getContext("2d");
var sketch = document.querySelector("#sketch");
var sketch_style = getComputedStyle(sketch);
canvas.width = parseInt(sketch_style.getPropertyValue("width"));
canvas.height = parseInt(sketch_style.getPropertyValue("height"));
canvas.width = 1000;
canvas.height = 500;

const escala = window.devicePixelRatio;

canvas.width = Math.floor(1000 * 5);
canvas.height = Math.floor(500 * 5);

ctx.scale(5, 5);

var mouse = { x: 0, y: 0 };
var last_mouse = { x: 0, y: 0 };
var point = {
  x: 0,
  y: 0,
};
var ppts = [];
/* Mouse Capturing Work */
canvas.addEventListener(
  "mousemove",
  function (e) {
    // last_mouse.x = mouse.x;
    // last_mouse.y = mouse.y;
    point.x = e.pageX - this.offsetLeft;
    point.y = e.pageY - this.offsetTop;
  },
  false
);

/* Drawing on Paint App */
ctx.lineWidth = 2;
ctx.lineJoin = "round";
ctx.lineCap = "round";
ctx.strokeStyle = "blue";
canvas.addEventListener(
  "mousedown",
  function (e) {
    // ctx.beginPath();
    ctx.moveTo(point.x, point.y);
    canvas.addEventListener("mousemove", onPaint, false);
  },
  false
);
canvas.addEventListener(
  "mouseup",
  function () {
    canvas.removeEventListener("mousemove", onPaint, false);
    point = {
        x: 0,
        y: 0,
      };
    ppts = [];
  },
  false
);
var onPaint = function (e) {
  if (e) {
    e.preventDefault();
    // setPointFromEvent(point, e);
  }

  // Saving all the points in an array
  ppts.push({
    x: point.x,
    y: point.y,
  });

  if (ppts.length === 3) {
    var b = ppts[0];
    ctx.beginPath();
    ctx.arc(b.x, b.y, ctx.lineWidth / 2, 0, Math.PI * 2, !0);
    ctx.fill();
    ctx.closePath();
    return;
  }

  // Tmp canvas is always cleared up before drawing.
  ctx.clearRect(0, 0, canvas.width, canvas.height);
  ctx.lineJoin = ctx.lineCap = "round";
  ctx.lineWidth = 4;
  // Color de la linea
  ctx.strokeStyle = "#000000";

  ctx.beginPath();
  ctx.moveTo(ppts[0].x, ppts[0].y);

  for (var i = 1; i < ppts.length - 2; i++) {
    var c = (ppts[i].x + ppts[i + 1].x) / 2;
    var d = (ppts[i].y + ppts[i + 1].y) / 2;
    ctx.quadraticCurveTo(ppts[i].x, ppts[i].y, c, d);
  }

  // For the last 2 points
  ctx.quadraticCurveTo(ppts[i].x, ppts[i].y, ppts[i + 1].x, ppts[i + 1].y);
  ctx.stroke();
  ctx.closePath();
};



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

// //======================================================================
// // VARIABLES
// //======================================================================
// let miCanvas = document.getElementById("pizarra");
// let firmCanvas = document.getElementById("btn__keep");
// let clearCanvas = document.getElementById("btn__clear");
// let id = document.getElementById("id");
// let documento = document.getElementById("documento");
// firmCanvas.setAttribute("disabled", "");

// let lineas = [];
// let correccionX = 0;
// let correccionY = 0;
// let pintarLinea = false;
// // Marca el nuevo punto
// let nuevaPosicionX = 0;
// let nuevaPosicionY = 0;
// var point = {
//   x: 0,
//   y: 0,
// };
// var ppts = [];

// let posicion = miCanvas.getBoundingClientRect();
// correccionX = posicion.x;
// correccionY = posicion.y;

// miCanvas.width = 370;
// miCanvas.height = 500;

// const context = miCanvas.getContext("2d");
// let rect = miCanvas.getBoundingClientRect();

// const escala = window.devicePixelRatio;

// miCanvas.width = Math.floor(370 * 4);
// miCanvas.height = Math.floor(500 * 4);

// context.scale(4, 4);

//**
inicio del codigo bien 
 */
// //======================================================================
// // FUNCIONES
// //======================================================================

// const clear = () => {
//   context.strokeStyle = "#ffffff";
//   context.clearRect(0, 0, 370, 500);
//   lineas = [];
//   document.getElementById("writer").style.display = "initial";
//   firmCanvas.setAttribute("disabled", "");
//   ppts = [];
//   point = {
//     x: 0,
//     y: 0,
//   };
// };

// clearCanvas.addEventListener("click", clear);
// /**
//  * Funcion que empieza a dibujar la linea
//  */
// function empezarDibujo() {
//   pintarLinea = true;
//   lineas.push([]);
//   document.getElementById("writer").style.display = "none";
//   firmCanvas.removeAttribute("disabled");

//   context.beginPath();
//   context.moveTo(point.x, point.y);
//   // canvas.addEventListener("mousemove", onPaint, false);
// }

// /**
//  * Funcion que guarda la posicion de la nueva línea
//  */
// function guardarLinea() {
//   lineas[lineas.length - 1].push({
//     x: nuevaPosicionX,
//     y: nuevaPosicionY,
//   });
// }

// /**
//  * Funcion dibuja la linea
//  */
// function dibujarLinea(event) {
//   if (pintarLinea) {
//     if (event.changedTouches == undefined) {
//       // Versión ratón
//       point.x = event.clientX - correccionX;
//       point.y = event.clientY - correccionY;
//     } else {
//       // Versión touch, pantalla tactil
//       point.x = event.changedTouches[0].clientX - correccionX;
//       point.y = event.changedTouches[0].clientY - correccionY;
//     }
//     event.preventDefault();
//     // Saving all the points in an array
//     ppts.push({
//       x: point.x,
//       y: point.y,
//     });

//     if (ppts.length === 3) {
//       var b = ppts[0];
//       context.beginPath();
//       context.arc(b.x, b.y, context.lineWidth / 4, 0, Math.PI * 2, !0);
//       context.fill();
//       context.closePath();
//       return;
//     }

//     // // Tmp canvas is always cleared up before drawing.
//     // context.clearRect(0, 0, miCanvas.width, miCanvas.height);
//     // Estilos de linea
//     context.lineJoin = context.lineCap = "round";
//     context.lineWidth = 4;
//     // Color de la linea
//     context.strokeStyle = "#000000";
//     context.beginPath();
//     context.moveTo(ppts[0].x, ppts[0].y);
//     context.clearRect(0, 0, miCanvas.width, miCanvas.height);

//     for (var i = 1; i < ppts.length - 2; i++) {
//       var c = (ppts[i].x + ppts[i + 1].x) / 2;
//       var d = (ppts[i].y + ppts[i + 1].y) / 2;
//       context.quadraticCurveTo(ppts[i].x, ppts[i].y, c, d);
//     }

//     // For the last 2 points
//     context.quadraticCurveTo(
//       ppts[i].x,
//       ppts[i].y,
//       ppts[i + 1].x,
//       ppts[i + 1].y
//     );
//     context.stroke();

//     // let ctx = miCanvas.getContext("2d");
//     // // Estilos de linea
//     // ctx.lineJoin = ctx.lineCap = "round";
//     // ctx.lineWidth = 5;
//     // // Color de la linea
//     // ctx.strokeStyle = "#000000";
//     // // Marca el nuevo punto
//     // if (event.changedTouches == undefined) {
//     //   // Versión ratón
//     //   nuevaPosicionX = event.clientX - correccionX;
//     //   nuevaPosicionY = event.clientY - correccionY;
//     // } else {
//     //   // Versión touch, pantalla tactil
//     //   nuevaPosicionX = event.changedTouches[0].clientX - correccionX;
//     //   nuevaPosicionY = event.changedTouches[0].clientY - correccionY;
//     // }
//     // // Guarda la linea
//     // guardarLinea();
//     // // Redibuja todas las lineas guardadas
//     // ctx.beginPath();
//     // lineas.forEach(function (segmento) {
//     //   ctx.moveTo(segmento[0].x, segmento[0].y);
//     //   segmento.forEach(function (punto, index) {
//     //     ctx.lineTo(punto.x, punto.y);
//     //   });
//     // });
//     // ctx.stroke();
//   }
// }

// /**
//  * Funcion que deja de dibujar la linea
//  */
// function pararDibujar() {
//   // miCanvas.removeEventListener("mousemove", dibujarLinea, false);
//   pintarLinea = false;
//   // guardarLinea();
//   ppts = [];
//   point = {
//     x: 0,
//     y: 0,
//   };
// }

// //======================================================================
// // EVENTOS
// //======================================================================

// // Eventos raton
// miCanvas.addEventListener("mousedown", empezarDibujo, false);
// miCanvas.addEventListener("mousemove", dibujarLinea, false);
// miCanvas.addEventListener("mouseup", pararDibujar, false);

// // Eventos pantallas táctiles
// miCanvas.addEventListener("touchstart", empezarDibujo, false);
// miCanvas.addEventListener("touchmove", dibujarLinea, false);

// // Firmar

// function firmar() {
//   document.getElementById("loader").style.display = "initial";
//   document.getElementById("btn__clear").style.cursor = "not-allowed";
//   document.getElementById("btn__keep").style.cursor = "not-allowed";
//   let id = document.getElementById("id");
//   let documento = document.getElementById("documento");
//   id = id.getAttribute("value");
//   firmCanvas.setAttribute("disabled", "");
//   clearCanvas.setAttribute("disabled", "");
//   documento = documento.getAttribute("value");
//   const data = miCanvas.toDataURL("image/png");
//   var n = Math.floor(Math.random() * 10000);
//   let nombreDocumento = id + documento + n + ".png";
//   document.getElementById("pizarra").style.opacity = "0.2";

//   const fd = new FormData();
//   fd.append("imagen", data); // Se llama "imagen", en PHP lo recuperamos con $_POST["imagen"]
//   fd.append("id", id); // Se llama "id", en PHP lo recuperamos con $_POST["id"]
//   fd.append("documento", documento); // Se llama "documento", en PHP lo recuperamos con $_POST["documento"]
//   fd.append("nombreDocumento", nombreDocumento); // Se llama "documento", en PHP lo recuperamos con $_POST["documento"]
//   const respuestaHttp = fetch("pngFirma.php", {
//     method: "POST",
//     body: fd,
//   });
//   // // console.log(
//   // //   "La imagen ha sido enviada y tiene el nombre de: " + nombreImagenSubida
//   // // );

//   setTimeout(function () {
//     document.getElementById("success").style.display = "initial";
//     document.getElementById("wait").style.display = "initial";
//     document.getElementById("downloader").style.display = "initial";
//     document.getElementById("loader").style.display = "none";

//     window.location.href =
//       "https://unikabienesraices.com/admin/Propiedades/Ver/DocumentosCanva/avisoPrivacidadFirma.php?id=" +
//       id +
//       "&document=" +
//       documento +
//       "&imagen=" +
//       nombreDocumento;
//   }, 6000);
//   setTimeout(function () {
//     window.location.replace("http://unikabienesraices.com/index.html");
//   }, 10000);
// }
