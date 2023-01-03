<?php
//$db = mysqli_connect('localhost', 'root', '', 'bienes_raices');
$db = mysqli_connect('localhost', 'unikabie_admin', 'Ivan1975*', 'unikabie_bienesraices');
$idInmueble = $_GET['id'];
$documento = $_GET['document'];
$queryComprobacionDocumentoActivo = "SELECT * FROM documentosoficiales WHERE idInmueble_DocumentosOficiales = $idInmueble AND NombreDocumentosOficial = '$documento' AND Activo = 1";
$consultaComprobacionDocumentoActivo = mysqli_fetch_assoc(mysqli_query($db, $queryComprobacionDocumentoActivo));
if ($consultaComprobacionDocumentoActivo == NULL) {
  header('Location: ../index.html');
}
// // $link = '../admin/Propiedades/Ver/avisoPrivacidad.php?context=' . $hashInmueble . '&id=' . $id . '&document=' . $documento;
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Proyecto canvas</title>
  <link rel="stylesheet" href="./CSS/style.css" />
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700;900&display=swap" rel="stylesheet" />
  <script language="javascript" src="../jquery-3.6.1.min.js"></script>
</head>

<body onresize="resize()">

  <header>
  </header>
  <main id="main-container" class="main-container">

    <?php if ($documento == 'AceptacionSeguimientoCompraVenta'):?>

    <section class="container__compraventa">
      <fieldset>
        <legend>¿Deseas continuar con la compra-venta del inmueble?</legend>
        <section class="compraventa__radio">
          <section class="compraventa__radio--input">
            <input type="radio" name="decision" id="" value="Sí" required>
            <label for="">Sí</label>
          </section>
          <section class="compraventa__radio--input">
            <input type="radio" name="decision" id="" value="No" required>
            <label for="">No</label>
          </section>
        </section>
      </fieldset>
    </section>

    <?php endif;?>


    <lottie-player id="success" src="https://assets5.lottiefiles.com/private_files/lf30_pY2XZv.json" mode="bounce" background="transparent" speed="1" style="width: 300px; height: 300px;" loop autoplay></lottie-player>
    <span class="writer" id="writer">Firma aquí</span>
    <span class="loader" id="loader"></span>
    <span class="wait" id="wait">Espere un momento, se está descargando su documento</span>
    <span class="downloader" id="downloader"></span>

    <!-- <canvas id="pizarra"></canvas> -->

    <!-- <canvas id="main-canvas" class="main-canvas" style="border: 5px solid rgb(255, 0, 0)"></canvas> -->
    <section class="container__btn">
      <button type="button" class="btn__clear" id="btn__clear">Limpiar</button>
      <button type="button" class="btn__keep" id="btn__keep" onclick="firmar()">Firmar y Descargar</button>
      <!-- <a id="descargar" >
        <input type="button" value="descargar" onclick="descargar()">
      </a> -->

    </section>
    <p id="id" value="<?php echo $idInmueble ?>"></p>
    <p id="documento" value="<?php echo $documento ?>"></p>
  </main>
  <!-- <script src="assets/index.js"></script> -->
  <script src="./assets/index.js"></script>
  <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>



</html>