<?php

// $_GET[''];
ob_end_clean();
require('../../../Reportes_PDF/fpdf.php');


function pdf($idInmueble, $foto1, $operacion, $precio ,$inmueble, $disponible, $habitaciones, $estacionamiento, $contrato, $superficie_construccion, $superficie_terreno, $colonia, $codigoPostal, $otras, $download, $share, $print, $documentos ){
    

    if($disponible == 1){

        $disponible = "Disponible";
    } else {
        $disponible = "No Disponible";
    }

    class PDF extends FPDF
    {
    // Cabecera de página
    function Header()
    {
        // Logo
        $this->Image('../../../Assets/logo.png',75,13,50);
    }



    // Pie de página
    function Footer()
    {
        // Posición: a 1,5 cm del final
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial','I',8);
        // Número de página
        $this->Cell(0,10,utf8_decode('Página ').$this->PageNo(), 0,0,'C');
    }
    }
    $pdf = new PDF();
    $pdf->AddPage();


    $pdf->Image('../../../admin/Propiedades/Imagenes/'.$foto1,10,45,150);

    // Colores de los bordes, fondo y texto
    $pdf->SetDrawColor(255,0,0);
    // Colores de los bordes, fondo y texto
    $pdf->SetFillColor(255,0,0);
    $pdf->SetY(142);
    $pdf->Cell(100,40,'',1,2,'C',true);
    $pdf->SetY(152);
    $pdf->SetX(15);
    $pdf->SetFont('Arial','B',28);
    $pdf->SetTextColor(255,255,255);
    $pdf->Write(1, utf8_decode( $operacion));
    $pdf->SetY(170);
    $pdf->SetX(15);
    $pdf->SetFont('Arial','',28);
    $pdf->Write(1, utf8_decode('$'.$precio));
    $pdf->SetDrawColor(255,0,0);
    // Colores de los bordes, fondo y texto
    $pdf->SetFillColor(255,0,0);
    $pdf->SetY(142);
    $pdf->SetX(115);
    $pdf->Cell(85,20,'',1,2,'C',true);
    $pdf->SetY(152);
    $pdf->SetX(120);
    $pdf->SetFont('Arial','B',23);
    $pdf->Write(1, utf8_decode('Características: '));
    $pdf->SetY(170);
    $pdf->SetX(117);
    $pdf->SetFont('Arial','B',13);
    $pdf->SetTextColor(0,0,0);
    $pdf->Write(1, utf8_decode('Tipo de Propiedad: '));
    $pdf->SetY(180);
    $pdf->SetX(117);
    $pdf->SetFont('Arial','',13);
    $pdf->Write(1, utf8_decode($inmueble));
    $pdf->SetY(190);
    $pdf->SetX(117);
    $pdf->SetFont('Arial','B',13);
    $pdf->Write(1, utf8_decode('Estado:'));
    $pdf->SetY(190);
    $pdf->SetX(136);
    $pdf->SetFont('Arial','',13);
    $pdf->Write(1, utf8_decode($disponible));
    $pdf->SetY(200);
    $pdf->SetX(117);
    $pdf->SetFont('Arial','B',13);
    $pdf->Write(1, utf8_decode('Habitaciones:'));
    $pdf->SetY(200);
    $pdf->SetX(149);
    $pdf->SetFont('Arial','',13);
    $pdf->Write(1, utf8_decode($habitaciones));
    $pdf->SetY(210);
    $pdf->SetX(117);
    $pdf->SetFont('Arial','B',13);
    $pdf->Write(1, utf8_decode('Estacionamiento: '));
    $pdf->SetY(210);
    $pdf->SetX(157);
    $pdf->SetFont('Arial','',13);
    $pdf->Write(1, utf8_decode($habitaciones));
    $pdf->SetY(220);
    $pdf->SetX(117);
    $pdf->SetFont('Arial','B',13);
    $pdf->Write(1, utf8_decode('Contrato: '));
    $pdf->SetY(220);
    $pdf->SetX(140);
    $pdf->SetFont('Arial','',13);
    $pdf->Write(1, utf8_decode($contrato));
    $pdf->SetY(230);
    $pdf->SetX(117);
    $pdf->SetFont('Arial','B',13);
    $pdf->Write(1, utf8_decode('Sup. Construcción: '));
    $pdf->SetY(230);
    $pdf->SetX(161);
    $pdf->SetFont('Arial','',13);
    $pdf->Write(1, utf8_decode($superficie_construccion).' m2');
    $pdf->SetY(240);
    $pdf->SetX(117);
    $pdf->SetFont('Arial','B',13);
    $pdf->Write(1, utf8_decode('Sup. Terreno: '));
    $pdf->SetY(240);
    $pdf->SetX(149);
    $pdf->SetFont('Arial','',13);
    $pdf->Write(1, utf8_decode($superficie_terreno).' m2');
    $pdf->SetTextColor(0,0,0);
    $pdf->SetY(192);
    $pdf->SetX(13);
    $pdf->SetFont('Arial','B',13);
    $pdf->Write(1, utf8_decode('Colonia: '));
    $pdf->SetY(192);
    $pdf->SetX(33);
    $pdf->SetFont('Arial','',13);
    $pdf->Write(1, utf8_decode($colonia));
    $pdf->SetY(202);
    $pdf->SetX(13);
    $pdf->SetFont('Arial','B',13);
    $pdf->Write(1, utf8_decode('Código Postal: '));
    $pdf->SetY(202);
    $pdf->SetX(47);
    $pdf->SetFont('Arial','',13);
    $pdf->Write(1, utf8_decode($codigoPostal));
    $pdf->SetY(212);
    $pdf->SetX(13);
    $pdf->SetFont('Arial','',10);
    $pdf->MultiCell(90, 5,utf8_decode($otras));

    
    $name = $pdf->SetTitle($idInmueble.'reporte.pdf');
    


    if($download == 1){
        $pdf->Output('D', $idInmueble.'reporte.pdf');
    }

    if($print == 1 or $share == 1){
        $pdf->Output();
    }

}



