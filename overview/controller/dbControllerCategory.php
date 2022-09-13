<?php
    // Function to get data to prepare barplots
    function categoryHistoryData($category, $table, $period){
        // Determine period: yyyy-mm or yyyy --> creates limit variable to delimit substr of the date format
        if ($period == "years") {
            $limit = 4; 
        } else if ($period == "months") {
            $limit = 7;
        }
        // Get data
        $data = getCategoryData($category, $table);
        // Prepare arrays
        $dates = array(); // Will contain full date yyyy-mm-dd
        $datePeriod = array(); // Will contain only yyyy-mm or yyyy
        $amounts = array();  // Will contain the amount of each date (amount in same position as its date in $dates)
        $result = array(); // will contain the pairs key - value --> uniqueDate - amount of the date 
        // Fill arrays
        while ($row = mysqli_fetch_assoc($data)){
            array_push($dates, $row['date']);
            array_push($datePeriod, substr($row['date'], 0, $limit));
            array_push($amounts, $row['amount']);
        }
        // Get unique months per year
        $uniqueCombinations = array_unique($datePeriod);
        $uniqueCombinations = array_values($uniqueCombinations);
        //  Obtain the total amount (€) of the unique months per year (yyyy-mm) or year (yyyy)
        for ($i = 0 ; $i < count($uniqueCombinations); $i++) {
            $totalAmount = 0;
            for ($j = 0 ; $j < count($datePeriod); $j++) {
                if ($uniqueCombinations[$i] == $datePeriod[$j]){
                    $totalAmount += $amounts[$j];
                }
            }
            $result[$uniqueCombinations[$i]] = $totalAmount;
        }
        return $result;        
    }

    // Function to prepare the arrays with the data
    function categoryDataArray($category, $table, $period){
        // Get data
        $values = categoryHistoryData($category, $table, $period);
        ksort($values); // Orders array by key from lower to higher
        // Prepare array with data
        $jsCanvasData = array();
        foreach ($values as $date => $amount){
            $record = array(
                "y" => round($amount,2),
                "label" => $date, 
                "money" => moneyFormat($amount) . "€");
            array_push($jsCanvasData, $record);
        }
        return $jsCanvasData;
    }


    // Create hidden inputs with the categories from all finance elements 
    function hiddenCategories(){
        // Retrieve data
        $expenses = getAllCategories("expenses");
        $income = getAllCategories("income");
        $investment = getAllCategories("investment");
        // Prepare arrays
        $expensesCategories = "";
        $incomeCategories = "";
        $investmentCategories = "";
        // Fill arrays
        while($row = mysqli_fetch_assoc($expenses)){
            $expensesCategories .= $row['category'] . "/";
        }
        while($row = mysqli_fetch_assoc($income)){
            $incomeCategories .= $row['category'] . "/";
        }
        while($row = mysqli_fetch_assoc($investment)){
            $investmentCategories .= $row['category'] . "/";
        }
        // Create HTML elements
        echo "<input type='hidden' id='expensesCategories' value='" . $expensesCategories . "' />";
        echo "<input type='hidden' id='incomeCategories' value='" . $incomeCategories . "' />";
        echo "<input type='hidden' id='investmentCategories' value='" . $investmentCategories . "' />";
    }


?>