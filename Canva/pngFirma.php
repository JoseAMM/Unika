<?php
$imagenCodificada = $_POST["imagen"];
$idInmueble = $_POST["id"];
$nombreDocumento = $_POST["nombreDocumento"];
$imagenCodificadaLimpia = str_replace("data:image/png;base64,", "", $imagenCodificada);
$imagenDecodificada = base64_decode($imagenCodificadaLimpia);
$nombreImagenGuardada = "./assets/Firmas/" . $nombreDocumento;
file_put_contents($nombreImagenGuardada, $imagenDecodificada);
