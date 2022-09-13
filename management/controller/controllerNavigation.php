<?php
    // Define global variables
    $records_per_page = 10;    // Number of records displayed per page
    // Function(s) to define the URL of the nav buttons: +1 or -1
    function getURLForward(){
        if ($_GET['data'] == "categories_expenses") { // when managing categories --> table is not exactly equal to $_GET['data']
            $data = getUniqueCategories("expenses"); // Query returns unique categories count
        } else if ($_GET['data'] == "categories_income") { // when managing categories --> table is not exactly equal to $_GET['data']
            $data = getUniqueCategories("income"); // Query returns unique categories count
        } else {
            $data = getAllData($_GET['data']); // Query returns all record count in table
        }        
        // Define next value in $_GET['page'] (not allowing more pages than the number of recors in DB / records per page)
        $rows = $data->num_rows; // number of rows in DB
        if ($GLOBALS['records_per_page'] * $_GET['page'] >= $rows) { // Pages out of range
            $page = $_GET['page'];              
        } else {
            $page = $_GET['page'] + 1;          
        }        
        $url = "/finances/management/management.php?data=" . $_GET['data'] . "&page=" . $page;
        echo $url;
    }
    function getURLBackward(){
        $page = $_GET['page'] - 1;          
        if ($page < 1) { // not possible <1
            $page = 1;
        }
        $url = "/finances/management/management.php?data=" . $_GET['data'] . "&page=" . $page;
        echo $url;
    }

    // Get query limit  
    function getLimit(){
        echo $_GET['page'];
    }
    
    // Define limits to fill record table (number of records per page)
    function getLimits(){
        // Get data
        $page = $_GET['page'];
        //  Define limit
        $upperLimit = $page * $GLOBALS['records_per_page'];
        $lowLimit = $upperLimit - $GLOBALS['records_per_page'];
        return array(
            "lowerLimit" => $lowLimit,
            "upperLimit" => $upperLimit
        );
    }
?>