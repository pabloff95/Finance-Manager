<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . "/finances/models/coreModel.php";    
    require_once "vendor/autoload.php";

    // Code adapted from: https://code-boxx.com/import-excel-into-mysql-php/

    // Function to read excel file
    function importFile(){
        // Get uploaded file absolute path
        $file = $_FILES['file']['tmp_name'];
        // Load excel file from specified path
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $spreadsheet = $reader->load($file);
        // Get number of sheets in file
        $numberSheet = $spreadsheet->getSheetCount();
        // Connect to db
        $db = connectDB();
        // Insert data of each excel sheet in their respective tables
        for ($i = 0; $i < $numberSheet; $i++){
            $spreadsheet->setActiveSheetIndex($i);
            $activeSheet = $spreadsheet->getActiveSheet();
            $table = $activeSheet->getTitle(); // title of the activeSheet
            // Prepare query (investment tables contain 1 colunm more (share name))
            if ($table != "investment") {
                $sql = "INSERT INTO ". $table . " (concept, date, amount, category) VALUES (?, ?, ?, ?)";
            } else {
                $sql = "INSERT INTO ". $table . " (concept, date, amount, category, share) VALUES (?, ?, ?, ?, ?)";
            }
            // Insert all data from excel file into DB tables
            insertData($activeSheet, $sql, $db, $table);
        }
        // Close connection
        mysqli_close($db);    
    }

    // Function to insert all data from an excel file into DB table
    function insertData($sheet, $sql, $db, $table){
        $first_row = true; // Used to skip first row
        foreach ($sheet->getRowIterator() as $row) {
            if (!$first_row) { // Skip first row (titles)
                // Fetch each cell in the row
                $cellIterator = $row->getCellIterator();
                $cellIterator->setIterateOnlyExistingCells(false);
                $data = [];
                foreach ($cellIterator as $cell) { 
                    $data[] = $cell->getValue(); 
                }
                // Read correct date format
                if (strpos($data[1], "/")){
                    // if date format is like dd/mm/yyyy and transform date value to correct format (same as db: yyyy-mm-dd)
                    $date = DateTime::createFromFormat('d/m/Y', trim($data[1]))->format('Y-m-d');
                } else {
                    // If date format is as number from 1970 (excel format), transform it into Y-m-d
                    $date = date("Y-m-d", ($data[1]-25569)*86400);  
                }
                
                //$date = date("Y-m-d", ($data[1]-25569)*86400);
                // Insert row into DB
                try {
                    $sql_insert = $db->prepare($sql);   
                    // Bind params (investment tables contain 1 colunm more (share name))
                    if ($table != "investment") {
                        $sql_insert->bind_param("ssds", $data[3] , $date, $data[4], $data[2]);
                    } else {
                        $sql_insert->bind_param("ssdss", $data[3] , $date, $data[4], $data[2], $data[5]);
                    }
                    $sql_insert->execute();
                } catch (Exception $ex) { 
                    echo $ex->getMessage() . "<br>"; 
                }
                $sql_insert = null;
            } else {
                $first_row = false;
            }
        }
    }

?>