<?php
include_once('./includeFormatos.php');
// function aceptacionSeguimientoCompraVenta(
//     $idInmueble,
//     $nombreDocumento
// ) {

global $pdf;
global $db;

use Luecano\NumeroALetras\NumeroALetras;

$formatter = new NumeroALetras();
// if (file_exists('../DocumentosFirmados/AvisoPrivacidad' . $idInmueble . '.pdf')){
//     unlink('../DocumentosFirmados/AvisoPrivacidad' . $idInmueble . '.pdf');
// }
$pdf = new PDF();
$pdf->AddFont('Regular', '', 'Montserrat-Regular.php');
$pdf->AddFont('Bold', '', 'Montserrat-Bold.php');
$pdf->AddFont('Black', '', 'Montserrat-Black.php');

nuevaPagina();

/**
 * * Título del documento
 */
$pdf->SetY(55);
$pdf->SetX(70);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Bold', '', 13);
// widthString('Política de no discriminación', 13);
$pdf->Write(1, utf8_decode('Política de no discriminación'));
/**
 * * Línea debajo del titulo del documento
 */
$pdf->SetDrawColor(0, 0, 0);
$pdf->SetLineWidth(0.55);
$pdf->Line(69, 59, 143, 59);
/**
 * * Cuerpo 1
 */
$pdf->SetY(65);
$pdf->SetX(22);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Regular', '', 9);
$pdf->MultiCell(168, 8, utf8_decode('En Unika Bienes Raíces nos apegamos al ARTÍCULO 58 de la LFPC en el entendido de que el proveedor de bienes, productos o servicios no podrá negarlos o condicionarlos al consumidor por razones de género, discapacidad, nacionalidad, étnicas, preferencia sexual, religiosas o cualquiera otra particularidad. Los proveedores de bienes y servicios que ofrezcan éstos al público en general, no podrán establecer preferencias o discriminación alguna respecto a los solicitantes del servicio, tales como selección de clientela, condicionamiento del consumo, reserva del derecho de admisión, exclusión a personas con discapacidad y otras prácticas similares, salvo por causas que afecten la seguridad o tranquilidad del establecimiento, de sus clientes o de las personas con discapacidad, o se funden en disposiciones expresas de otros ordenamientos legales. Dichos proveedores en ningún caso podrán aplicar o cobrar tarifas superiores a las autorizadas o registradas para la clientela en general, ni ofrecer o aplicar descuentos en forma parcial o discriminatoria. Tampoco podrán aplicar o cobrar cuotas extraordinarias o compensatorias a las personas con discapacidad por sus implementos médicos, ortopédicos, tecnológicos, educativos o deportivos necesarios para su uso personal incluyéndose los animales de asistencia, tales como perros guía en el caso de personas ciegas o débiles visuales. Los proveedores están obligados a adoptar las medidas de accesibilidad de conformidad con lo estipulado en el artículo 16 de la Ley General para la Inclusión de las Personas con Discapacidad o contar con los dispositivos indispensables para que las personas con discapacidad puedan utilizar los bienes o servicios que ofrecen. Dichas medidas no pueden ser inferiores a los que determinen las disposiciones legales o normas oficiales aplicables, ni tampoco podrá el proveedor establecer condiciones o limitaciones que reduzcan los derechos que legalmente correspondan a la persona con discapacidad como consumidor.'), 0, 'FJ', false);


/**
 * * Botón "recibido" para firmar digitalmente
 */
$pdf->SetDrawColor(255, 0, 0);
$pdf->SetFillColor(255, 0, 0);
$pdf->Rect(82, 240, 46, 10, 'FD');
//$pdf->Link(82, 240, 46, 10, 'https://unikabienesraices.com/Canva/index.php?id=' . $idInmueble . '&document=' . $nombreDocumento);


// Texto: Click aquí para firmar
$pdf->SetY(245);
$pdf->SetX(84);
$pdf->SetTextColor(255, 255, 255);
$pdf->SetFont('Bold', '', 10);
$pdf->Write(1, utf8_decode('Click aquí para firmar'));


// $queryInsertarEnTablaTemporal = "INSERT INTO informaciontemporaldocumentosoficiales (NombreCliente, Domicilio, Telefono, RFC, Correo, idInmueble_InformacionTemporalDocumentosOficiales, NombreDocumento) VALUES ('$nombrePrivacidad', '$domicilioPrivacidad', '$telefonoPrivacidad', '$rfcPrivacidad', '$emailPrivacidad', $idInmueble, '$nombreDocumento')";
// mysqli_query($db, $queryInsertarEnTablaTemporal);
$name = $pdf->SetTitle('aceptacionSeguimientoCompraVenta.pdf');
$pdf->Output('I', 'aceptacionSeguimientoCompraVenta.pdf');
