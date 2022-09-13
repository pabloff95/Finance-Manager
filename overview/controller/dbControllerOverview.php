<?php

    require_once $_SERVER['DOCUMENT_ROOT'] . "/finances/models/coreModel.php";    

    // -------------------------------------------- MANAGE YEARS INFORMATION -----------------------------------------

    // Prepare navigation form to forward year in DB
    function getNavigationURLForward() {
        // Prepare variables
        $url = "overview.php?overview=" . $_GET['overview'] . "&year=";
        $years = getYears($_GET['overview']);
        $sessionYear = $_SESSION['year'];
        // Get year within the limits
        if ($sessionYear++ >= $years[0]){
            $year = $years[0];
        } else {
            do {
                $year = $sessionYear++;
            } while (!in_array($year, $years));            
        }        
        $url = $url . $year;
        echo $url;
    }

    // Prepare navigation form to previous year in DB
    function getNavigationURLBackward() {
        // Prepare variables
        $url = "overview.php?overview=" . $_GET['overview'] . "&year=";
        $years = getYears($_GET['overview']);
        $sessionYear = $_SESSION['year'];
        // Get year within the limits
        if ($sessionYear-- <= end($years)){
            $year = end($years);
        } else {
            do {
                $year = $sessionYear--;
            } while (!in_array($year, $years));   
        }        
        $url = $url . $year;
        echo $url;
    }

    // Function to update the session variable that keeps track of the year displayed
    function updateSessionYear(){
        // Get data
        $years = getYears($_GET['overview']);
        $displayedYear = $_SESSION['year'];
        // Going to next year
        if (isset($_POST['navigation']) && $_POST['navigation'] == "next") {
            if ($displayedYear >= $years[0]) { // if exceeding limit
                $displayedYear = $years[0];
            } else {
                do {
                    $displayedYear++;
                } while (!in_array($displayedYear, $years));
            }
            // Going to previous year
        } else if (isset($_POST['navigation']) && $_POST['navigation'] == "previous") {
            if ($displayedYear <= end($years)) {  // if exceeding limit
                $displayedYear = end($years);
            } else {
                do {
                    $displayedYear--;
                } while (!in_array($displayedYear, $years));
            }
        }
        // Update session variable
        $_SESSION['year'] = $displayedYear;
    }

    // Function to get the years from which there is data recorded
    function getYears($table){
        // Create arrays
        $years= array(); // Array to contain all years from which there is data available
        $uniqueYears = array(); // Array to contain the unique years from the one above

        // Check if accesing to a single report (expenses / investments / income) or all
        if ($table != "all"){
            // Get data
            $data = getAllData($table);
            // if it exists data
            while ($row = mysqli_fetch_assoc($data)){
                array_push($years, substr($row['date'], 0, 4));
            }
            // Get unique values and rearrange key - values
            $uniqueYears = array_unique($years);
            $uniqueYears = array_values($uniqueYears);
            rsort($uniqueYears); // order from more actual to older
        
        // Accessing to full report (expenses + investments + income)
        } else {
            // Get data
            $expenses = getAllData("expenses");
            $income = getAllData("income");
            $investment = getAllData("investment");
            while ($row = mysqli_fetch_assoc($expenses)){
                array_push($years, substr($row['date'], 0, 4));
            }
            while ($row = mysqli_fetch_assoc($income)){
                array_push($years, substr($row['date'], 0, 4));
            }
            while ($row = mysqli_fetch_assoc($investment)){
                array_push($years, substr($row['date'], 0, 4));
            }
            // Get unique values and order them
            $uniqueYears = array_unique($years);
            $uniqueYears = array_values($uniqueYears);
            rsort($uniqueYears); // order from more actual to older
        }       
        if (empty($uniqueYears)){
            array_push($uniqueYears, date("Y")); // show current year
        }
        return $uniqueYears;
    }

    // --------------------------------------------- FUCNTIONS TO PREPARE THE CHART-DATA -------------------------------------------------
    // Function to get an array with the information required for the charts, in format: "Month" - "€ / month"
    function getMonthlyData($table){
        // Prepare data
        $year = $_GET['year'];
        $months = array("01","02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12");
        $monthNames = array("January", "February", "March", "April", "May", "Juni", "July", "August", "September", "October", "November", "December");
        $result = array(); // Store the results "key" - "value" ("month" - "amount per month")
        // Get amount of each month 
        $i = 0; // Iterator variable
        foreach($months as $month){  
            $monthName = $monthNames[$i];
            $monthAmount = 0;
            $data = getYearlyData($table, $year); // Retrieve data of year
            while ($row = mysqli_fetch_assoc($data)){ // Read data
                $recordMonth = substr($row['date'], 5,2); // Get month of the reocrd
                if ($recordMonth == $month){                    
                    $monthAmount += $row['amount']; // "month" - "amount per month"
                }
            }
            $result[$monthName] = $monthAmount;
            $i++;
        }
        return $result;
    }

    // Function to prepare arrays for JS canvas chart
    function yearlyOverviewArray($table){
        // Get data
        $data = getMonthlyData($table);
        // Prepare array with data
        $jsCanvasData = array();
        foreach ($data as $month => $amount){
            $record = array(
                "y" => round($amount,2), 
                "label" => $month,
                "money" => moneyFormat($amount) . "€"
            );
            array_push($jsCanvasData, $record);
        }
        return $jsCanvasData;
    }

    // -----------------------------------------------------------------------------------------------------------------------------

    // Print title of the page
    function printTitle(){
        $table = $_GET['overview'];
        if ($table == "all") {
            $table = "General overview";
        }
        $table = strtoupper($table);
        // Echo title
        echo "<h1>".
            $table . 
            " - " .
            $_SESSION['year']
        ."</h1>";
    }
?>










