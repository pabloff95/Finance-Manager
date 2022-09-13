<?php

    require $_SERVER['DOCUMENT_ROOT'] . "/finances/models/modelOverview.php";    

    // ------------------ FUNCTIONS -------------------------
    /* Function to print title of main section, controlled by $_GET['time']:
            - period --> from to date
            - month --> specific month of a year
            - year --> specific year
            - not setted --> default value --> all gathered data
    */
    function mainTitle(){
        if (isset($_GET['time'])){
            switch($_GET['time']){
                case "period":
                    echo "<h1>Data from ". $_POST['fromDate']." to ". $_POST['toDate']."</h1>";
                    break;
                case "month":
                    echo "<h1>Data of ". $_POST['selectedMonth']." ". $_POST['selectedYear']."</h1>";
                    break;
                case "year":
                    echo "<h1>Data of the year ". $_POST['displayYear']."</h1>";
                    break;
            }
        } else {
            echo "<h1>All recorded data</h1>";
        }
    }


    // -------- FUNCTIONS TO GET THE DATA FROM A SPECIFIC TIME PERIOD --------

    // Function to determine the period, according to the time selected by the user (controlled throug $_GET['time'])
    function getPeriod(){
        if (isset($_GET['time']) && $_GET['time'] == "year"){
            $from = $_POST['displayYear']."-01-01";
            $to = $_POST['displayYear']."-12-31";
            return array($from, $to);    
        } else if(isset($_GET['time']) && $_GET['time'] == "month"){        
            $from = $_POST['selectedYear']."-".getMonthValue($_POST['selectedMonth'])."-01";
            $to = $_POST['selectedYear']."-".getMonthValue($_POST['selectedMonth'])."-31";
            return array($from, $to);
        }  else if(isset($_GET['time']) && $_GET['time'] == "period"){        
            $from = $_POST['fromDate'];
            $to = $_POST['toDate'];  
            return array($from, $to);      
        } else {
            return false; // if no period has been established
        }
    }

    // Get month value according to month name
    function getMonthValue($month){
        switch ($month){
            case "January":
                return "01";
            case "February":
                return "02";
            case "March":
                return "03";
            case "April": 
                return "04";
            case "May": 
                return "05";
            case "June":
                return "06";
            case "July":
                return "07";
            case "August":
                return "08";
            case "September":
                return "09";
            case "October":
                return "10";
            case "November":
                return "11";
            case"December":
                return "12";
        }
    }

    // -----------------------------------------------------------------------

    // ------- GET TOTAL AMOUNT (SUM OF AMOUNTS) FROM DATA IN DB -----
    function getTotalAmount($table){
        if (!isset($_GET['time'])){ // No time period specified
            $DBdata = getData($table);
        } else {
            $dates = getPeriod(); // Time period specified
            $DBdata = getRecordsToDate($table, $dates[0], $dates[1]);
        }
        $totalAmount = 0;
        while ($row = mysqli_fetch_assoc($DBdata)){
            $totalAmount = $totalAmount + $row['amount'];
        }
        return $totalAmount;        
    }

    // ------------------------------ CREATE JSON OBJECTS BY PHP ARRAYS ----------------

    // Prepare JSON object to send data for graphic of Total Data in DB
    function arrayTotalValues(){
        // Define values
        $totalIncome = getTotalAmount("income");
        $totalExpenses = getTotalAmount("expenses");
        $totalInvestment = getTotalAmount("investment");
        $totalSaved = $totalIncome - $totalExpenses - $totalInvestment;
        if ($totalSaved < 0 ) {$totalSaved = 0;}
        // Get percentages
        if ($totalIncome > 0){
            $savedPercentage = ($totalSaved / $totalIncome)*100;
            $expensesPercentage = ($totalExpenses / $totalIncome)*100;
            $investmentPercentage = ($totalInvestment / $totalIncome)*100;
        } else {
            $savedPercentage = 0;
            $expensesPercentage = 0;
            $investmentPercentage = 0;
        }
        
        // Create arrays to send to JS: label with concept, y with % value, money with total amount, legenText with the text to be displayed in the legend
        $totalData = array(
            array("label" => "Expenses", 
                    "y" => round($expensesPercentage,2),
                    "money" => moneyFormat($totalExpenses) . "€",
                    "legendText" => "Expended " . moneyFormat($totalExpenses) . "€"
            ),
            array("label" => "Savings", 
                    "y" => round($savedPercentage,2),
                    "money" => moneyFormat($totalSaved) . "€",
                    "legendText" => "Saved " . moneyFormat($totalSaved) . "€"
            ),
            array("label" => "Investments", 
                    "y" => round($investmentPercentage,2),
                    "money" => moneyFormat($totalInvestment) . "€",
                    "legendText" => "Invested " . moneyFormat($totalInvestment) . "€"
            )
        );
        return $totalData;
    }

    // Prepare JSON object to send data for graphic usign expenses per category
    function arrayExpenses(){
        // Define variables
        $categories = getCategories("expenses"); // distinct categories
        $totalExpenses = getTotalAmount("expenses"); // total amount of expenses
        $categoryExpensesData = array(); // array to store all the required data
        // loop through every distinct category and then gather the total amount of each of them
        while ($row = mysqli_fetch_assoc($categories)){
            $category = $row["category"];

            // Get total amount (€) per category
            if (!isset($_GET['time'])) { // No period specified
                $amountCategory = mysqli_fetch_assoc(getCategoryAmount($category, "expenses"))['amount']; 
            } else { // Period specified
                $dates = getPeriod(); 
                $amountCategory = mysqli_fetch_assoc(getCategoryAmountPeriod($category, "expenses", $dates[0], $dates[1]))['amount']; // total amount (€) per category
            }
            
            $percentageExpensesCategory = ($amountCategory / $totalExpenses) * 100; // percentage of this amount compared to all the expenses
            // Set array to be send as JSON object for canvas.js graph
            $categoryArray = array("label" => $category, 
                            "y" => round($percentageExpensesCategory,2),
                            "money" => moneyFormat($amountCategory) . "€",
                            "legendText" => $category. " " . moneyFormat($amountCategory) . "€");
            array_push($categoryExpensesData, $categoryArray);
        }
        return $categoryExpensesData;
    }

    // Prepare JSON object to send data for graphic usign expenses per category
    function arrayIncome(){
        // Define variables
        $categories = getCategories("income"); // distinct categories
        $totalExpenses = getTotalAmount("income"); // total amount of income
        $categoryExpensesData = array(); // array to store all the required data
        // loop through every distinct category and then gather the total amount of each of them
        while ($row = mysqli_fetch_assoc($categories)){
            $category = $row["category"];

            // Get total amount (€) per category
            if (!isset($_GET['time'])) { // No period specified
                $amountCategory = mysqli_fetch_assoc(getCategoryAmount($category, "income"))['amount']; 
            } else { // Period specified
                $dates = getPeriod(); 
                $amountCategory = mysqli_fetch_assoc(getCategoryAmountPeriod($category, "income", $dates[0], $dates[1]))['amount']; // total amount (€) per category
            }        

            $percentageExpensesCategory = ($amountCategory / $totalExpenses) * 100; // percentage of this amount compared to all the expenses
            // Set array to be send as JSON object for canvas.js graph
            $categoryArray = array("label" => $category, 
                            "y" => round($percentageExpensesCategory,2),
                            "money" => moneyFormat($amountCategory) . "€",
                            "legendText" => $category. " " . moneyFormat($amountCategory) . "€");
            array_push($categoryExpensesData, $categoryArray);
        }
        return $categoryExpensesData;
    }
    
    // Prepare JSON object to send data for graphic of investment data in DB
    function arrayInvestment(){
        // Define values
        $categories = getCategories("investment"); // distinct categories       
        $totalExpenses = getTotalAmount("investment"); // total amount of investments
        $categoryInvestmentData = array(); // array to store all the required data
        
        // loop through every distinct category and then gather the total amount of each of them
        while ($row = mysqli_fetch_assoc($categories)){
            $category = $row["category"];
             // Get total amount (€) per category
             if (!isset($_GET['time'])) { // No period specified
                $amountCategory = mysqli_fetch_assoc(getCategoryAmount($category, "investment"))['amount']; 
            } else { // Period specified
                $dates = getPeriod(); 
                $amountCategory = mysqli_fetch_assoc(getCategoryAmountPeriod($category, "investment", $dates[0], $dates[1]))['amount']; // total amount (€) per category
            }        
            $percentageInvestmentCategory = ($amountCategory / $totalExpenses) * 100; // percentage of this amount compared to all the expenses
            // Set array to be send as JSON object for canvas.js graph
            $categoryArray = array("label" => $category, 
                            "y" => round($percentageInvestmentCategory,2),
                            "money" => moneyFormat($amountCategory) . "€",
                            "legendText" => $category. " " . moneyFormat($amountCategory) . "€");
            array_push($categoryInvestmentData, $categoryArray);
        }
        return $categoryInvestmentData;
    }
?>




















