<?php
$hashInmueble = $_GET['context'];
$id = $_GET['id'];
$documento = $_GET['document'];

if (!$hashInmueble) {
  header('Location: ../index.html');
}

$verifyHash = password_verify('inmueble', $hashInmueble);

if (!$verifyHash) {
  header('Location: ../index.html');
}


$link = '../admin/Propiedades/Ver/avisoPrivacidad.php?context=' . $hashInmueble . '&id=' . $id . '&document=' . $documento;
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Proyecto canvas</title>
  <link rel="stylesheet" href="assets/style.css" />
  <script language="javascript" src="../jquery-3.6.1.min.js"></script>
</head>

<body>
  <main class="main-container">
    <canvas id="main-canvas" class="main-canvas" style="border: 5px solid rgb(255, 0, 0)"></canvas>
    <section class="container__btn">
      <button class="btn__clear" id="btn__clear">Limpiar</button>
      <button class="btn__keep" id="btn__keep">Firmar y Descargar</button>
    </section>
    <p id="id" value="<?php echo $id ?>"></p>
    <p id="documento" value="<?php echo $documento ?>"></p>
    <p id="hashInmueble" value="<?php echo $hashInmueble ?>"></p>
  </main>
  <script src="assets/index.js"></script>
</body>

</html>