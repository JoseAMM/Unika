<?php
// $db = mysqli_connect('localhost', 'root', '', 'bienes_raices');
$db = mysqli_connect('localhost', 'unikabie_admin', 'Ivan1975*', 'unikabie_bienesraices');
ob_end_clean();
require_once('../../../Reportes_PDF/fpdf.php');

//Conexión a la base de datos

// $db = conectarDB();





function pdf(
    $idInmueble,
    $consultaFotos,
    $operacion,
    $precio,
    $inmueble,
    $disponible,
    $habitaciones,
    $estacionamiento,
    $bano,
    $descripcion,
    $contrato,
    $superficie_construccion,
    $superficie_terreno,
    $colonia,
    $codigoPostal,
    $download,
    $share,
    $print,
    $documentos
) {



    global $db;

    if ($disponible == 1) {

        $disponible = "Disponible";
    } else {
        $disponible = "No Disponible";
    }
    if ($bano == NULL) {
        $bano = 0;
    }

    if ($habitaciones == NULL) {
        $habitaciones = 0;
    }

    if ($estacionamiento == NULL) {
        $estacionamiento = 0;
    }

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
    $pdf = new PDF();
    $pdf->AddPage('L');
    $pdf->AddFont('Regular', '', 'Montserrat-Regular.php');
    $pdf->AddFont('Bold', '', 'Montserrat-Bold.php');
    $pdf->AddFont('Black', '', 'Montserrat-Black.php');

    $i = 1;

    while ($row = mysqli_fetch_assoc($consultaFotos)) {
        // switch($i){
        //     case 1:

        // }
        $pdf->Image('../Imagenes/' . $row['NombreFotos'], 135, 35, 160, 80);
        $pdf->Image('../Imagenes/' . $row['NombreFotos'], 135, 116, 50, 50);
        $pdf->Image('../Imagenes/' . $row['NombreFotos'], 190, 116, 50, 50);
        $pdf->Image('../Imagenes/' . $row['NombreFotos'], 245, 116, 50, 50);
        // $pdf->Image('../Imagenes/' . $row['NombreFotos'], 10, 100, 50, 25);

    }



    // Colores de los bordes, fondo y texto
    $pdf->SetDrawColor(190, 190, 190);
    // Colores de los bordes, fondo y texto
    $pdf->SetFillColor(255, 255, 255);
    $pdf->SetTextColor(255, 0, 0);
    // $pdf->Image('../../../Assets/logo.png', 50, 175, 43, 20);
    $pdf->Image('../../../Assets/logo.png', 50, 5, 43, 20);
    $pdf->SetY(175);
    $pdf->SetX(8);
    $pdf->SetFont('Black', '', 40);
    $pdf->Write(1, utf8_decode($operacion));
    $pdf->SetY(178);
    $pdf->SetX(180);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetFont('Black', '', 40);
    $pdf->Write(1, '$'. utf8_decode($precio));
    $pdf->SetY(10);
    $pdf->SetX(135);
    $pdf->SetTextColor(255, 0, 0);
    $pdf->SetFont('Bold', '', 20);
    $pdf->Write(1, utf8_decode($inmueble));
    $pdf->Image('../../../Assets/Icon Amenities/SVG/locacion.png', 270, 5, 20, 20);
    $pdf->SetY(20);
    $pdf->SetX(135);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetFont('Bold', '', 16);
    $pdf->Write(1, utf8_decode($colonia));
    $pdf->SetY(35);
    $pdf->Cell(120, 131, '', 1, 2, 'C', true);
    $pdf->SetY(45);
    $pdf->SetX(12);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetFont('Bold', '', 35);
    $pdf->Write(1, utf8_decode('Características'));
    $pdf->Image('../../../Assets/Icon Amenities/Sup.Terreno.png', 15, 60, 10, 10);
    $pdf->SetY(65);
    $pdf->SetX(30);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetFont('Bold', '', 35);
    $pdf->Write(1, utf8_decode($superficie_terreno) . ' m2');
    $pdf->Image('../../../Assets/Icon Amenities/Sup.Construccion.png', 15, 79, 6, 6);
    $pdf->SetY(82);
    $pdf->SetX(22);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetFont('Regular', '', 15);
    $pdf->Write(1, utf8_decode($superficie_construccion) . ' m2');
    $pdf->Image('../../../Assets/Icon Amenities/Habitacion.png', 70, 80, 7, 5);
    $pdf->SetY(82);
    $pdf->SetX(80);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetFont('Regular', '', 15);
    $pdf->Write(1, utf8_decode($habitaciones));
    $pdf->Image('../../../Assets/Icon Amenities/Bano.png', 90, 80, 7, 5);
    $pdf->SetY(82);
    $pdf->SetX(100);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetFont('Regular', '', 15);
    $pdf->Write(1, $bano);
    $pdf->Image('../../../Assets/Icon Amenities/Estacionamiento.png', 110, 80, 7, 5);
    $pdf->SetY(82);
    $pdf->SetX(120);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetFont('Regular', '', 15);
    $pdf->Write(1, $estacionamiento);
    $pdf->SetY(92);
    $pdf->SetX(15);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetFont('Bold', '', 15);
    $pdf->Write(1, utf8_decode('Otras Características: '));

    $pdf->SetY(120);
    $pdf->SetX(15);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetFont('Regular', '', 7);
    $pdf->MultiCell(100, 5, $descripcion);
    

    $consultaAmenidades = "SELECT otras_caracteristicas.idAmenidades, 
    NombreAmenidades
    FROM otras_caracteristicas
    INNER JOIN amenidades ON otras_caracteristicas.idAmenidades = amenidades.idAmenidades WHERE id_Inmueble = $idInmueble";
    $consultaAmenidades = mysqli_query($db, $consultaAmenidades);
    $y = 100;
    $x = 15;
    $i = 1;

    while ($row = mysqli_fetch_assoc($consultaAmenidades)) {

        if ($i == 11){
            $y = 110;
            $x = 15;
        }





        switch ($row['idAmenidades']) {
            case 1:
                $pdf->Image('../../../Assets/Icon Amenities/Alberca.png', $x, $y, 7, 7);
                $i++;
                break;
            case 3:
                $pdf->Image('../../../Assets/Icon Amenities/AireAcondicionado.png', $x, $y, 7, 7);
                $i++;
                break;
            case 5:
                $pdf->Image('../../../Assets/Icon Amenities/Gimnasio.png', $x, $y + 1, 7, 5);
                $i++;
                break;
            case 6:
                $pdf->Image('../../../Assets/Icon Amenities/Bar.png', $x, $y, 7, 7);
                $i++;
                break;
            case 7:
                $pdf->Image('../../../Assets/Icon Amenities/Camaras.png', $x, $y, 7, 7);
                $i++;
                break;
            case 8:
                $pdf->Image('../../../Assets/Icon Amenities/Comedor.png', $x, $y, 7, 7);
                $i++;
                break;
            case 9:
                $pdf->Image('../../../Assets/Icon Amenities/Jardin.png', $x, $y, 7, 7);
                $i++;
                break;
            case 11:
                $pdf->Image('../../../Assets/Icon Amenities/Hidromasaje.png', $x, $y, 7, 7);
                $i++;
                break;
            case 12:
                $pdf->Image('../../../Assets/Icon Amenities/Karaoke.png', $x + 1 , $y, 4, 7);
                $i++;
                break;
            case 13:
                $pdf->Image('../../../Assets/Icon Amenities/Portero.png', $x, $y, 7, 7);
                $i++;
                break;
            case 14:
                $pdf->Image('../../../Assets/Icon Amenities/Satelital.png', $x, $y, 7, 7);
                $i++;
                break;
            case 16:
                $pdf->Image('../../../Assets/Icon Amenities/FreeWifi.png', $x, $y, 7, 7);
                // $i++;
                break;
        }



        $x = $x + 10;
        
    }




    $name = $pdf->SetTitle($idInmueble . 'reporte.pdf');


    if ($download == 1) {
        $pdf->Output('D', $idInmueble . 'reporte.pdf');
    }

    if ($print == 1 or $share == 1) {
        $pdf->Output();
    }
}
