<?php
include_once('./includeFormatosFirma.php');


$idInmueble = $_GET['id'];
$nombreDocumento = $_GET['document'];
$nombreImagenSubida = $_GET['imagen'];
$decision = $_GET['decision'];

$queryTablaTemporalDocumentosOficiales = "SELECT * FROM informaciontemporaldocumentosoficiales WHERE idInmueble_InformacionTemporalDocumentosOficiales = $idInmueble AND NombreDocumento = '$nombreDocumento'";
$consultaTablaTemporalDocumentosOficiales = mysqli_fetch_assoc(mysqli_query($db, $queryTablaTemporalDocumentosOficiales));



$nombreCompradorAceptacion = $consultaTablaTemporalDocumentosOficiales['NombreCompradorAceptacion'];
$ubicacionAceptacion = $consultaTablaTemporalDocumentosOficiales['DireccionInmuebleAceptacion'];

$nombreImagen = '../../../../Canva/assets/Firmas/' . $nombreImagenSubida;

$pdf = new PDF();
$pdf->AddPage('P', 'Letter');
$pdf->AddFont('Regular', '', 'Montserrat-Regular.php');
$pdf->AddFont('Bold', '', 'Montserrat-Bold.php');
$pdf->AddFont('Black', '', 'Montserrat-Black.php');
$i = 1;
// Colores de los bordes, fondo y texto
$pdf->SetDrawColor(190, 190, 190);
// Colores de los bordes, fondo y texto
$pdf->SetFillColor(255, 255, 255);
$pdf->SetTextColor(255, 0, 0);
// Logo Unika BR
$pdf->Image('../../../../Assets/logo.png', 22, 10, 60.2, 28);
// Línea
$pdf->SetDrawColor(255, 0, 0);
$pdf->SetLineWidth(0.55);
$pdf->Line(22, 41, 190, 41);
/**
 * * Título del documento
 */
$pdf->SetY(60);
$pdf->SetX(22);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Bold', '', 13);
$pdf->Cell(168, 0, utf8_decode('Aceptación de continuación de Compra-Venta del inmueble'), 0, 0, 'FJ', 1);
/**
 * * Línea debajo del titulo del documento
 */
$pdf->SetDrawColor(0, 0, 0);
$pdf->SetLineWidth(0.55);
$pdf->Line(22, 64, 190, 64);
/**
 * * Cuerpo 1
 */
$pdf->SetY(90);
$pdf->SetX(22);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Regular', '', 10);
$pdf->Cell(168, 0, utf8_decode('Por medio de la presente yo (Nombre del comprador)'), 0, 0, 'FJ', 1);
/**
 * * Línea debajo del nombre del comprador
 */
$pdf->SetDrawColor(0, 0, 0);
$pdf->SetLineWidth(0.2);
$pdf->Line(22, 102, 190, 102);
/**
 * * Nombre Comprador
 */
$pdf->SetY(99);
$pdf->SetX(22);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Bold', '', 10);
$pdf->Cell(168, 0, utf8_decode($nombreCompradorAceptacion), 0, 0, 'FJ', false);


/**
 * * Cuerpo 1
 */
$pdf->SetY(105);
$pdf->SetX(22);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Regular', '', 10);
$pdf->MultiCell(168, 11, utf8_decode('Confirmo que una vez transcurrido los 5 días después de la firma de apartado para COMPRAVENTA del inmueble ubicado en'), 0, 'FJ', 1);
/**
 * * Línea debajo de la dirección del inmueble
 */
$pdf->SetDrawColor(0, 0, 0);
$pdf->SetLineWidth(0.2);
$pdf->Line(22, 134, 190, 134);
/**
 * * Dirección del Inmueble
 */
$pdf->SetY(126);
$pdf->SetX(22);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Bold', '', 10);
$pdf->MultiCell(168, 11, utf8_decode($ubicacionAceptacion), 0, 'FJ', false);
/**
 * * Cuerpo 2
 */
$pdf->SetY(137);
$pdf->SetX(22);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Regular', '', 10);
$pdf->MultiCell(128, 11, utf8_decode('he decidio SI/NO'), 0, 'FJ', 0);
/**
 * * Línea debajo de SI/NO
 */
$pdf->SetDrawColor(0, 0, 0);
$pdf->SetLineWidth(0.2);
$pdf->Line(153, 145, 190, 145);
/**
 * * Cuerpo 2
 */
$pdf->SetY(137);
$pdf->SetX(167);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Bold', '', 10);
$pdf->MultiCell(128, 11, utf8_decode($decision), 0, 'FJ', 0);
/**
 * * Cuerpo 3
 */
$pdf->SetY(149);
$pdf->SetX(22);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Regular', '', 10);
$pdf->MultiCell(168, 11, utf8_decode('continuar con la compraventa del mismo.'), 0, 'FJ', 0);
/**
 * * Fecha:
 */
$pdf->SetY(200);
$pdf->SetX(22);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Bold', '', 10);
$pdf->MultiCell(168, 11, utf8_decode('Fecha:'), 0, 'FJ', 0);
/**
 * * Fecha:
 */
$pdf->SetY(200);
$pdf->SetX(38);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Bold', '', 10);
$pdf->MultiCell(150, 11, utf8_decode($fecha), 0, 'FJ', 0);


/**
 * * Firma
 */
$pdf->Image($nombreImagen, 95, 225, 30, 30);

/**
 * * Línea arriba de la dirección
 */
$pdf->SetDrawColor(255, 0, 0);
$pdf->SetLineWidth(0.55);
$pdf->Line(22, 255, 190, 255);
/**
 * * Dirección de la oficina a cargo
 */
$pdf->SetY(258);
$pdf->SetX(32);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Bold', '', 9);
$pdf->Write(1, utf8_decode('Heriberto Frías 1149 Ofna 1, Col. Del Valle, CDMX // unikacdmx@gmail.com // Tel 56828888'));

$queryBorrarDatosTemporales = "DELETE FROM informaciontemporaldocumentosoficiales WHERE idInmueble_InformacionTemporalDocumentosOficiales = $idInmueble AND NombreDocumento = '$nombreDocumento'";

mysqli_query($db, $queryBorrarDatosTemporales);

$queryDesactivarFirma = "UPDATE documentosoficiales SET Activo = 0 WHERE idInmueble_DocumentosOficiales = $idInmueble AND NombreDocumentosOficial = '$nombreDocumento'";
mysqli_query($db, $queryDesactivarFirma);
$name = $pdf->SetTitle('aceptacionSeguimientoCompraVenta.pdf');
$pdf->Output('F', '../DocumentosFirmados/AceptacionSeguimientoCompraVenta'. $idInmueble.'.pdf');
$pdf->Output('D', 'AceptacionSeguimientoCompraVenta.pdf');
