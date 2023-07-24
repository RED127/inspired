<?php
require_once 'PHPExcel/PHPExcel.php';
require_once 'config.php';
require_once 'functions.php';

$objPHPExcel = new PHPExcel();
$objPHPExcel->setActiveSheetIndex(0);
$dayData = $_POST['day'];
$nightData = $_POST['night'];
ini_set('memory_limit', '-1');

$fileName = date("Y-m-d_h-m-s") . ".xlsx";
//Make table headers
$objPHPExcel->getActiveSheet()
    ->setCellValue('A1', 'Cont')
    ->setCellValue('B1', 'Mod')
    ->setCellValue('C1', 'Boxes')
    ->setCellValue('D1', 'Counter')
    ->setCellValue('E1', 'LIVE BUILD')
    ->setCellValue('F1', 'Load Confirm')
    ->setCellValue('G1', 'S/Fill Start')
    ->setCellValue('H1', 'S/Fill Finish')
    ->setCellValue('K1', 'Cont')
    ->setCellValue('L1', 'Mod')
    ->setCellValue('M1', 'Boxes')
    ->setCellValue('N1', 'Counter')
    ->setCellValue('O1', 'LIVE BUILD')
    ->setCellValue('P1', 'Load Confirm')
    ->setCellValue('Q1', 'S/Fill Start')
    ->setCellValue('R1', 'S/Fill Finish');

if (count($dayData)) {
    $i = 2;
    foreach ($dayData as $row) {
        if ($i % 2 == 0) {
            $objPHPExcel->getActiveSheet()
                ->mergeCells('D' . $i . ':D' . ($i + 1))
                ->mergeCells('E' . $i . ':E' . ($i + 1))
                ->mergeCells('F' . $i . ':F' . ($i + 1))
                ->mergeCells('G' . $i . ':G' . ($i + 1))
                ->mergeCells('H' . $i . ':H' . ($i + 1));

            $objPHPExcel->getActiveSheet()
                ->setCellValue('A' . $i, $row[0])
                ->setCellValue('B' . $i, $row[1])
                ->setCellValue('C' . $i, $row[2])
                ->setCellValue('D' . $i, $row[3])
                ->setCellValue('E' . $i, $row[4])
                ->setCellValue('F' . $i, $row[5])
                ->setCellValue('G' . $i, str_replace('Select User', '', $row[6]))
                ->setCellValue('H' . $i, str_replace('Select User', '', $row[7]));
        } else {
            $objPHPExcel->getActiveSheet()
                ->setCellValue('A' . $i, $row[0])
                ->setCellValue('B' . $i, $row[1])
                ->setCellValue('C' . $i, $row[2]);
        }
        $i++;
    }
}

if (count($nightData)) {
    $i = 2;
    foreach ($nightData as $row) {
        if ($i % 2 == 0) {
            $objPHPExcel->getActiveSheet()
                ->mergeCells('N' . $i . ':N' . ($i + 1))
                ->mergeCells('O' . $i . ':O' . ($i + 1))
                ->mergeCells('P' . $i . ':P' . ($i + 1))
                ->mergeCells('Q' . $i . ':Q' . ($i + 1))
                ->mergeCells('R' . $i . ':R' . ($i + 1));
            $objPHPExcel->getActiveSheet()
                ->setCellValue('K' . $i, $row[0])
                ->setCellValue('L' . $i, $row[1])
                ->setCellValue('M' . $i, $row[2])
                ->setCellValue('N' . $i, $row[3])
                ->setCellValue('O' . $i, $row[4])
                ->setCellValue('P' . $i, $row[5])
                ->setCellValue('Q' . $i, str_replace('Select User', '', $row[6]))
                ->setCellValue('R' . $i, str_replace('Select User', '', $row[7]));
        } else {
            $objPHPExcel->getActiveSheet()
                ->setCellValue('K' . $i, $row[0])
                ->setCellValue('L' . $i, $row[1])
                ->setCellValue('M' . $i, $row[2]);
        }
        $i++;
    }
}

$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(25);
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(25);
$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(20);

$objPHPExcel->getActiveSheet()->getStyle('A1:H1')->applyFromArray(
    array(
        'font' => array(
            'bold' => true
        )
    )
);

$objPHPExcel->getActiveSheet()->getStyle('K1:R1')->applyFromArray(
    array(
        'font' => array(
            'bold' => true
        )
    )
);

$objPHPExcel->getActiveSheet()->setTitle("System Fill");

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Type: application/vnd.ms-excel; charset=utf-8');
header('Pragma: public');
header('Content-Disposition: attachment;filename="' . $fileName . '"');
header('Cache-Control: max-age=0');
header("Content-Type: application/force-download");
header("Content-Type: application/download");
$objWriter->save($fileName);
echo $fileName;
return;
