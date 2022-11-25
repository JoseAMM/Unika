<?php
// $db = mysqli_connect('localhost', 'root', '', 'bienes_raices');
$db = mysqli_connect('localhost', 'unikabie_admin', 'Ivan1975*', 'unikabie_bienesraices');

require_once('../../../Reportes_PDF/fpdf.php');







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


function avisoPrivacidad(
    $nombrePrivacidad,
    $domicilioPrivacidad,
    $telefonoPrivacidad,
    $rfcPrivacidad,
    $emailPrivacidad,
    $idInmueble,
    $nombreDocumento
) {
    class PDF extends FPDF
    {
        // Cabecera de página
        function Header()
        {
            // Logo
            // $this->Image('../../../Assets/logo.png', 75, 13, 50);
        }



        // Pie de página
        function Footer()
        {
            // Posición: a 1,5 cm del final
            $this->SetY(-15);
            // Arial italic 8
            $this->SetFont('Arial', 'I', 8);
            // Número de página
            $this->Cell(0, 10, utf8_decode('Página ') . $this->PageNo(), 0, 0, 'C');
        }
    }
    global $pdf;
    global $db;

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
    $pdf->Image('../../../Assets/logo.png', 22, 10, 60.2, 28);

    // Línea
    $pdf->SetDrawColor(255, 0, 0);
    $pdf->SetLineWidth(0.55);
    $pdf->Line(22, 41, 190, 41);

    // Texto: Aviso de Privacidad
    $pdf->SetY(50);
    $pdf->SetX(78);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetFont('Bold', '', 15);
    $pdf->Write(1, utf8_decode('Aviso de Privacidad'));

    // Línea
    $pdf->SetDrawColor(0, 0, 0);
    $pdf->SetLineWidth(0.55);
    $pdf->Line(78, 54, 135, 54);


    //Texto: Aviso de Privacidad
    $pdf->SetY(65);
    $pdf->SetX(22);
    $pdf->SetFont('Regular', '', 9);
    $pdf->MultiCell(170, 5, utf8_decode('Inmobiliaria UNIKA BIENES RAÍCES y sus asesores, con domicilio en: Heriberto Frías 1149 Ofna 1, Col. Del Valle, CDMX recabará sus datos personales, y es responsable del uso, almacenamiento y protección de estos'));

    $pdf->SetY(85);
    $pdf->SetX(22);
    $pdf->SetFont('Regular', '', 9);
    $pdf->MultiCell(170, 5, utf8_decode('Estos datos serán utilizados exclusivamente para los servicios que usted mismo o algún apoderado de
usted nos haya solicitado, y los cuales ofrecemos a todos nuestros clientes como son: compra, venta y
arrendamiento de todo tipo de inmuebles.'));

    $pdf->SetY(105);
    $pdf->SetX(22);
    $pdf->SetFont('Regular', '', 9);
    $pdf->MultiCell(170, 5, utf8_decode('Usted tiene derecho a rectificar y/o cancelar el uso de sus datos personales, además de poder revocar en
cualquier momento el uso que nos otorga para el manejo de los mismos, de acuerdo a nuestro
procedimiento para tal efecto el cual podrá serle dado a conocer por medio de la Gerencia.'));

    $pdf->SetY(125);
    $pdf->SetX(22);
    $pdf->SetFont('Regular', '', 9);
    $pdf->MultiCell(170, 5, utf8_decode('Para estar de acuerdo con nuestras leyes, este aviso de privacidad puede ser modificado en cualquier
momento, con el único fin de no contravenir nuestras leyes y/o nuevos requerimientos para ofrecer
bienes y servicios, aun así, en caso de existir alguna modificación, nos encargaremos personalmente de
dársela a conocer.'));

    $pdf->SetY(150);
    $pdf->SetX(22);
    $pdf->SetFont('Regular', '', 9);
    $pdf->MultiCell(170, 5, utf8_decode('Para poder llevar a cabo el servicio que usted nos solicita, haciendo uso de sus datos personales, es
necesario tener su autorización, mencionándole que usted nos está autorizando su uso exclusivamente
para esta operación.'));

    $pdf->SetY(173);
    $pdf->SetX(22);
    $pdf->SetFont('Bold', '', 9);
    $pdf->MultiCell(170, 5, utf8_decode('Consiento que mis datos personales sean usados conforme a lo expuesto en el presente Aviso
de Privacidad.'));

    // Texto: Autorizo
    $pdf->SetY(190);
    $pdf->SetX(98);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetFont('Bold', '', 10);
    $pdf->Write(1, utf8_decode('Autorizo'));

    // widthString('Click aquí para firmar', 10);

    // Texto: Nombre
    $pdf->SetY(200);
    $pdf->SetX(22);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetFont('Bold', '', 10);
    $pdf->Write(1, utf8_decode('Nombre del cliente: ' . $nombrePrivacidad));

    // Texto: Domicilio
    $pdf->SetY(210);
    $pdf->SetX(22);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetFont('Bold', '', 10);
    $pdf->Write(1, utf8_decode('Dirección: ' . $domicilioPrivacidad));

    // Texto: Teléfono
    $pdf->SetY(220);
    $pdf->SetX(22);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetFont('Bold', '', 10);
    $pdf->Write(1, utf8_decode('Teléfono: ' . $telefonoPrivacidad));

    // Texto: RFC
    $pdf->SetY(220);
    $pdf->SetX(104);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetFont('Bold', '', 10);
    $pdf->Write(1, utf8_decode('RFC: ' . $rfcPrivacidad));

    // Texto: Correo Electrónico
    $pdf->SetY(230);
    $pdf->SetX(22);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetFont('Bold', '', 10);
    $pdf->Write(1, utf8_decode('Correo Electrónico: ' . $emailPrivacidad));



    // Colores de los bordes, fondo y texto
    $pdf->SetDrawColor(255, 0, 0);
    // Colores de los bordes, fondo y texto
    $pdf->SetFillColor(255, 0, 0);
    // Rectángulo
    $pdf->Rect(82, 240, 46, 10, 'FD');
    $pdf->Link(82, 240, 46, 10, 'https://unikabienesraices.com/Canva/index.php?id=' . $idInmueble . '&document=' . $nombreDocumento);


    // Texto: Click aquí para firmar
    $pdf->SetY(245);
    $pdf->SetX(84);
    $pdf->SetTextColor(255, 255, 255);
    $pdf->SetFont('Bold', '', 10);
    $pdf->Write(1, utf8_decode('Click aquí para firmar'));

    // Línea
    $pdf->SetDrawColor(255, 0, 0);
    $pdf->SetLineWidth(0.55);
    $pdf->Line(22, 255, 190, 255);

    // Texto: Información Unika BR
    $pdf->SetY(258);
    $pdf->SetX(32);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetFont('Bold', '', 9);
    $pdf->Write(1, utf8_decode('Heriberto Frías 1149 Ofna 1, Col. Del Valle, CDMX // unikacdmx@gmail.com // Tel 56828888'));

    $queryInsertarEnTablaTemporal = "INSERT INTO informaciontemporaldocumentosoficiales (NombreCliente, Domicilio, Telefono, RFC, Correo, idInmueble_InformacionTemporalDocumentosOficiales) VALUES ('$nombrePrivacidad', '$domicilioPrivacidad', '$telefonoPrivacidad', '$rfcPrivacidad', '$emailPrivacidad', $idInmueble)";

    mysqli_query($db, $queryInsertarEnTablaTemporal);

    $name = $pdf->SetTitle('AvisoDePrivacidad.pdf');
    $pdf->Output('D', 'AvisoDePrivacidad.pdf');
}
