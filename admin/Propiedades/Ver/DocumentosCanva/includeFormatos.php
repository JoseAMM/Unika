<?php
$db = mysqli_connect('localhost', 'root', '', 'bienes_raices');
//$db = mysqli_connect('localhost', 'unikabie_admin', 'Ivan1975*', 'unikabie_bienesraices');
include_once('../../../../Reportes_PDF/fpdf.php');
include_once('./force_justify.php');
include_once('../../../../Cantidades/vendor/autoload.php');

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

function nuevaPagina()
{
    global $pdf;
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
}
