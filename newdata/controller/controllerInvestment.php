<?php

    require $_SERVER['DOCUMENT_ROOT'] . "/finances/models/modelInvestment.php";    
    
    // ----------------------------- EXECUTION ON LOAD -----------------
    if (isset($_POST['investmentForm'])){
        if (isset($_POST['share'])){
            // When adding share investment, extra input with share ticket name
            insertInvestment($_POST['categoryInvestment'], $_POST['concept'], $_POST['dateInvestment'], $_POST['amountInvestment'], $_POST['share']);
        } else {
            // When adding the other investment types, this input is empty: ""
            insertInvestment($_POST['categoryInvestment'], $_POST['concept'], $_POST['dateInvestment'], $_POST['amountInvestment'], "");
        }
    }

    // ----------------------------- FUNCTIONS ------------------------

?>