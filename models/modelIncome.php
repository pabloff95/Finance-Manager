<?php
require_once "coreModel.php";

// Insert expenses data in DB
function insertIncome($income, $date, $amount, $category){
    // conect to DB
    $db = connectDB();
    // Prepare query
    $sql_insert =$db->prepare("INSERT INTO income (income, date, amount, category) VALUES (?, ?, ?, ?)");
    $sql_insert->bind_param("ssis", $income, $date, $amount, $category);
    $sql_insert->execute();
    // Close connections
    $sql_insert->close();
    mysqli_close($db);    
}

// Insert new income category into DB
function insertNewIncomeCategory($category){
    // conect to DB
    $db = connectDB();
    // Prepare query
    $sql_insert =$db->prepare("INSERT INTO categories_income (category) VALUES (?)");
    $sql_insert->bind_param("s", $category);
    $sql_insert->execute();
    // Close connections
    $sql_insert->close();
    mysqli_close($db);    
}

// Get categories for income
function getCategoriesIncome(){
    // conect to DB
    $db = connectDB();   
    // Query
    $sql_select = "SELECT * FROM categories_income";
    $result = mysqli_query($db, $sql_select);
    // Close
    mysqli_close($db);

    return $result;          
}

?>