<?php
include "functions.php";
ConectarDB();

require 'vendor/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\Writer\Csv;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;

    $file_ext_name = "xlsx";
    $fileName = "depositos_reporte";

    $student = "SELECT * FROM depositos";
    $sql2 = "SELECT SUM(Valor) as totaldepositos FROM depositos";
    $query_run = mysqli_query(ConectarDB(), $student);
    if(mysqli_num_rows($query_run) > 0)
    {
    
         if($resultadosumaventas = ConectarDB()->query($sql2)){
            while($row = $resultadosumaventas->fetch_assoc()){
                $totaldepositos = $row["totaldepositos"];
            }
         }
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'Id');
        $sheet->setCellValue('B1', 'Descripción');
        $sheet->setCellValue('C1', 'Depositante');
        $sheet->setCellValue('D1', 'Codigo Referencia');
        $sheet->setCellValue('E1', 'Valor');
        $sheet->setCellValue('F1', 'Fecha Deposito');
        $sheet->setCellValue('G1', 'Hora Deposito');
        $sheet->setCellValue('H1', 'Banco');
        $sheet->setCellValue('I1', 'Sucursal');
        $sheet->setCellValue('J22', 'Total Depositos');

        $rowCount = 2;
        foreach($query_run as $data)
        {

            $columnIndex = 'A';
            foreach ($sheet->getColumnIterator($columnIndex) as $column) {
                $columnIndex = $column->getColumnIndex();
                $maxWidth = 0;
                    foreach ($column->getCellIterator() as $cell) {
                        $text = $cell->getValue();
                        $width = mb_strlen($text, 'UTF-8');
                        $maxWidth = max($maxWidth, $width);

                        $spreadsheet->getActiveSheet()->getColumnDimension($columnIndex)->setWidth($maxWidth+1);
                    
              
             }


          
        }
            $sheet->setCellValue('A'.$rowCount, $data['Id']);
            $sheet->setCellValue('B'.$rowCount, $data['Descripcion']);
            $sheet->setCellValue('C'.$rowCount, $data['Depositante']);
            $sheet->setCellValue('D'.$rowCount, $data['Codigo_Ref']);
            $sheet->setCellValue('E'.$rowCount, "L. ".number_format($data['Valor'],0));
            $sheet->setCellValue('F'.$rowCount, fechaEs($data['Fecha_Deposito']));
            $sheet->setCellValue('G'.$rowCount, $data['Hora_Deposito']);
            $sheet->setCellValue('H'.$rowCount, $data['Banco']);
            $sheet->setCellValue('I'.$rowCount, $data['Sucursal']);
            $sheet->setCellValue('K22', "L. ".number_format($totaldepositos,0));
            $rowCount++;

            $styleArray = array(
                'font'  => array(
                     'bold'  => true,
                     'color' => array('rgb' => '0,0,0'),
                     'size'  => 15,
                     'name'  => 'Comic Sans',
                     
                 ));   
    
                
                 
    
              $spreadsheet->getDefaultStyle()
                 ->applyFromArray($styleArray);
                 $spreadsheet
                 ->getActiveSheet()
                 ->getStyle("A1".":I".$rowCount)
                 ->getBorders()
                 ->getHorizontal()
                 ->setBorderStyle(Border::BORDER_THICK)
                 ->setColor(new Color('00000'));
          
        }



          
 
      
       $FechaHoy = fechaEs(date("Y-m-d"));
       $FechaNew = str_replace(" ", "_", $FechaHoy);
        if($file_ext_name == 'xlsx')
        {
            $writer = new Xlsx($spreadsheet);
            $final_filename = $fileName.'_'.$FechaNew.'.xlsx';
        }
        elseif($file_ext_name == 'xls')
        {
            $writer = new Xls($spreadsheet);
            $final_filename = $fileName.'.xls';
        }
        elseif($file_ext_name == 'csv')
        {
            $writer = new Csv($spreadsheet);
            $final_filename = $fileName.'.csv';
        }

        // $writer->save($final_filename);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attactment; filename="'.urlencode($final_filename).'"');
        $writer->save('php://output');

    }
    else
    {
        $_SESSION['message'] = "No Record Found";
        header('Location: reportes_depositos_admin.php');
        exit(0);
    }


    ?>