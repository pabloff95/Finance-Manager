<?php

    require $_SERVER['DOCUMENT_ROOT'] . "/finances/models/modelIncome.php";    
    
    // ----------------------------- EXECUTION ON LOAD -----------------


    // Insert data into DB when post has been sended
    if(isset($_POST['incomeForm'])){        
        // When using an existing category (just insert expenses data)
        if (isset($_POST['dbIncomeCategory'])) {
            insertIncome($_POST['concept'], $_POST['date'], $_POST['amount'], $_POST['dbIncomeCategory']);        
        // When using a new category (add it to the DB)
        } else if (isset($_POST['newIncomeDBCategory'])) {
            insertIncome($_POST['concept'], $_POST['date'], $_POST['amount'], $_POST['newIncomeDBCategory']);        
        }               
    }


    // ----------------------------- FUNCTIONS ------------------------

    // Print confirmation message when data is inserted into DB (used by expenses and investment too)
    function printConfirmationMessage(){
        if (isset($_POST['concept'])) {
            echo "<h2 class='secondary-title'>'".$_POST['concept']."' inserted into the database!</h2>";
        }
    }

    // Print <option> with income categories
    function printIncomeCategories(){
        $queryResult = getUniqueCategories("income");
        while ($row = mysqli_fetch_assoc($queryResult)){
            echo "<option>".$row['category']."</option>";
        }
    }


?>

