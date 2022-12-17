<?php
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\SpreadSheet;
use \PhpOffice\PhpSpreadsheet\IOFactory;

$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();


if (isset($_POST['excel']) == NULL) {
    header('Location: index.php');
}
$queryExcel = $_POST['excel'];

//Conexión a la base de datos
// $db = mysqli_connect('localhost', 'root', '', 'bienes_raices');
$db = mysqli_connect('localhost', 'unikabie_admin', 'Ivan1975*', 'unikabie_bienesraices');

$resultadoExcel = mysqli_query($db, $queryExcel);


$file = "Reporte.xlsx";
$spreadsheet = $reader->load($file);
$spreadsheet->setActiveSheetIndex(0);
$hojaActiva = $spreadsheet->getActiveSheet();
$i = 6;

while ($row = $resultadoExcel->fetch_assoc()) {
    $hojaActiva->setCellValue('A' . $i, $row['idInmueble']);
    $hojaActiva->setCellValue('B' . $i, $row['Oficina']);
    $hojaActiva->setCellValue('C' . $i, $row['Nombre_Apellido']);
    $hojaActiva->setCellValue('D' . $i, utf8_decode($row['Direccion']));
    $hojaActiva->setCellValue('E' . $i, $row['nombre']);
    $hojaActiva->setCellValue('F' . $i, number_format($row['Precio']));
    $hojaActiva->setCellValue('G' . $i, number_format($row['Superficie_Terreno']));
    $hojaActiva->setCellValue('H' . $i, number_format($row['Superficie_Construccion']));
    $hojaActiva->setCellValue('I' . $i, $row['Descripcion']);
    $hojaActiva->setCellValue('K' . $i, $row['Nombre_Contrato']);
    $i++;
}



// $writer = new Xlsx($spreadsheet);
// $writer->save('Mi excel.xlsx');

$fecha = 'prueba';
$content = 'Content-Disposition: attachment;filename=' . "$fecha" . '.xlsx';
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header("$content");
header('Cache-Control: max-age=0');
$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
$writer->save('php://output');
