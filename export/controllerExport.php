<?php
    // https://artisansweb.net/how-to-export-mysql-database-data-to-excel-using-php/
    require_once $_SERVER['DOCUMENT_ROOT'] . "/finances/models/modelManagementIncomeCat.php";    
    // Load spreadsheet php library
    require_once "vendor/autoload.php";
  
    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

    // Function to export data from DB in .xlsx format
    function exportData(){        
        // Create spread sheet object and initializate it
        $spreadsheet = new Spreadsheet();
        $spreadsheet->setActiveSheetIndex(0);
        $activeSheet = $spreadsheet->getActiveSheet();
        $activeSheet->setTitle("expenses");
        // Fill sheet 1 with data of expenses table        
        fillTable($activeSheet, "expenses");

        // Create sheet 2 for income data
        $spreadsheet->createSheet();
        $spreadsheet->setActiveSheetIndex(1);
        $activeSheet = $spreadsheet->getActiveSheet();
        $spreadsheet->getActiveSheet()->setTitle("income");
        // Fill sheet 1 with data of income table        
        fillTable($activeSheet, "income");

        // Create sheet 3 for investment data
        $spreadsheet->createSheet();
        $spreadsheet->setActiveSheetIndex(2);
        $activeSheet = $spreadsheet->getActiveSheet();
        $spreadsheet->getActiveSheet()->setTitle("investment");
        // Fill sheet 1 with data of income table        
        fillTable($activeSheet, "investment");

        // Document settings and save
        $spreadsheet->setActiveSheetIndex(0);
        $filename = 'finances.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0');
        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        ob_end_clean();
        $writer->save('php://output');
        die();
    }

    // Fill excel table with data from DB
    function fillTable($activeSheet, $table){
        // Define titles of excel sheet headers
        $activeSheet->setCellValue('A1', 'ID');
        $activeSheet->setCellValue('B1', 'DATE');
        $activeSheet->setCellValue('C1', 'CATEGORY');
        $activeSheet->setCellValue('D1', 'CONCEPT');       
        $activeSheet->setCellValue('E1', 'AMOUNT');
        if ($table == "investment") {
            $activeSheet->setCellValue('F1', 'SHARE');
        }
        // Get data
        $data = getData($table);
        // Fill excel sheet with data from db        
        $i = 2; // Begin to fill rows from row 2
        while($row = mysqli_fetch_assoc($data)) {
            $activeSheet->setCellValue('A'.$i , $row['id']);
            $year = substr($row['date'],0,4);
            $month = substr($row['date'],5,2);
            $day = substr($row['date'],8);
            $date = $day . "/" . $month . "/" . $year;
            $activeSheet->setCellValue('B'.$i , $date);
            $activeSheet->setCellValue('C'.$i , $row['category']);
            $activeSheet->setCellValue('D'.$i , $row['concept']);           
            $activeSheet->setCellValue('E'.$i , $row['amount']);    
            if ($table == "investment") {
                $activeSheet->setCellValue('F'.$i , $row['share']);    
            }
            $i++;
        }      
    }
?>