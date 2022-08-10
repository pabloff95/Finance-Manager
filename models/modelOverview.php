<?php
require_once "modelManagementExpenses.php"; // getExpenses() function
require_once "modelManagementIncome.php"; // getIncome() function
require_once "modelManagementInvestment.php"; // getInvestments() function


// Get total amount of expenses of a given category
function getCategoryAmount($category, $table){
    // conect to DB
    $db = connectDB();
    // Query
    $sql_select = "SELECT SUM(amount) AS amount FROM ".$table." WHERE category ='" . $category. "'";
    $result = mysqli_query($db, $sql_select);
    // Close connection
    mysqli_close($db);  

    return $result;
}

function getCategoryAmountPeriod($category, $table, $from, $to){
    // conect to DB
    $db = connectDB();
    // Query
    $sql_select = "SELECT SUM(amount) AS amount FROM ".$table." WHERE category ='" . $category. "' AND date BETWEEN '".$from."' AND '".$to."' ";
    $result = mysqli_query($db, $sql_select);
    // Close connection
    mysqli_close($db);  

    return $result;
}

// Get all diferent values of categories from table
function getCategories($table){
    // conect to DB
    $db = connectDB();
    // Query
    if (!getPeriod()){ // If period was not defined
        $sql_select = "SELECT DISTINCT category FROM ". $table;
    } else { // If period was defined
        $dates= getPeriod();
        $sql_select = "SELECT DISTINCT category FROM ". $table . " WHERE date BETWEEN '".$dates[0]."' AND '".$dates[1]."'";
    }    
    $result = mysqli_query($db, $sql_select);
    // Close connection
    mysqli_close($db);  

    return $result;
}


// Function to get the data form a given table in a specific time period
function getRecordsToDate($table, $from, $to){
    // conect to DB
    $db = connectDB();
    // Query
    $sql_select = "SELECT * FROM ". $table. " WHERE date BETWEEN '".$from."' AND '".$to."'";
    $result = mysqli_query($db, $sql_select);
    // Close connection
    mysqli_close($db);  

    return $result;
}

// Function to get date from a given category of any table
function getCategoryData($category, $table){
    // conect to DB
    $db = connectDB();
    // Query
    $sql_select = "SELECT * FROM " . $table . " WHERE category = '" . $category . "'";
    $result = mysqli_query($db, $sql_select);
    // Close connection
    mysqli_close($db);  

    return $result;
}

?>

















