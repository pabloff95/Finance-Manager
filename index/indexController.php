<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . "/finances/models/coreModel.php";    
    require_once $_SERVER['DOCUMENT_ROOT'] . "/finances/models/modelOverview.php";    

    // Fill data with the current month information
    function currentMonthInformation(){
        // Get first and last day of current month
        $firstDay = date('Y-m-01');
        $lastDay = date('Y-m-t');

        // Get data expenses
        $expenses = getRecordsToDate("expenses", $firstDay, $lastDay);
        $totalExpenses = 0;
        while ($row = mysqli_fetch_assoc($expenses)){
            $totalExpenses += $row['amount'];
        }

        // Get data income
        $income = getRecordsToDate("income", $firstDay, $lastDay);
        $totalIncome = 0;
        while ($row = mysqli_fetch_assoc($income)){
            $totalIncome += $row['amount'];
        }

        // Get data investments
        $investments = getRecordsToDate("investment", $firstDay, $lastDay);
        $totalInvestment = 0;
        while ($row = mysqli_fetch_assoc($investments)){
            $totalInvestment += $row['amount'];
        }

        // Calculate saved
        $totalSaved = $totalIncome - $totalExpenses - $totalInvestment;

        // Print information
        echo "<p><b>Income: </b>" . $totalIncome. "€</p>";
        echo "<p><b>Investments: </b>" . $totalInvestment. "€</p>";
        echo "<p><b>Expenses: </b>" . $totalExpenses. "€</p>";
        if ($totalSaved > 0) {
            echo "<p><b>Saved: </b>" . $totalSaved. "€</p>";
        } else {
            echo "<p><b>Saved: </b><div style='background-color:red;'>" . $totalSaved. "€</div></p>";
        }
        
    }

    // Get current month as text
    function currentMonth(){
        echo "<h1>". strtoupper(date('F'))."</h1>";
    }
?>