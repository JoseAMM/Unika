<?php
$db = mysqli_connect('localhost', 'root', '', 'bienes_raices');
//$db = mysqli_connect('localhost', 'unikabie_admin', 'Ivan1975*', 'unikabie_bienesraices');
include_once('../../../../Reportes_PDF/fpdf.php');
include_once('./force_justify.php');
function widthString($texto, $size)
{
    global $pdf;
    $pdf->SetY(5);
    $pdf->SetX(5);
    $pdf->SetTextColor(255, 0, 0);
    $pdf->SetFont('Bold', '', $size);
    $pageWidth = $pdf->GetPageWidth();
    $pageWidth /= 2;
    $widthString = $pdf->GetStringWidth($texto);
    $widthString /= 2;
    $centrar = round($pageWidth - $widthString);
    $pdf->Write(1, $centrar);
}
// function aceptacionSeguimientoCompraVenta(
//     $idInmueble,
//     $nombreDocumento
// ) {

global $pdf;
global $db;
// if (file_exists('../DocumentosFirmados/AvisoPrivacidad' . $idInmueble . '.pdf')){
//     unlink('../DocumentosFirmados/AvisoPrivacidad' . $idInmueble . '.pdf');
// }
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
$pdf->SetY(55);
$pdf->SetX(86);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Bold', '', 13);
$pdf->Write(1, utf8_decode('Carta de derechos'));
/**
 * * Línea debajo del titulo del documento
 */
$pdf->SetDrawColor(0, 0, 0);
$pdf->SetLineWidth(0.55);
$pdf->Line(86, 59, 133, 59);
/**
 * * Cuerpo 1
 */
