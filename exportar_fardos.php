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
    $fileName = "fardos_reporte";

    $student = "SELECT * FROM fardos";
    $sql2 = "SELECT SUM(Total) as totalpago FROM fardos";
    $query_run = mysqli_query(ConectarDB(), $student);
    if(mysqli_num_rows($query_run) > 0)
    {
    
         if($resultadosumaventas = ConectarDB()->query($sql2)){
            while($row = $resultadosumaventas->fetch_assoc()){
                $totalpago = $row["totalpago"];
            }
         }
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'Id');
        $sheet->setCellValue('B1', 'Codigo Fardo');
        $sheet->setCellValue('C1', 'Descripción');
        $sheet->setCellValue('D1', 'Precio Fardo');
        $sheet->setCellValue('E1', 'Cantidad');
        $sheet->setCellValue('F1', 'Total');
        $sheet->setCellValue('G1', 'Cliente / Sucursal');
        $sheet->setCellValue('H1', 'Telefono');
        $sheet->setCellValue('I1', 'Dirección');
        $sheet->setCellValue('J1', 'Entregado A');
        $sheet->setCellValue('K1', 'Celular');
        $sheet->setCellValue('L1', 'Fecha');
        $sheet->setCellValue('M1', 'Hora');
        $sheet->setCellValue('N22', 'Total Fardos');

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
            $sheet->setCellValue('B'.$rowCount, $data['Codigo_Fardo']);
            $sheet->setCellValue('C'.$rowCount, $data['Descripcion']);
            $sheet->setCellValue('D'.$rowCount, "L. ".number_format($data['Precio_Fardo'],0));
            $sheet->setCellValue('E'.$rowCount, $data['Cantidad']);
            $sheet->setCellValue('F'.$rowCount, "L. ".number_format($data['Total'],0));
            $sheet->setCellValue('G'.$rowCount, $data['Cliente_Sucursal']);
            $sheet->setCellValue('H'.$rowCount, $data['Telefono']);
            $sheet->setCellValue('I'.$rowCount, $data['Direccion']);
            $sheet->setCellValue('J'.$rowCount, $data['Entregado_A']);
            $sheet->setCellValue('K'.$rowCount, $data['Celular']);
            $sheet->setCellValue('L'.$rowCount, fechaEs($data['Fecha']));
            $sheet->setCellValue('M'.$rowCount, $data['Hora']);
            $sheet->setCellValue('O22', "L. ".number_format($totalpago,0));
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
                 ->getStyle("A1".":M".$rowCount)
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
        header('Location: reporte_ventas_admin.php');
        exit(0);
    }


    ?>