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
        while ($row = mysqli_fetch_array($income)){
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
        echo "<p><b>Income: </b>" . moneyFormat($totalIncome). "€</p>";
        echo "<p><b>Investments: </b>" . moneyFormat($totalInvestment). "€</p>";

        echo "<p><b>Expenses: </b>" . moneyFormat($totalExpenses). "€</p>";
        if ($totalSaved >= 0) {
            echo "<div class='saving-container'>
                    <p>
                        <b>Saved: </b>
                        <div style='color:green;'>" . moneyFormat($totalSaved). "€</div>
                    </p>
                </div>";
        } else {
            echo "<div class='saving-container'>
                    <p>
                        <b>Saved: </b>
                        <div style='color:red;'>" . moneyFormat($totalSaved). "€</div>
                    </p>
                </div>";
        }        
    }

    // Get current month as text
    function currentMonth(){
        echo "<p class='month-title'>". strtoupper(date('F'))."</p>";
    }
    
    // funcion to define amount (€) format: xx.xx 
    function moneyFormat($amount){
        // Check natural numbers: xx
        $strAmount = (string)$amount;
        if (ctype_digit($strAmount)){
            return ($amount . ".00");
        } else {
            $amount = round($amount,2);
            // Check normal currency numbers: xx.xx
            if (preg_match('/[0-9]*(\.[0-9]{2})$/', $amount)){
                return $amount;

            // Check only 1 decimal number: xx.x
            } else if (preg_match('/[0-9]*(\.[0-9]{1})$/', $amount)){
                return ($amount . "0");
            } else {
                return 0.00;
            }
        }
        
    }
?>