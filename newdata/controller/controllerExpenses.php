<?php
    require $_SERVER['DOCUMENT_ROOT'] . "/finances/models/modelExpenses.php";    
    
    // ----------------------------- EXECUTION ON LOAD -----------------

    // Insert data into DB when post has been sended
    if(isset($_POST['expensesForm'])){        
        // When using an existing category (just insert expenses data)
        if (isset($_POST['dbCategory'])) {
            insertExpenses($_POST['concept'], $_POST['dbCategory'], $_POST['date'], $_POST['amount']);        
        // When using a new category (add it to the DB)
        } else if (isset($_POST['newDBCategory'])) {
            insertExpenses($_POST['concept'], $_POST['newDBCategory'], $_POST['date'], $_POST['amount']);        
        }               
    }

    // ----------------------------- FUNCTIONS ------------------------

    // Function to print the categories stored in the DB
    function printExpensesCategories(){
        $categories = getUniqueCategories("expenses");
        while ($row = mysqli_fetch_assoc($categories)){
            echo "<option>".$row['category']."</option>";
        }
    }


?>