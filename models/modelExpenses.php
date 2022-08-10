<?php
require_once "coreModel.php";

// Insert expenses data in DB
function insertExpenses($concept, $category, $date, $amount){
    // conect to DB
    $db = connectDB();
    // Prepare query
    $sql_insert =$db->prepare("INSERT INTO expenses (concept, category, date, amount) VALUES (?, ?, ?, ?)");
    $sql_insert->bind_param("sssi", $concept, $category, $date, $amount);
    $sql_insert->execute();
    // Close connections
    $sql_insert->close();
    mysqli_close($db);    
}

// Insert new category into DB
function insertNewCategory($category){
    // conect to DB
    $db = connectDB();
    // Prepare query
    $sql_insert =$db->prepare("INSERT INTO categories_expenses (category) VALUES (?)");
    $sql_insert->bind_param("s", $category);
    $sql_insert->execute();
    // Close connections
    $sql_insert->close();
    mysqli_close($db);    
}

// Retrieve categories from the DB
function getCategories(){
    // conect to DB
    $db = connectDB();
    // Query
    $sql_select = "SELECT * FROM categories_expenses";
    $result = mysqli_query($db, $sql_select);
    // Close connection
    mysqli_close($db);  

    return $result;
}
?>