$pdf->SetY(65);
$pdf->SetX(22);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Regular', '', 10);
$pdf->MultiCell(168, 10, utf8_decode('En todas las transacciones comerciales de compraventa de casa habitación, el proveedor se compromete a que éstas se lleven a cabo conforme lo dispuesto en la LFPC, su Reglamento y a esta NOM, por lo cual reconoce que los consumidores cuentan con los siguientes derechos:

1. Recibir, respecto de los bienes inmuebles ofertados, información y publicidad veraz, clara y actualizada, sin importar el medio por el que se comunique, incluyendo los medios digitales, de forma tal que le permita al consumidor tomar la mejor decisión de compra conociendo de manera veraz las características del inmueble que está adquiriendo, conforme a lo dispuesto por la Ley.

2. Conocer la información sobre las características del inmueble, entre éstas: la extensión del terreno, superficie construida, tipo de estructura, instalaciones, acabados, accesorios, lugar de estacionamiento, áreas de uso común, servicios con que cuenta y estado general físico del inmueble.

3. Elegir libremente el inmueble que mejor satisfaga sus necesidades y se ajuste a su capacidad de compra.'), 0, 'FJ', 1);
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
/**
 * *    Agrega una nueva página
 */
$pdf->AddPage('P', 'Letter');
/**
 * * Encabezado
 */
$pdf->SetDrawColor(190, 190, 190);
$pdf->SetFillColor(255, 255, 255);
$pdf->SetTextColor(255, 0, 0);
$pdf->Image('../../../../Assets/logo.png', 22, 10, 60.2, 28);
$pdf->SetDrawColor(255, 0, 0);
$pdf->SetLineWidth(0.55);
$pdf->Line(22, 41, 190, 41);
/**
 * * Cuerpo 2
 */
$pdf->SetY(55);
$pdf->SetX(22);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Regular', '', 10);
$pdf->MultiCell(168, 10, utf8_decode('4. No realizar pago alguno hasta que conste por escrito la relación contractual, exceptuando los referentes a anticipos y gastos operativos, en los términos previstos por la LFPC.

5. Firmar un contrato de adhesión bajo el modelo inscrito en la Procuraduría Federal del Consumidor, en el que consten los términos y condiciones de la compraventa del bien Inmueble. Posterior a su firma, el proveedor tiene la obligación de entregar una copia del contrato firmado al consumidor.

6. Adquirir un inmueble que cuente con las características de seguridad y calidad que estén contenidas en la normatividad aplicable y plasmadas en la información y publicidad que haya recibido.

7. Recibir el bien inmueble en el plazo y condiciones acordados con el proveedor en el contrato de adhesión respectivo.

8. En su caso, ejercer las garantías sobre bienes inmuebles previstas en la LFPC, considerando las especificaciones previstas en el contrato de adhesión respectivo.'), 0, 'FJ', 1);
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

/**
 * * Agrega una nueva página
 */
$pdf->AddPage('P', 'Letter');
/**
 * * Encabezado
 */
$pdf->SetDrawColor(190, 190, 190);
$pdf->SetFillColor(255, 255, 255);
$pdf->SetTextColor(255, 0, 0);
$pdf->Image('../../../../Assets/logo.png', 22, 10, 60.2, 28);
$pdf->SetDrawColor(255, 0, 0);
$pdf->SetLineWidth(0.55);
$pdf->Line(22, 41, 190, 41);
/**
 * * Cuerpo 2
 */
$pdf->SetY(55);
$pdf->SetX(22);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Regular', '', 10);
$pdf->MultiCell(168, 10, utf8_decode('9. Recibir la bonificación o compensación correspondiente en términos de la LFPC, en caso de que, una vez ejercida la garantía, persistan defectos o fallas en el inmueble. Asimismo, a que se realicen las reparaciones necesarias en caso de defectos o fallas imputables al proveedor, u optar por la substitución del inmueble o rescisión del contrato cuando proceda.

10. Contar con canales y mecanismos de atención gratuitos y accesibles para consultas, solicitudes, reclamaciones y sugerencias al proveedor, y conocer el domicilio señalado por el proveedor para oír y recibir notificaciones.

11. Derecho a la protección por parte de las autoridades competentes y conforme a las leyes aplicables, incluyendo el derecho a presentar denuncias y reclamaciones ante las mismas.

12.Tener a su disposición un Aviso de Privacidad para conocer el tratamiento que se dará a los datos personales que proporcione y consentirlo, en su caso; que sus datos personales sean tratados conforme a la normatividad aplicable y, conocer los mecanismos disponibles para realizar el ejercicio de sus Derechos de Acceso, Rectificación, Cancelación y Oposición.'), 0, 'FJ', 1);
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
/**
 * *    Agrega una nueva página
 */
$pdf->AddPage('P', 'Letter');
/**
 * * Encabezado
 */
$pdf->SetDrawColor(190, 190, 190);
$pdf->SetFillColor(255, 255, 255);
$pdf->SetTextColor(255, 0, 0);
$pdf->Image('../../../../Assets/logo.png', 22, 10, 60.2, 28);
$pdf->SetDrawColor(255, 0, 0);
$pdf->SetLineWidth(0.55);
$pdf->Line(22, 41, 190, 41);
/**
 * * Cuerpo 4
 */
$pdf->SetY(55);
$pdf->SetX(22);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Regular', '', 10);
$pdf->MultiCell(168, 10, utf8_decode('13. Recibir un trato libre de discriminación, sin que se le pueda negar o condicionar la atención o venta de una vivienda por razones de género, nacionalidad, étnicas, preferencia sexual, religiosas o cualquiera otra particularidad en los términos de la legislación aplicable.

14. Elegir libremente al notario público para realizar el trámite de escrituración.'), 0, 'FJ', 1);


/**
 * + Sección: Firma de recibido
 */

/**
 * * Texto: Firma de recibido
 */
$pdf->SetY(140);
$pdf->SetX(42);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Bold', '', 9);
$pdf->Write(1, utf8_decode('Firma de recibido'));

/**
 * * Botón "recibido" para firmar digitalmente
 */
$pdf->SetDrawColor(255, 0, 0);
$pdf->SetFillColor(255, 0, 0);
$pdf->Rect(35, 160, 46, 10, 'FD');
// $pdf->Link(82, 200, 46, 10, 'https://unikabienesraices.com/Canva/index.php?id=' . $idInmueble . '&document=' . $nombreDocumento);
$pdf->SetY(165);
$pdf->SetX(37);
$pdf->SetTextColor(255, 255, 255);
$pdf->SetFont('Bold', '', 10);
$pdf->Write(1, utf8_decode('Click aquí para firmar'));

/**
 * * Línea para Botón "recibido"
 */
$pdf->SetDrawColor(0, 0, 0);
$pdf->SetLineWidth(0.3);
$pdf->Line(35, 170, 81, 170);

/**
 * * Texto: Nombre:
 */
$pdf->SetY(179);
$pdf->SetX(49);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Bold', '', 9);
$pdf->Write(1, utf8_decode('Nombre:'));

/**
 * * Texto: Nombre del asesor
 */
$pdf->SetY(187);
$pdf->SetX(35);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Bold', '', 9);
$pdf->MultiCell(46, 10, utf8_decode('José Antonio Medina Martinez'), 0, 'FJ', false);
/**
 * * Línea 1 para Nombre:
 */
$pdf->SetDrawColor(0, 0, 0);
$pdf->SetLineWidth(0.15);
$pdf->Line(35, 197, 81, 197);
/**
 * * Línea 2 para Nombre:
 */
$pdf->SetDrawColor(0, 0, 0);
$pdf->SetLineWidth(0.15);
$pdf->Line(35, 207, 81, 207);
/**
 * * Texto: Cargo:
 */
$pdf->SetY(215);
$pdf->SetX(51);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Bold', '', 9);
$pdf->Write(1, utf8_decode('Cargo:'));

/**
 * * Texto: Nombre del asesor
 */
$pdf->SetY(223);
$pdf->SetX(35);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Bold', '', 9);
$pdf->MultiCell(46, 10, utf8_decode('Asesor'), 0, 'FJ', false);
/**
 * * Línea 1 para Cargo:
 */
$pdf->SetDrawColor(0, 0, 0);
$pdf->SetLineWidth(0.15);
$pdf->Line(35, 230, 81, 230);
/**
 * * Línea 2 para Cargo:
 */
$pdf->SetDrawColor(0, 0, 0);
$pdf->SetLineWidth(0.15);
$pdf->Line(35, 207, 81, 207);
/**
 * + Sección: Firma de entrega
 */
/**
 * * Texto: Firma de entrega
 */
$pdf->SetY(140);
$pdf->SetX(126);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Bold', '', 9);
$pdf->Write(1, utf8_decode('Firma de entrega'));

/**
 * * Botón "recibido" para firmar digitalmente
 */
$pdf->SetDrawColor(255, 0, 0);
$pdf->SetFillColor(255, 0, 0);
$pdf->Rect(119, 160, 46, 10, 'FD');
// $pdf->Link(82, 200, 46, 10, 'https://unikabienesraices.com/Canva/index.php?id=' . $idInmueble . '&document=' . $nombreDocumento);
$pdf->SetY(165);
$pdf->SetX(121);
$pdf->SetTextColor(255, 255, 255);
$pdf->SetFont('Bold', '', 10);
$pdf->Write(1, utf8_decode('Click aquí para firmar'));

/**
 * * Línea para Botón "recibido"
 */
$pdf->SetDrawColor(0, 0, 0);
$pdf->SetLineWidth(0.3);
$pdf->Line(119, 170, 165, 170);

/**
 * * Texto: Nombre:
 */
$pdf->SetY(179);
$pdf->SetX(135);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Bold', '', 9);
$pdf->Write(1, utf8_decode('Nombre:'));

/**
 * * Texto: Nombre del asesor
 */
$pdf->SetY(187);
$pdf->SetX(119);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Bold', '', 9);
$pdf->MultiCell(46, 10, utf8_decode('José Antonio Medina Martinez'), 0, 'FJ', false);
/**
 * * Línea 1 para Nombre:
 */
$pdf->SetDrawColor(0, 0, 0);
$pdf->SetLineWidth(0.15);
$pdf->Line(119, 197, 165, 197);
/**
 * * Línea 2 para Nombre:
 */
$pdf->SetDrawColor(0, 0, 0);
$pdf->SetLineWidth(0.15);
$pdf->Line(119, 207, 165, 207);
/**
 * * Texto: Cargo:
 */
$pdf->SetY(215);
$pdf->SetX(138);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Bold', '', 9);
$pdf->Write(1, utf8_decode('Cargo:'));

/**
 * * Texto: Nombre del asesor
 */
$pdf->SetY(223);
$pdf->SetX(35);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Bold', '', 9);
$pdf->MultiCell(46, 10, utf8_decode('Asesor'), 0, 'FJ', false);
/**
 * * Línea 1 para Cargo:
 */
$pdf->SetDrawColor(0, 0, 0);
$pdf->SetLineWidth(0.15);
$pdf->Line(119, 230, 165, 230);








/**
 * + Footer
 * * Línea arriba de la dirección
 */
$pdf->SetDrawColor(255, 0, 0);
$pdf->SetLineWidth(0.55);
$pdf->Line(22, 255, 190, 255);
/**
 * + Footer
 * * Dirección de la oficina a cargo
 */
$pdf->SetY(258);
$pdf->SetX(32);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Bold', '', 9);
$pdf->Write(1, utf8_decode('Heriberto Frías 1149 Ofna 1, Col. Del Valle, CDMX // unikacdmx@gmail.com // Tel 56828888'));



/**
 * * Dirección de la oficina a cargo
 */
$pdf->SetY(258);
$pdf->SetX(32);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Bold', '', 9);
$pdf->Write(1, utf8_decode('Heriberto Frías 1149 Ofna 1, Col. Del Valle, CDMX // unikacdmx@gmail.com // Tel 56828888'));
// $queryInsertarEnTablaTemporal = "INSERT INTO informaciontemporaldocumentosoficiales (NombreCliente, Domicilio, Telefono, RFC, Correo, idInmueble_InformacionTemporalDocumentosOficiales, NombreDocumento) VALUES ('$nombrePrivacidad', '$domicilioPrivacidad', '$telefonoPrivacidad', '$rfcPrivacidad', '$emailPrivacidad', $idInmueble, '$nombreDocumento')";
// mysqli_query($db, $queryInsertarEnTablaTemporal);
$name = $pdf->SetTitle('aceptacionSeguimientoCompraVenta.pdf');
$pdf->Output('I', 'aceptacionSeguimientoCompraVenta.pdf');
