<?php
$imagenCodificada = $_POST["imagen"];
$idInmueble = $_POST["id"];
$imagenCodificadaLimpia = str_replace("data:image/png;base64,", "", $imagenCodificada);
$imagenDecodificada = base64_decode($imagenCodificadaLimpia);
$nombreImagenGuardada = uniqid() . ".png";
file_put_contents($nombreImagenGuardada, $imagenDecodificada);
echo json_encode($nombreImagenGuardada);
