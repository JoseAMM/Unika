<?php
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\SpreadSheet;
use \PhpOffice\PhpSpreadsheet\IOFactory;

$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();


if(isset($_POST['excel']) == NULL){
    header('Location: index.php');
}
$queryExcel = $_POST['excel'];

//Conexión a la base de datos
$db = mysqli_connect('localhost', 'root', '', 'bienes_raices');

$resultadoExcel = mysqli_query($db, $queryExcel);


$file = "Reporte.xlsx";
$spreadsheet = $reader->load($file);
$spreadsheet->setActiveSheetIndex(0);
$hojaActiva = $spreadsheet->getActiveSheet();
$i = 6;

    while($row = $resultadoExcel->fetch_assoc()){
        $hojaActiva->setCellValue('A'.$i, $row['idInmueble']);
        $hojaActiva->setCellValue('C'.$i, $row['Nombre_Apellido']);
        $hojaActiva->setCellValue('D'.$i, $row['Direccion']);
        $hojaActiva->setCellValue('E'.$i, '$'.$row['Precio']);
        $hojaActiva->setCellValue('F'.$i, $row['Superficie_Terreno'] . ' m2'); 
        $hojaActiva->setCellValue('G'.$i, $row['Superficie_Construccion']. ' m2'); 
        $hojaActiva->setCellValue('H'.$i, $row['Descripcion']); 
        $hojaActiva->setCellValue('J'.$i, $row['Nombre_Contrato']);
        $i++;
    }



// $writer = new Xlsx($spreadsheet);
// $writer->save('Mi excel.xlsx');

$fecha = 'prueba';
$content = 'Content-Disposition: attachment;filename=' . "$fecha" . '.xlsx"';
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header("$content");
header('Cache-Control: max-age=0');
$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
$writer->save('php://output');

