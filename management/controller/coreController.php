<?php
    // --------------- FUNCTIONS USED BY ALL THE CONTROLLERS ----------------- 

    // Function to return order of records to be displayed on the table
    function tableOrder() {
        session_start();
        if (isset($_POST['managementMenu'])) {
            return "date";
        } else if (isset($_POST['order'])) {
            $_SESSION['order'] = $_POST['order'];
            return $_POST['order'];
        } else if (isset($_SESSION['order'])) {
            // if pressed previously during this session
            return $_SESSION['order'];
        } else {
            // Default value: order by date
            return "date";
        }
    }
    // Function to define amount (€) format: xx.xx 
    function moneyFormat($amount){
        // Check normal currency numbers: xx.xx
        if (preg_match('/^[0-9]+(\.[0-9]{2})$/', $amount)){
            return $amount;

        // Check only 1 decimal number: xx.x
        } else if (preg_match('/^[0-9]+(\.[0-9]{1})$/', $amount)){
            return ($amount . "0");

        // Check natural numbers: xx
        } else if (ctype_digit($amount)){
            return ($amount . ".00");

        // Any other result
        } else {
            return 0.00;
        }
    }

    // Function to change the date format from yyyy-mm-dd to dd/mm/yyyy
    function dateFormat($date){
        $finalFormat = DateTime::createFromFormat('Y-m-d', $date)->format('d/m/Y');
        return $finalFormat;
    }

?>
