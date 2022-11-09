<?php
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\SpreadSheet;
use \PhpOffice\PhpSpreadsheet\IOFactory;
$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();


$file = "Reporte.xlsx";
$spreadsheet = $reader->load($file);
$spreadsheet->setActiveSheetIndex(0);




    global $spreadsheet;
    
    // $spreadsheet->getProperties()->setCreator("Unika Inmuebles")->setTitle("Fecha");
    
    
    $hojaActiva = $spreadsheet->getActiveSheet();
    $hojaActiva->setCellValue('A6', 'Prueba');
    $hojaActiva->setCellValue('B6', 'Prueba');
    
    // $writer = new Xlsx($spreadsheet);
    // $writer->save('Mi excel.xlsx');
    
    $fecha = 'prueba';
    $content = 'Content-Disposition: attachment;filename=' . "$fecha" .'.xlsx"';
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header("$content");
    header('Cache-Control: max-age=0');
    $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
    $writer->save('php://output');




// $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
// $spreadsheet = $reader->load($file);
// // $spreadsheet->getProperties()->setCreator("Unika Inmuebles")->setTitle("Fecha");

// $spreadsheet->setActiveSheetIndex(0);
// $hojaActiva = $spreadsheet->getActiveSheet();
// $hojaActiva->setCellValue('A6', 'Prueba');
// $hojaActiva->setCellValue('B6', 'Prueba');

// // $writer = new Xlsx($spreadsheet);
// // $writer->save('Mi excel.xlsx');

// $fecha = 'prueba';
// $content = 'Content-Disposition: attachment;filename=' . "$fecha" .'.xlsx"';
// header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
// header("$content");
// header('Cache-Control: max-age=0');
// $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
// $writer->save('php://output');
?>