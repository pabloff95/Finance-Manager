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
            insertNewCategory($_POST['newDBCategory']);
        }               
    }

    // ----------------------------- FUNCTIONS ------------------------

    // Function to print the categories stored in the DB
    function printExpensesCategories(){
        $categories = getCategories();
        while ($row = mysqli_fetch_assoc($categories)){
            echo "<option>".$row['category']."</option>";
        }
    }

    // Print confirmation message when data is inserted into DB
    function printExpensesConfirmationMessage(){
        if (isset($_POST['expensesForm'])) {
            echo "<h2>Data inserted into the database!</h2>";
        }
    }

?>